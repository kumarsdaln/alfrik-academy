<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PlatformNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly string $title,
        public readonly string $body,
        public readonly string $url,
        public readonly string $category = 'learning',
    ) {}

    public function via(object $notifiable): array
    {
        $preference = match ($this->category) {
            'session' => 'class_reminders',
            'assignment' => 'assignment_feedback',
            'event' => 'event_updates',
            default => 'academy_updates',
        };

        return ($notifiable->notification_preferences[$preference] ?? true) ? ['database'] : [];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url,
            'category' => $this->category,
        ];
    }
}
