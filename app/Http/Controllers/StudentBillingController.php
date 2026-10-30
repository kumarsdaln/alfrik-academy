<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\WebinarRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Cashier\Checkout;

class StudentBillingController extends Controller
{
    public function checkout(Request $request, string $slug): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user && $user->hasRole('student'), 403);

        $validated = $request->validate([
            'cohort_id' => ['nullable', 'integer', 'min:1'],
        ]);

        abort_if(
            ! filled(config('cashier.secret')),
            503,
            'Online payments are not configured yet.'
        );

        [$course, $payment] = DB::transaction(function () use (
            $slug,
            $user,
            $validated
        ) {
            $course = Course::query()
                ->where('slug', $slug)
                ->where('status', 'published')
                ->lockForUpdate()
                ->firstOrFail();

            abort_if(
                (int) $course->price_minor < 1,
                422,
                'This course is not available for online purchase.'
            );

            if (
                $user->enrollments()
                    ->where('course_id', $course->id)
                    ->where('status', 'active')
                    ->exists()
            ) {
                throw ValidationException::withMessages([
                    'course' => 'You already have access to this course.',
                ]);
            }

            // Only an unexpired pending payment should block another checkout.
            $hasPendingPayment = Payment::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('status', 'pending')
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                })
                ->exists();

            if ($hasPendingPayment) {
                throw ValidationException::withMessages([
                    'payment' => 'A checkout for this course is already in progress. Check Purchases & receipts for its status.',
                ]);
            }

            $hasOpenCohorts = $course->cohorts()
                ->where('status', 'open')
                ->exists();

            if ($hasOpenCohorts && empty($validated['cohort_id'])) {
                throw ValidationException::withMessages([
                    'cohort_id' => 'Choose an available live cohort before continuing.',
                ]);
            }

            $cohort = null;

            if (! empty($validated['cohort_id'])) {
                $cohort = $course->cohorts()
                    ->whereKey($validated['cohort_id'])
                    ->where('status', 'open')
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($cohort->capacity !== null) {
                    $active = $cohort->enrollments()
                        ->where('status', 'active')
                        ->count();

                    $pending = Payment::query()
                        ->where('cohort_id', $cohort->id)
                        ->where('status', 'pending')
                        ->where(function ($query) {
                            $query->whereNull('expires_at')
                                ->orWhere('expires_at', '>', now());
                        })
                        ->count();

                    if ($active + $pending >= $cohort->capacity) {
                        throw ValidationException::withMessages([
                            'cohort_id' => 'This cohort is full. Please choose another cohort.',
                        ]);
                    }
                }
            }

            $payment = Payment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'cohort_id' => $cohort?->id,
                'amount_minor' => $course->price_minor,
                'currency' => strtolower($course->currency),
                'status' => 'pending',
                'expires_at' => now()->addMinutes(30),
            ]);

            return [$course, $payment];
        });

        try {
            $checkout = Checkout::customer($user)->create([
                [
                    'price_data' => [
                        'currency' => strtolower($course->currency),
                        'unit_amount' => (int) $course->price_minor,
                        'product_data' => [
                            'name' => $course->title,
                        ],
                    ],
                    'quantity' => 1,
                ],
            ], [
                'mode' => 'payment',
                'client_reference_id' => (string) $payment->id,
                'metadata' => [
                    'payment_id' => (string) $payment->id,
                    'user_id' => (string) $user->id,
                    'course_id' => (string) $course->id,
                ],
                'success_url' => route(
                    'learn.purchases.return',
                    [],
                    true
                ).'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route(
                    'courses.show',
                    $course->slug,
                    true
                ).'?checkout=cancelled',
                'expires_at' => now()->addMinutes(30)->timestamp,
            ])->asStripeCheckoutSession();

            $payment->update([
                'stripe_checkout_session_id' => $checkout->id,
                'checkout_url' => $checkout->url,
            ]);

            return redirect()->away($checkout->url, 303);
        } catch (\Throwable $exception) {
            $payment->update([
                'status' => 'failed',
                'expires_at' => now(),
            ]);

            report($exception);

            return redirect()
                ->route('courses.show', $course->slug)
                ->withErrors([
                    'payment' => 'We could not start checkout. Please try again.',
                ]);
        }
    }

    public function purchases(Request $request): Response
    {
        $user = $request->user();

        $payments = $user->payments()
            ->with(['course', 'cohort'])
            ->latest()
            ->paginate(12)
            ->through(function (Payment $payment) {
                $status = $payment->status === 'pending'
                    && $payment->expires_at?->isPast()
                        ? 'expired'
                        : $payment->status;

                $checkoutIsUsable = $status === 'pending'
                    && $payment->expires_at?->isFuture();

                return [
                    'id' => $payment->id,
                    'course' => $payment->course?->title,
                    'slug' => $payment->course?->slug,
                    'cohort' => $payment->cohort?->name,
                    'amount' => (int) $payment->amount_minor,
                    'currency' => strtoupper($payment->currency),
                    'status' => $status,
                    'paidAt' => $payment->paid_at?->toIso8601String(),
                    'receiptUrl' => $status === 'paid'
                        ? $payment->receipt_url
                        : null,
                    'checkoutUrl' => $checkoutIsUsable
                        ? $payment->checkout_url
                        : null,
                    'expiresAt' => $payment->expires_at?->toIso8601String(),
                ];
            });

        $eventTickets = $user->webinarRegistrations()
            ->with('event')
            ->whereIn('payment_status', [
                'paid',
                'pending',
                'failed',
                'expired',
                'refunded',
                'bypassed',
            ])
            ->latest('registered_at')
            ->limit(30)
            ->get()
            ->map(function (WebinarRegistration $registration) {
                $status = $registration->payment_status === 'pending'
                    && $registration->expires_at?->isPast()
                        ? 'expired'
                        : $registration->payment_status;

                $checkoutIsUsable = $status === 'pending'
                    && $registration->expires_at?->isFuture();

                return [
                    'id' => $registration->id,
                    'title' => $registration->event?->title ?? 'Alfrik event',
                    'slug' => $registration->event?->slug,
                    'amount' => (int) $registration->amount_minor,
                    'currency' => strtoupper($registration->currency),
                    'status' => $status,
                    'paidAt' => $registration->paid_at?->toIso8601String(),
                    'receiptUrl' => $status === 'paid'
                        ? $registration->receipt_url
                        : null,
                    'checkoutUrl' => $checkoutIsUsable
                        ? $registration->checkout_url
                        : null,
                    'expiresAt' => $registration->expires_at?->toIso8601String(),
                ];
            });

        return Inertia::render('Learning/Purchases', [
            'payments' => $payments,
            'eventTickets' => $eventTickets,
        ]);
    }

    public function events(Request $request): Response
    {
        $user = $request->user();

        $registrations = WebinarRegistration::query()
            ->with('event')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere(function ($legacy) use ($user) {
                        $legacy->whereNull('user_id')
                            ->whereRaw(
                                'lower(email) = ?',
                                [mb_strtolower($user->email)]
                            );
                    });
            })
            ->latest('registered_at')
            ->get()
            ->unique('webinar_event_id')
            ->filter(function (WebinarRegistration $registration) {
                $event = $registration->event;

                return $event !== null
                    && in_array(
                        $event->status,
                        ['published', 'completed'],
                        true
                    )
                    && $event->published_at?->lte(now());
            })
            ->map(function (WebinarRegistration $registration) {
                $event = $registration->event;
                $paymentStatus = $registration->payment_status;

                if (
                    $paymentStatus === 'pending'
                    && $registration->expires_at?->isPast()
                ) {
                    $paymentStatus = 'expired';
                }

                $admitted = in_array(
                    $registration->status,
                    ['registered', 'attended'],
                    true
                ) && in_array(
                    $paymentStatus,
                    ['not_required', 'paid', 'bypassed'],
                    true
                );

                $isPast = $event->starts_at->isPast();

                return [
                    'id' => $registration->id,
                    'title' => $event->title,
                    'slug' => $event->slug,
                    'type' => str($event->event_type)
                        ->replace('_', ' ')
                        ->title()
                        ->toString(),
                    'summary' => $event->summary,
                    'cover' => $event->cover_image,
                    'startsAt' => $event->starts_at
                        ->timezone($event->timezone)
                        ->toIso8601String(),
                    'timezone' => $event->timezone,
                    'duration' => $event->duration_minutes,
                    'host' => $event->host_name,
                    'registrationStatus' => $registration->status,
                    'paymentStatus' => $paymentStatus,
                    'amount' => (int) $registration->amount_minor,
                    'currency' => strtoupper($registration->currency),
                    'isPast' => $isPast,
                    'meetingUrl' => $admitted && ! $isPast
                        ? $event->meeting_url
                        : null,
                    'replayUrl' => $admitted && $isPast
                        ? $event->replay_url
                        : null,
                    'checkoutUrl' => $paymentStatus === 'pending'
                        && $registration->expires_at?->isFuture()
                            ? $registration->checkout_url
                            : null,
                ];
            })
            ->sortBy('startsAt')
            ->values();

        return Inertia::render('Learning/Events', [
            'events' => $registrations,
        ]);
    }

    public function activity(Request $request): Response
    {
        $user = $request->user();

        /*
         * Use explicit PostgreSQL types for every branch of the UNION.
         * This prevents NULL columns and differing numeric types from
         * producing "UNION types ... cannot be matched" errors.
         *
         * All branches return the same column order and compatible types:
         * id, type, occurred_at, subject, context, course_slug, score,
         * amount_minor, currency, registration_status, payment_status.
         */
        $streams = [
            DB::table('enrollments')
                ->join('courses', 'courses.id', '=', 'enrollments.course_id')
                ->where('enrollments.user_id', $user->id)
                ->selectRaw("
                    CAST(enrollments.id AS BIGINT) AS id,
                    CAST('enrollment' AS TEXT) AS type,
                    CAST(enrollments.created_at AS TIMESTAMPTZ) AS occurred_at,
                    CAST(courses.title AS TEXT) AS subject,
                    CAST(NULL AS TEXT) AS context,
                    CAST(courses.slug AS TEXT) AS course_slug,
                    CAST(NULL AS NUMERIC) AS score,
                    CAST(NULL AS BIGINT) AS amount_minor,
                    CAST(NULL AS TEXT) AS currency,
                    CAST(NULL AS TEXT) AS registration_status,
                    CAST(NULL AS TEXT) AS payment_status
                "),

            DB::table('lesson_progress')
                ->join('lessons', 'lessons.id', '=', 'lesson_progress.lesson_id')
                ->join('course_modules', 'course_modules.id', '=', 'lessons.course_module_id')
                ->join('courses', 'courses.id', '=', 'course_modules.course_id')
                ->where('lesson_progress.user_id', $user->id)
                ->whereNotNull('lesson_progress.completed_at')
                ->selectRaw("
                    CAST(lessons.id AS BIGINT) AS id,
                    CAST('lesson' AS TEXT) AS type,
                    CAST(lesson_progress.completed_at AS TIMESTAMPTZ) AS occurred_at,
                    CAST(lessons.title AS TEXT) AS subject,
                    CAST(courses.title AS TEXT) AS context,
                    CAST(courses.slug AS TEXT) AS course_slug,
                    CAST(NULL AS NUMERIC) AS score,
                    CAST(NULL AS BIGINT) AS amount_minor,
                    CAST(NULL AS TEXT) AS currency,
                    CAST(NULL AS TEXT) AS registration_status,
                    CAST(NULL AS TEXT) AS payment_status
                "),

            DB::table('assignment_submissions')
                ->join('assignments', 'assignments.id', '=', 'assignment_submissions.assignment_id')
                ->join('courses', 'courses.id', '=', 'assignments.course_id')
                ->where('assignment_submissions.user_id', $user->id)
                ->whereNotNull('assignment_submissions.submitted_at')
                ->selectRaw("
                    CAST(assignment_submissions.id AS BIGINT) AS id,
                    CAST('assignment' AS TEXT) AS type,
                    CAST(assignment_submissions.submitted_at AS TIMESTAMPTZ) AS occurred_at,
                    CAST(assignments.title AS TEXT) AS subject,
                    CAST(courses.title AS TEXT) AS context,
                    CAST(courses.slug AS TEXT) AS course_slug,
                    CAST(NULL AS NUMERIC) AS score,
                    CAST(NULL AS BIGINT) AS amount_minor,
                    CAST(NULL AS TEXT) AS currency,
                    CAST(NULL AS TEXT) AS registration_status,
                    CAST(NULL AS TEXT) AS payment_status
                "),

            DB::table('quiz_attempts')
                ->join('quizzes', 'quizzes.id', '=', 'quiz_attempts.quiz_id')
                ->join('courses', 'courses.id', '=', 'quizzes.course_id')
                ->where('quiz_attempts.user_id', $user->id)
                ->whereNotNull('quiz_attempts.submitted_at')
                ->selectRaw("
                    CAST(quiz_attempts.id AS BIGINT) AS id,
                    CAST('quiz' AS TEXT) AS type,
                    CAST(quiz_attempts.submitted_at AS TIMESTAMPTZ) AS occurred_at,
                    CAST(quizzes.title AS TEXT) AS subject,
                    CAST(courses.title AS TEXT) AS context,
                    CAST(courses.slug AS TEXT) AS course_slug,
                    CAST(quiz_attempts.score_percent AS NUMERIC) AS score,
                    CAST(NULL AS BIGINT) AS amount_minor,
                    CAST(NULL AS TEXT) AS currency,
                    CAST(NULL AS TEXT) AS registration_status,
                    CAST(NULL AS TEXT) AS payment_status
                "),

            DB::table('session_attendance')
                ->join('live_sessions', 'live_sessions.id', '=', 'session_attendance.live_session_id')
                ->join('cohorts', 'cohorts.id', '=', 'live_sessions.cohort_id')
                ->join('courses', 'courses.id', '=', 'cohorts.course_id')
                ->where('session_attendance.user_id', $user->id)
                ->whereNotNull('session_attendance.joined_at')
                ->selectRaw("
                    CAST(session_attendance.id AS BIGINT) AS id,
                    CAST('live' AS TEXT) AS type,
                    CAST(session_attendance.joined_at AS TIMESTAMPTZ) AS occurred_at,
                    CAST(live_sessions.title AS TEXT) AS subject,
                    CAST(courses.title AS TEXT) AS context,
                    CAST(courses.slug AS TEXT) AS course_slug,
                    CAST(NULL AS NUMERIC) AS score,
                    CAST(NULL AS BIGINT) AS amount_minor,
                    CAST(NULL AS TEXT) AS currency,
                    CAST(NULL AS TEXT) AS registration_status,
                    CAST(NULL AS TEXT) AS payment_status
                "),

            DB::table('job_applications')
                ->join('job_posts', 'job_posts.id', '=', 'job_applications.job_post_id')
                ->where('job_applications.user_id', $user->id)
                ->selectRaw("
                    CAST(job_applications.id AS BIGINT) AS id,
                    CAST('application' AS TEXT) AS type,
                    CAST(job_applications.submitted_at AS TIMESTAMPTZ) AS occurred_at,
                    CAST(job_posts.title AS TEXT) AS subject,
                    CAST(job_posts.company AS TEXT) AS context,
                    CAST(NULL AS TEXT) AS course_slug,
                    CAST(NULL AS NUMERIC) AS score,
                    CAST(NULL AS BIGINT) AS amount_minor,
                    CAST(NULL AS TEXT) AS currency,
                    CAST(NULL AS TEXT) AS registration_status,
                    CAST(NULL AS TEXT) AS payment_status
                "),

            DB::table('webinar_registrations')
                ->join('webinar_events', 'webinar_events.id', '=', 'webinar_registrations.webinar_event_id')
                ->where(function ($query) use ($user) {
                    $query->where('webinar_registrations.user_id', $user->id)
                        ->orWhere(function ($legacy) use ($user) {
                            $legacy->whereNull('webinar_registrations.user_id')
                                ->whereRaw(
                                    'lower(webinar_registrations.email) = ?',
                                    [mb_strtolower($user->email)]
                                );
                        });
                })
                ->selectRaw("
                    CAST(webinar_registrations.id AS BIGINT) AS id,
                    CAST('event' AS TEXT) AS type,
                    CAST(webinar_registrations.registered_at AS TIMESTAMPTZ) AS occurred_at,
                    CAST(webinar_events.title AS TEXT) AS subject,
                    CAST(NULL AS TEXT) AS context,
                    CAST(NULL AS TEXT) AS course_slug,
                    CAST(NULL AS NUMERIC) AS score,
                    CAST(NULL AS BIGINT) AS amount_minor,
                    CAST(NULL AS TEXT) AS currency,
                    CAST(webinar_registrations.status AS TEXT) AS registration_status,
                    CAST(webinar_registrations.payment_status AS TEXT) AS payment_status
                "),

            DB::table('payments')
                ->join('courses', 'courses.id', '=', 'payments.course_id')
                ->where('payments.user_id', $user->id)
                ->where('payments.status', 'paid')
                ->whereNotNull('payments.paid_at')
                ->selectRaw("
                    CAST(payments.id AS BIGINT) AS id,
                    CAST('payment' AS TEXT) AS type,
                    CAST(payments.paid_at AS TIMESTAMPTZ) AS occurred_at,
                    CAST(courses.title AS TEXT) AS subject,
                    CAST(NULL AS TEXT) AS context,
                    CAST(courses.slug AS TEXT) AS course_slug,
                    CAST(NULL AS NUMERIC) AS score,
                    CAST(payments.amount_minor AS BIGINT) AS amount_minor,
                    CAST(payments.currency AS TEXT) AS currency,
                    CAST(NULL AS TEXT) AS registration_status,
                    CAST(NULL AS TEXT) AS payment_status
                "),
        ];

        $combined = array_shift($streams);

        foreach ($streams as $stream) {
            $combined->unionAll($stream);
        }

        $activity = DB::query()
            ->fromSub($combined, 'activity')
            ->orderByDesc('occurred_at')
            ->orderByDesc('type')
            ->orderByDesc('id')
            ->cursorPaginate(25)
            ->withQueryString()
            ->through(function ($row) {
                $title = match ($row->type) {
                    'enrollment' => 'Joined '.$row->subject,
                    'lesson' => 'Completed '.$row->subject,
                    'assignment' => 'Submitted '.$row->subject,
                    'quiz' => 'Completed '.$row->subject,
                    'live' => 'Attended '.$row->subject,
                    'application' => 'Applied for '.$row->subject,
                    'event' => in_array(
                        $row->payment_status,
                        ['paid', 'refunded'],
                        true
                    )
                        ? 'Purchased a ticket for '.$row->subject
                        : (
                            $row->registration_status === 'cancelled'
                                ? 'Registration cancelled for '.$row->subject
                                : (
                                    $row->registration_status === 'pending_payment'
                                        ? 'Checkout started for '.$row->subject
                                        : 'Registered for '.$row->subject
                                )
                        ),
                    'payment' => 'Purchased '.$row->subject,
                    default => $row->subject,
                };

                $detail = match ($row->type) {
                    'enrollment' => 'Course enrollment',
                    'event' => $row->registration_status === 'waitlisted'
                        ? 'Event waitlist'
                        : (
                            $row->payment_status === 'refunded'
                                ? 'Ticket payment refunded'
                                : 'Alfrik event'
                        ),
                    'payment' => strtoupper((string) $row->currency)
                        .' '.number_format(((int) $row->amount_minor) / 100, 2),
                    'quiz' => $row->context.' · '.($row->score ?? 0).'% score',
                    default => $row->context,
                };

                return [
                    'id' => $row->id,
                    'type' => $row->type,
                    'title' => $title,
                    'detail' => $detail,
                    'courseSlug' => $row->course_slug,
                    'at' => $row->occurred_at,
                ];
            });

        return Inertia::render('Learning/Activity', [
            'activity' => Inertia::scroll($activity),
        ]);
    }

    public function checkoutReturn(Request $request): RedirectResponse
    {
        $sessionId = (string) $request->query('session_id', '');

        abort_unless(
            preg_match('/^cs_(test|live)_[A-Za-z0-9]+$/', $sessionId) === 1,
            404
        );

        $payment = $request->user()
            ->payments()
            ->where('stripe_checkout_session_id', $sessionId)
            ->firstOrFail();

        // A browser redirect is not proof of payment. The Stripe webhook
        // remains responsible for verifying and updating the payment.
        return redirect()
            ->route('learn.purchases')
            ->with(
                'success',
                $payment->status === 'paid'
                    ? 'Payment confirmed. Your course is ready.'
                    : 'Checkout returned. Stripe is confirming the payment; access appears as soon as it is verified.'
            );
    }
}