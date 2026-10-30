<?php

namespace App\Observers;

use App\Enums\ActivityEvent;
use App\Models\WebinarRegistration;
use App\Support\Activity\DispatchesUserActivity;

class WebinarRegistrationObserver
{
    use DispatchesUserActivity;

    /**
     * Handle the WebinarRegistration "created" event.
     */
    public function created(
        WebinarRegistration $webinarRegistration
    ): void {
        $this->recordRegistration($webinarRegistration);
    }

    /**
     * Handle the WebinarRegistration "updated" event.
     */
    public function updated(
        WebinarRegistration $webinarRegistration
    ): void {
        // Record cancellation only when status changes to cancelled.
        if (
            $webinarRegistration->wasChanged('status')
            && $webinarRegistration->status === 'cancelled'
        ) {
            $this->recordActivity(
                subject: $webinarRegistration,
                event: ActivityEvent::EVENT_REGISTRATION_CANCELLED,
                category: 'events',
                description: 'Cancelled a webinar registration',
                properties: [
                    'webinar_event_id' =>
                        $webinarRegistration->webinar_event_id,
                ],
                userId: $webinarRegistration->user_id
                    ? (int) $webinarRegistration->user_id
                    : null,
            );

            return;
        }

        // Record payment only when payment_status changes to paid.
        if (
            $webinarRegistration->wasChanged('payment_status')
            && $webinarRegistration->payment_status === 'paid'
        ) {
            $this->recordActivity(
                subject: $webinarRegistration,
                event: ActivityEvent::EVENT_PAYMENT_COMPLETED,
                category: 'payments',
                description: 'Completed webinar registration payment',
                properties: [
                    'webinar_event_id' =>
                        $webinarRegistration->webinar_event_id,
                    'amount_minor' => $webinarRegistration->amount_minor,
                    'currency' => $webinarRegistration->currency,
                ],
                userId: $webinarRegistration->user_id
                    ? (int) $webinarRegistration->user_id
                    : null,
            );
        }
    }

    /**
     * Record a new webinar registration.
     */
    private function recordRegistration(
        WebinarRegistration $webinarRegistration
    ): void {
        // Guest registrations have no user timeline.
        if (! $webinarRegistration->user_id) {
            return;
        }

        $this->recordActivity(
            subject: $webinarRegistration,
            event: ActivityEvent::EVENT_REGISTERED,
            category: 'events',
            description: 'Registered for a webinar',
            properties: [
                'webinar_event_id' =>
                    $webinarRegistration->webinar_event_id,
            ],
            userId: (int) $webinarRegistration->user_id,
        );
    }

    /**
     * Handle the WebinarRegistration "deleted" event.
     */
    public function deleted(
        WebinarRegistration $webinarRegistration
    ): void {
        //
    }

    /**
     * Handle the WebinarRegistration "restored" event.
     */
    public function restored(
        WebinarRegistration $webinarRegistration
    ): void {
        //
    }

    /**
     * Handle the WebinarRegistration "force deleted" event.
     */
    public function forceDeleted(
        WebinarRegistration $webinarRegistration
    ): void {
        //
    }
}