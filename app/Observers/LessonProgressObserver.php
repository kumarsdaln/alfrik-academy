<?php

namespace App\Observers;

use App\Enums\ActivityEvent;
use App\Models\LessonProgress;
use App\Support\Activity\DispatchesUserActivity;

class LessonProgressObserver
{
    use DispatchesUserActivity;

    /**
     * Handle the LessonProgress "created" event.
     */
    public function created(LessonProgress $lessonProgress): void
    {
        // A progress record may be created already completed.
        if ($lessonProgress->completed_at === null) {
            return;
        }

        $this->recordActivity(
            subject: $lessonProgress,
            event: ActivityEvent::LESSON_COMPLETED,
            category: 'learning',
            description: 'Completed a lesson',
            properties: [
                'lesson_id' => $lessonProgress->lesson_id,
            ],
        );
    }

    /**
     * Handle the LessonProgress "updated" event.
     */
    public function updated(LessonProgress $lessonProgress): void
    {
        // Only record the transition from incomplete to complete.
        if (
            ! $lessonProgress->wasChanged('completed_at')
            || $lessonProgress->getOriginal('completed_at') !== null
            || $lessonProgress->completed_at === null
        ) {
            return;
        }

        $this->recordActivity(
            subject: $lessonProgress,
            event: ActivityEvent::LESSON_COMPLETED,
            category: 'learning',
            description: 'Completed a lesson',
            properties: [
                'lesson_id' => $lessonProgress->lesson_id,
            ],
        );
    }

    /**
     * Handle the LessonProgress "deleted" event.
     */
    public function deleted(LessonProgress $lessonProgress): void
    {
        //
    }

    /**
     * Handle the LessonProgress "restored" event.
     */
    public function restored(LessonProgress $lessonProgress): void
    {
        //
    }

    /**
     * Handle the LessonProgress "force deleted" event.
     */
    public function forceDeleted(LessonProgress $lessonProgress): void
    {
        //
    }
}