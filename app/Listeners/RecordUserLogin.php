<?php

namespace App\Listeners;

use App\Events\ActivityOccurred;
use App\Services\Activity\ActivityLogger;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecordUserLogin
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
    public function handle(Login $event): void
    {
        $this->logger->log(
            event: 'auth.login',
            category: 'authentication',
            description: 'Signed in to the account',
            properties: [
                'guard' => $event->guard,
                'remember' => $event->remember,
            ],
            user: $event->user,
        );
    }
}
