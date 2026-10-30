<?php

namespace App\Observers;

use App\Enums\ActivityEvent;
use App\Models\Enrollment;
use App\Support\Activity\DispatchesUserActivity;

class EnrollmentObserver
{
    use DispatchesUserActivity;
    /**
     * Handle the Enrollment "created" event.
     */
    public function created(Enrollment $enrollment): void
    {
        $this->recordActivity(
            subject: $enrollment,
            event: ActivityEvent::COURSE_ENROLLED,
            category: 'learning',
            description: 'Enrolled in a course',
            properties: [
                'course_id' => $enrollment->course_id,
                'status' => $enrollment->status,
            ],
        );
    }

    /**
     * Handle the Enrollment "updated" event.
     */
    public function updated(Enrollment $enrollment): void
    {
        if (
            ! $enrollment->wasChanged('status')
            || $enrollment->status !== 'completed'
        ) {
            return;
        }

        $this->recordActivity(
            subject: $enrollment,
            event: ActivityEvent::COURSE_COMPLETED,
            category: 'learning',
            description: 'Completed a course',
            properties: [
                'course_id' => $enrollment->course_id,
            ],
        );
    }

    /**
     * Handle the Enrollment "deleted" event.
     */
    public function deleted(Enrollment $enrollment): void
    {
        //
    }

    /**
     * Handle the Enrollment "restored" event.
     */
    public function restored(Enrollment $enrollment): void
    {
        //
    }

    /**
     * Handle the Enrollment "force deleted" event.
     */
    public function forceDeleted(Enrollment $enrollment): void
    {
        //
    }
}
