<?php

namespace App\Support\Activity;

use App\Enums\ActivityEvent;
use App\Events\ActivityOccurred;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait DispatchesUserActivity
{
    protected function recordActivity(
        Model $subject,
        string $event,
        string $category,
        string $description,
        array $properties = [],
        ?int $userId = null,
    ): void {
        $userId ??= isset($subject->user_id)
            ? (int) $subject->user_id
            : null;

        $actor = $userId
            ? User::query()->find($userId)
            : Auth::user();

        ActivityOccurred::dispatch(
            event: $event,
            category: $category,
            description: $description,
            actor: $actor,
            subject: $subject,
            properties: $properties,
        );
    }
}
