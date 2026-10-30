<?php

namespace App\Observers;

use App\Enums\ActivityEvent;
use App\Models\QuizAttempt;
use App\Support\Activity\DispatchesUserActivity;

class QuizAttemptObserver
{
    use DispatchesUserActivity;

    /**
     * Handle the QuizAttempt "created" event.
     */
    public function created(QuizAttempt $quizAttempt): void
    {
        // Record only if the attempt was created as submitted.
        if ($quizAttempt->submitted_at === null) {
            return;
        }

        $this->recordActivity(
            subject: $quizAttempt,
            event: ActivityEvent::QUIZ_SUBMITTED,
            category: 'learning',
            description: 'Submitted a quiz',
            properties: [
                'quiz_id' => $quizAttempt->quiz_id,
            ],
        );
    }

    /**
     * Handle the QuizAttempt "updated" event.
     */
    public function updated(QuizAttempt $quizAttempt): void
    {
        // Ignore updates unrelated to submission.
        if (
            ! $quizAttempt->wasChanged('submitted_at')
            || $quizAttempt->getOriginal('submitted_at') !== null
            || $quizAttempt->submitted_at === null
        ) {
            return;
        }

        $this->recordActivity(
            subject: $quizAttempt,
            event: ActivityEvent::QUIZ_SUBMITTED,
            category: 'learning',
            description: 'Submitted a quiz',
            properties: [
                'quiz_id' => $quizAttempt->quiz_id,
            ],
        );
    }

    /**
     * Handle the QuizAttempt "deleted" event.
     */
    public function deleted(QuizAttempt $quizAttempt): void
    {
        //
    }

    /**
     * Handle the QuizAttempt "restored" event.
     */
    public function restored(QuizAttempt $quizAttempt): void
    {
        //
    }

    /**
     * Handle the QuizAttempt "force deleted" event.
     */
    public function forceDeleted(QuizAttempt $quizAttempt): void
    {
        //
    }
}