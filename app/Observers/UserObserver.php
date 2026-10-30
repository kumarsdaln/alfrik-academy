<?php

namespace App\Observers;

use App\Enums\ActivityEvent;
use App\Events\ActivityOccurred;
use App\Models\User;
use App\Support\Activity\DispatchesUserActivity;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    use DispatchesUserActivity;

    private const TRACKED_PROFILE_FIELDS = [
        'name',
        'bio',
        'avatar_path',
    ];

    /**
     * Handle user creation.
     */
    public function created(User $user): void
    {
        $actor = Auth::user();

        ActivityOccurred::dispatch(
            event: $actor && $actor->id !== $user->id
                ? 'admin.user_created'
                : 'account.created',
            category: $actor && $actor->id !== $user->id
                ? 'administration'
                : 'account',
            description: $actor && $actor->id !== $user->id
                ? 'Created a user account'
                : 'Created an account',
            actor: $actor,
            subject: $user,
            properties: [
                'created_user_id' => $user->getKey(),
            ],
        );
    }

    /**
     * Handle user updates.
     */
    public function updated(User $user): void
    {
        $changes = array_keys($user->getChanges());

        $profileFields = array_values(array_intersect(
            $changes,
            self::TRACKED_PROFILE_FIELDS,
        ));

        if ($profileFields !== []) {
            $this->recordActivity(
                subject: $user,
                event: in_array('avatar_path', $profileFields, true)
                    ? ActivityEvent::PROFILE_AVATAR_UPDATED
                    : ActivityEvent::PROFILE_UPDATED,
                category: 'account',
                description: 'Updated profile information',
                properties: [
                    'changed_fields' => $profileFields,
                ],
                userId: (int) $user->getKey(),
            );
        }

        if (in_array('is_active', $changes, true)) {
            $this->recordActivity(
                subject: $user,
                event: $user->is_active
                    ? ActivityEvent::USER_ACTIVATED
                    : ActivityEvent::USER_DEACTIVATED,
                category: 'administration',
                description: $user->is_active
                    ? 'User account activated'
                    : 'User account deactivated',
                properties: [
                    'affected_user_id' => $user->getKey(),
                ],
            );
        }
    }

    /**
     * Handle soft deletion or ordinary deletion.
     */
    public function deleted(User $user): void
    {
        $this->recordActivity(
            subject: $user,
            event: 'account.deleted',
            category: 'account',
            description: 'Account deleted',
            properties: [
                'affected_user_id' => $user->getKey(),
            ],
            userId: (int) $user->getKey(),
        );
    }

    /**
     * Handle account restoration after soft deletion.
     */
    public function restored(User $user): void
    {
        $this->recordActivity(
            subject: $user,
            event: 'account.restored',
            category: 'account',
            description: 'Account restored',
            properties: [
                'affected_user_id' => $user->getKey(),
            ],
            userId: (int) $user->getKey(),
        );
    }

    /**
     * Handle permanent deletion.
     */
    public function forceDeleted(User $user): void
    {
        // Do not create a user-owned activity here: the user may
        // already have been deleted, and its foreign key may be null.
        ActivityOccurred::dispatch(
            event: 'account.permanently_deleted',
            category: 'administration',
            description: 'User account permanently deleted',
            actor: Auth::user(),
            subject: null,
            properties: [
                'deleted_user_id' => $user->getKey(),
            ],
        );
    }
}