<?php

namespace App\Listeners;

use App\Events\ActivityOccurred;
use App\Services\Activity\ActivityLogger;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecordUserLogout
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
    public function handle(Logout $event): void
    {
        $this->logger->log(
            event: 'auth.logout',
            category: 'authentication',
            description: 'Signed out to the account',
            properties: [
                'guard' => $event->guard,
            ],
            user: $event->user,
        );
    }
}
