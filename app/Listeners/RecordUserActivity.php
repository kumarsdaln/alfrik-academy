<?php

namespace App\Listeners;

use App\Events\ActivityOccurred;
use App\Services\Activity\ActivityLogger;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecordUserActivity
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly ActivityLogger $logger,
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ActivityOccurred $event): void
    {
        $this->logger->log(
            event: $event->event,
            category: $event->category,
            description: $event->description,
            subject: $event->subject,
            properties: $event->properties,
            user: $event->actor,
        );
    }
}
