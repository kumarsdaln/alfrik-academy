<?php

namespace App\Observers;

use App\Models\WebinarEvent;
use App\Support\Activity\DispatchesUserActivity;

class WebinarEventObserver
{
    use DispatchesUserActivity;

    /**
     * Handle the WebinarEvent "created" event.
     */
    public function created(WebinarEvent $webinarEvent): void
    {
        if ($webinarEvent->status !== 'published') {
            return;
        }

        $this->recordPublication($webinarEvent, true);
    }

    /**
     * Handle the WebinarEvent "updated" event.
     */
    public function updated(WebinarEvent $webinarEvent): void
    {
        if (! $webinarEvent->wasChanged('status')) {
            return;
        }

        $this->recordPublication($webinarEvent);
    }

    /**
     * Record webinar publication status transitions.
     */
    private function recordPublication(
        WebinarEvent $webinarEvent,
        bool $created = false,
    ): void {
        $status = $webinarEvent->status;

        if (! $created && ! in_array($status, ['published', 'draft'], true)) {
            return;
        }

        if ($created && $status !== 'published') {
            return;
        }

        $isPublished = $status === 'published';

        $this->recordActivity(
            subject: $webinarEvent,
            event: $isPublished
                ? 'event.published'
                : 'event.unpublished',
            category: 'events',
            description: $isPublished
                ? 'Published a webinar'
                : 'Unpublished a webinar',
            properties: [
                'webinar_event_id' => $webinarEvent->getKey(),
                'title' => $webinarEvent->title,
            ],
            userId: $webinarEvent->created_by
                ? (int) $webinarEvent->created_by
                : null,
        );
    }

    public function deleted(WebinarEvent $webinarEvent): void
    {
        //
    }

    public function restored(WebinarEvent $webinarEvent): void
    {
        //
    }

    public function forceDeleted(WebinarEvent $webinarEvent): void
    {
        //
    }
}