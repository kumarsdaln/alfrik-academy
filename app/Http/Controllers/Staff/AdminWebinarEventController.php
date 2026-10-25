<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\WebinarEvent;
use App\Models\WebinarRegistration;
use App\Support\Images\ImageUpload;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class AdminWebinarEventController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Staff/Manage/Events', [
            'events' => WebinarEvent::query()->withCount([
                'registrations as registered_count' => fn ($query) => $query->whereIn('status', ['registered', 'attended']),
                'registrations as waitlisted_count' => fn ($query) => $query->where('status', 'waitlisted'),
            ])->orderByDesc('starts_at')->orderByDesc('id')->paginate(20)->withQueryString(),
        ]);
    }

    public function show(WebinarEvent $webinarEvent): Response
    {
        return Inertia::render('Staff/Manage/Event', [
            'event' => $webinarEvent->loadCount('registrations'),
            'registrations' => $webinarEvent->registrations()->latest('registered_at')->paginate(50),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $baseSlug = Str::slug($data['title']);
        $data['slug'] = $data['slug'] ?: (WebinarEvent::query()->where('slug', $baseSlug)->exists() ? $baseSlug.'-'.Str::lower(Str::random(5)) : $baseSlug);
        $data['created_by'] = $request->user()->id;
        $data['published_at'] = $data['status'] === 'published' ? now() : null;
        $data['price_minor'] = (int) round(((float) $data['price']) * 100);
        unset($data['price']);
        $data['currency'] = strtolower($data['currency']);
        $data['cover_image'] = ImageUpload::store($request, 'cover_upload', 'events', 1600, 900) ?? $data['cover_image'] ?? null;
        unset($data['cover_upload']);
        $event = WebinarEvent::query()->create($data);

        return to_route('staff.manage.events.edit', $event)->with('success', 'Event created.');
    }

    public function update(Request $request, WebinarEvent $webinarEvent): RedirectResponse
    {
        $data = $this->validated($request, $webinarEvent);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['published_at'] = in_array($data['status'], ['published', 'completed'], true) ? ($webinarEvent->published_at ?? now()) : null;
        $data['price_minor'] = (int) round(((float) $data['price']) * 100);
        unset($data['price']);
        $data['currency'] = strtolower($data['currency']);
        if ($path = ImageUpload::store($request, 'cover_upload', 'events', 1600, 900)) {
            ImageUpload::deleteManaged($webinarEvent->getRawOriginal('cover_image'), 'events');
            $data['cover_image'] = $path;
        } else {
            $data['cover_image'] = $webinarEvent->getRawOriginal('cover_image');
        }
        unset($data['cover_upload']);
        $webinarEvent->update($data);

        return back()->with('success', 'Event details updated.');
    }

    public function updateRegistration(Request $request, WebinarEvent $webinarEvent, WebinarRegistration $registration): RedirectResponse
    {
        abort_unless($registration->webinar_event_id === $webinarEvent->id, 404);
        $data = $request->validate(['status' => ['required', Rule::in(['registered', 'waitlisted', 'attended', 'cancelled'])]]);
        abort_if(in_array($data['status'], ['registered', 'attended'], true) && $registration->amount_minor > 0 && ! in_array($registration->payment_status, ['paid', 'bypassed'], true), 422, 'A paid ticket must be confirmed by Stripe before admission.');
        DB::transaction(function () use ($webinarEvent, $registration, $data) {
            $event = WebinarEvent::query()->lockForUpdate()->findOrFail($webinarEvent->id);
            if (in_array($data['status'], ['registered', 'attended'], true) && ! in_array($registration->status, ['registered', 'attended'], true) && $event->capacity !== null) {
                $count = $event->registrations()->where(function ($query) {
                    $query->whereIn('status', ['registered', 'attended'])
                        ->orWhere(fn ($pending) => $pending->where('status', 'pending_payment')->where('expires_at', '>', now()));
                })->count();
                abort_if($count >= $event->capacity, 422, 'This event has reached its seat capacity. Increase capacity first.');
            }
            $registration->update($data);
        });

        return back()->with('success', 'Attendee status updated.');
    }

    private function validated(Request $request, ?WebinarEvent $event = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'alpha_dash', 'max:190', Rule::unique('webinar_events', 'slug')->ignore($event?->id)],
            'event_type' => ['required', Rule::in(['webinar', 'workshop', 'open_class', 'community_event'])],
            'summary' => ['required', 'string', 'max:500'], 'description' => ['required', 'string', 'min:20', 'max:30000'],
            'cover_image' => ['nullable', 'string', 'max:2048'], 'cover_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], 'starts_at' => ['required', 'date_format:Y-m-d\\TH:i'],
            'timezone' => ['required', 'timezone'], 'duration_minutes' => ['required', 'integer', 'min:15', 'max:720'],
            'host_name' => ['required', 'string', 'max:180'], 'host_title' => ['nullable', 'string', 'max:180'],
            'meeting_url' => ['nullable', 'url', 'max:2048'], 'replay_url' => ['nullable', 'url', 'max:2048'],
            'capacity' => ['nullable', 'integer', 'min:1', 'max:100000'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'currency' => ['required', Rule::in(['INR', 'USD', 'EUR', 'GBP'])],
            'status' => ['required', Rule::in(['draft', 'published', 'cancelled', 'completed'])],
        ]);
        $data['starts_at'] = CarbonImmutable::parse($data['starts_at'], $data['timezone'])->utc();

        return $data;
    }
}




