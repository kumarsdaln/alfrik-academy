<?php

namespace App\Http\Controllers;

use App\Models\WebinarEvent;
use App\Models\WebinarRegistration;
use App\Notifications\PlatformNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Cashier\Checkout;

class WebinarEventController extends Controller
{
    public function index(): Response
    {
        $published = WebinarEvent::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        $upcomingCount = (clone $published)
            ->where('starts_at', '>=', now())
            ->count();

        $publicColumns = [
            'id',
            'title',
            'slug',
            'event_type',
            'summary',
            'cover_image',
            'starts_at',
            'timezone',
            'duration_minutes',
            'host_name',
            'host_title',
            'capacity',
            'price_minor',
            'currency',
            'published_at',
        ];

        $upcomingQuery = (clone $published)
            ->where('starts_at', '>=', now())
            ->select($publicColumns)
            ->withCount([
                'registrations as registered_count' => fn ($query) =>
                    $query->whereIn('status', ['registered', 'attended']),
            ])
            ->orderBy('starts_at')
            ->orderBy('id');

        $past = WebinarEvent::query()
            ->whereIn('status', ['published', 'completed'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('starts_at', '<', now())
            ->select($publicColumns)
            ->latest('starts_at')
            ->limit(6)
            ->get();

        return Inertia::render('Events/Index', [
            'upcoming' => Inertia::scroll(
                fn () => $upcomingQuery->cursorPaginate(9)->withQueryString()
            ),
            'upcomingCount' => $upcomingCount,
            'past' => $past,
        ]);
    }

    public function show(Request $request, WebinarEvent $event): Response
    {
        abort_unless(
            in_array($event->status, ['published', 'completed'], true)
                && $event->published_at !== null
                && $event->published_at->lte(now()),
            404
        );

        $user = $request->user();

        $registration = $user
            ? $event->registrations()
                ->where(fn ($query) => $query
                    ->where('user_id', $user->id)
                    ->orWhereRaw('lower(email) = ?', [
                        mb_strtolower($user->email),
                    ]))
                ->latest('id')
                ->first()
            : null;

        $state = $registration?->status;
        $paymentStatus = $registration?->payment_status;

        $hasSeat = in_array($state, ['registered', 'attended'], true)
            && in_array($paymentStatus, [
                'not_required',
                'paid',
                'bypassed',
            ], true);

        $isPast = $event->starts_at->isPast();

        $checkoutUrl = $paymentStatus === 'pending'
            && $registration?->expires_at?->isFuture()
                ? $registration->checkout_url
                : null;

        return Inertia::render('Events/Show', [
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'slug' => $event->slug,
                'event_type' => $event->event_type,
                'summary' => $event->summary,
                'description' => $event->description,
                'cover_image' => $event->cover_image,
                'starts_at' => $event->starts_at,
                'timezone' => $event->timezone,
                'duration_minutes' => $event->duration_minutes,
                'host_name' => $event->host_name,
                'host_title' => $event->host_title,
                'capacity' => $event->capacity,
                'price_minor' => (int) $event->price_minor,
                'currency' => strtoupper($event->currency),

                'development_payment_bypass' => app()->environment('local')
                    && ! $this->stripePaymentsConfigured(),

                'registered_count' => $event->registrations()
                    ->where(fn ($query) => $query
                        ->whereIn('status', ['registered', 'attended'])
                        ->orWhere(fn ($pending) => $pending
                            ->where('status', 'pending_payment')
                            ->where('expires_at', '>', now())))
                    ->count(),

                'registration_state' => $state,
                'payment_status' => $paymentStatus,
                'checkout_url' => $checkoutUrl,

                // Private event links are provided only to eligible attendees.
                'meeting_url' => $hasSeat && ! $isPast
                    ? $event->meeting_url
                    : null,

                'replay_url' => $hasSeat && $isPast
                    ? $event->replay_url
                    : null,

                'is_upcoming' => $event->starts_at->isFuture(),

                'login_url' => route('login', [
                    'next' => route('events.show', $event->slug, false),
                ]),

                'register_url' => route('register', [
                    'next' => route('events.show', $event->slug, false),
                ]),

                'attendee_name' => $user?->name,
                'checkout_returned' => $request->query('checkout') === 'success',
            ],
        ]);
    }

    public function register(
        Request $request,
        WebinarEvent $event
    ): RedirectResponse {
        $user = $request->user();

        abort_unless($user && $user->is_active, 403);

        abort_unless(
            $event->status === 'published'
                && $event->published_at !== null
                && $event->published_at->lte(now())
                && $event->starts_at->isFuture(),
            404
        );

        $data = $request->validate([
            'company' => ['nullable', 'string', 'max:180'],
            'question' => ['nullable', 'string', 'max:1500'],
        ]);

        [$registration, $checkoutRequired] = DB::transaction(
            function () use ($event, $data, $user) {
                $lockedEvent = WebinarEvent::query()
                    ->lockForUpdate()
                    ->findOrFail($event->id);

                // Recheck event availability after acquiring the lock.
                abort_unless(
                    $lockedEvent->status === 'published'
                        && $lockedEvent->published_at !== null
                        && $lockedEvent->published_at->lte(now())
                        && $lockedEvent->starts_at->isFuture(),
                    404
                );

                $registration = WebinarRegistration::query()
                    ->where('webinar_event_id', $lockedEvent->id)
                    ->where(fn ($query) => $query
                        ->where('user_id', $user->id)
                        ->orWhereRaw('lower(email) = ?', [
                            mb_strtolower($user->email),
                        ]))
                    ->lockForUpdate()
                    ->first();

                if ($registration && in_array(
                    $registration->payment_status,
                    ['paid', 'refunded'],
                    true
                )) {
                    return [$registration, false];
                }

                if ($registration && in_array(
                    $registration->status,
                    ['registered', 'attended', 'waitlisted'],
                    true
                )) {
                    return [$registration, false];
                }

                if (
                    $registration?->payment_status === 'pending'
                    && $registration->expires_at?->isFuture()
                    && filled($registration->checkout_url)
                ) {
                    return [$registration, true];
                }

                // A pending Stripe session must be resolved by the payment
                // webhook rather than replaced with another checkout.
                if (
                    $registration?->payment_status === 'pending'
                    && filled($registration->stripe_checkout_session_id)
                ) {
                    return [$registration, false];
                }

                $occupied = $lockedEvent->registrations()
                    ->where(fn ($query) => $query
                        ->whereIn('status', ['registered', 'attended'])
                        ->orWhere(fn ($pending) => $pending
                            ->where('status', 'pending_payment')
                            ->where('expires_at', '>', now())))
                    ->count();

                $isFull = $lockedEvent->capacity !== null
                    && $occupied >= $lockedEvent->capacity;

                if ($isFull) {
                    $registration ??= new WebinarRegistration();

                    $registration->fill([
                        'webinar_event_id' => $lockedEvent->id,
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => mb_strtolower($user->email),
                        'company' => $data['company'] ?? null,
                        'question' => $data['question'] ?? null,
                        'status' => 'waitlisted',
                        'payment_status' => 'not_required',
                        'amount_minor' => 0,
                        'currency' => strtolower($lockedEvent->currency),
                        'registered_at' => now(),
                    ])->save();

                    return [$registration, false];
                }

                $paid = (int) $lockedEvent->price_minor > 0;
                $stripeConfigured = $this->stripePaymentsConfigured();

                $skipPayment = $paid
                    && app()->environment('local')
                    && ! $stripeConfigured;

                $checkoutRequired = $paid && ! $skipPayment;

                if ($paid && ! $skipPayment && ! $stripeConfigured) {
                    throw ValidationException::withMessages([
                        'payment' => 'Online event payments are not configured yet. Please contact the academy.',
                    ]);
                }

                $registration ??= new WebinarRegistration();

                $registration->fill([
                    'webinar_event_id' => $lockedEvent->id,
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => mb_strtolower($user->email),
                    'company' => $data['company'] ?? null,
                    'question' => $data['question'] ?? null,
                    'status' => $checkoutRequired
                        ? 'pending_payment'
                        : 'registered',
                    'payment_status' => $skipPayment
                        ? 'bypassed'
                        : ($paid ? 'pending' : 'not_required'),
                    'amount_minor' => $paid
                        ? $lockedEvent->price_minor
                        : 0,
                    'currency' => strtolower($lockedEvent->currency),
                    'registered_at' => now(),
                    'expires_at' => $paid
                        ? now()->addMinutes(30)
                        : null,
                    'checkout_url' => null,
                    'stripe_checkout_session_id' => null,
                    'stripe_payment_intent_id' => null,
                    'receipt_url' => null,
                    'paid_at' => null,
                ])->save();

                return [$registration, $checkoutRequired];
            }
        );

        if ($registration->wasRecentlyCreated) {
            $user->notify(new PlatformNotification(
                $registration->status === 'waitlisted'
                    ? 'You joined the event waitlist'
                    : 'Your event registration is saved',
                $registration->status === 'waitlisted'
                    ? 'We’ll let you know if a seat opens for “'.$event->title.'”.'
                    : '“'.$event->title.'” is now listed in your Events & webinars panel.',
                route('events.show', ['event' => $event->slug], false),
                'event',
            ));
        }

        if ($registration->status === 'waitlisted') {
            return to_route('events.show', $event->slug)
                ->with('success', 'You are on the waitlist. We will update you if a place opens.');
        }

        if ($registration->status === 'cancelled') {
            return to_route('events.show', $event->slug)
                ->withErrors([
                    'registration' => 'This registration has been cancelled. Contact the academy if you need help.',
                ]);
        }

        if ($registration->status === 'pending_payment') {
            if (
                $registration->checkout_url
                && $registration->expires_at?->isFuture()
            ) {
                return redirect()->away($registration->checkout_url, 303);
            }

            // Stripe is still processing an existing checkout session.
            if (filled($registration->stripe_checkout_session_id)) {
                return to_route('events.show', $event->slug)
                    ->with('success', 'Stripe is still confirming your payment. Refresh this page shortly.');
            }
        }

        if (! $checkoutRequired) {
            return to_route('events.show', $event->slug)
                ->with('success', 'Your place is reserved. Your class details are ready below.');
        }

        try {
            $checkout = Checkout::customer($user)->create([[
                'price_data' => [
                    'currency' => strtolower($registration->currency),
                    'unit_amount' => (int) $registration->amount_minor,
                    'product_data' => ['name' => $event->title],
                ],
                'quantity' => 1,
            ]], [
                'mode' => 'payment',
                'client_reference_id' => (string) $registration->id,
                'metadata' => [
                    'purchase_type' => 'webinar_event',
                    'registration_id' => (string) $registration->id,
                    'event_id' => (string) $event->id,
                    'user_id' => (string) $user->id,
                ],
                'success_url' => route('events.show', $event->slug, true)
                    .'?checkout=success',
                'cancel_url' => route('events.show', $event->slug, true)
                    .'?checkout=cancelled',
                'expires_at' => now()->addMinutes(30)->timestamp,
            ])->asStripeCheckoutSession();

            $registration->update([
                'stripe_checkout_session_id' => $checkout->id,
                'checkout_url' => $checkout->url,
            ]);

            return redirect()->away($checkout->url, 303);
        } catch (\Throwable $exception) {
            $registration->update([
                'status' => 'payment_failed',
                'payment_status' => 'failed',
                'expires_at' => now(),
            ]);

            report($exception);

            return to_route('events.show', $event->slug)
                ->withErrors([
                    'payment' => 'We could not start checkout. Please try again.',
                ]);
        }
    }

    private function stripePaymentsConfigured(): bool
    {
        return filled(config('cashier.key'))
            && filled(config('cashier.secret'))
            && filled(config('cashier.webhook.secret'));
    }
}
