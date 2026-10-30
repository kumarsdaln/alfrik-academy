<?php

namespace App\Services\Activity;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public function log(
        string $event,
        string $category,
        string $description,
        ?Model $subject = null,
        array $properties = [],
        ?User $user = null,
    ): UserActivity {
        $actor = $user ?? Auth::user();

        return UserActivity::query()->create([
            'user_id' => $actor?->id,
            'event' => $event,
            'category' => $category,
            'description' => $description,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject !== null
                ? (string) $subject->getKey()
                : null,
            'properties' => $properties !== []
                ? $properties
                : null,
            'occurred_at' => now(),
        ]);
    }
}
