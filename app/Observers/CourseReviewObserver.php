<?php

namespace App\Observers;

use App\Enums\ActivityEvent;
use App\Models\CourseReview;
use App\Support\Activity\DispatchesUserActivity;

class CourseReviewObserver
{
    use DispatchesUserActivity;

    /**
     * Handle the CourseReview "created" event.
     */
    public function created(CourseReview $courseReview): void
    {
        $this->recordActivity(
            subject: $courseReview,
            event: ActivityEvent::COURSE_REVIEW_SUBMITTED,
            category: 'learning',
            description: 'Submitted a course review',
            properties: [
                'course_id' => $courseReview->course_id,
                'rating' => $courseReview->rating,
            ],
                userId: (int) $courseReview->user_id,
        );
    }

    /**
     * Handle the CourseReview "updated" event.
     */
    public function updated(CourseReview $courseReview): void
    {
        if (! $courseReview->wasChanged('is_published')) {
            return;
        }

        // Record publication changes without exposing review content.
        $this->recordActivity(
            subject: $courseReview,
            event: $courseReview->is_published
                ? 'course_review.published'
                : 'course_review.unpublished',
            category: 'administration',
            description: $courseReview->is_published
                ? 'Published a course review'
                : 'Unpublished a course review',
            properties: [
                'course_id' => $courseReview->course_id,
                'review_id' => $courseReview->getKey(),
            ],
        );
    }

    public function deleted(CourseReview $courseReview): void
    {
        //
    }

    public function restored(CourseReview $courseReview): void
    {
        //
    }

    public function forceDeleted(CourseReview $courseReview): void
    {
        //
    }
}