<?php

namespace App\Observers;

use App\Enums\ActivityEvent;
use App\Models\AssignmentSubmission;
use App\Support\Activity\DispatchesUserActivity;

class AssignmentSubmissionObserver
{
    use DispatchesUserActivity;

    /**
     * Handle the AssignmentSubmission "created" event.
     */
    public function created(
        AssignmentSubmission $assignmentSubmission
    ): void {
        if ($assignmentSubmission->submitted_at === null) {
            return;
        }

        $this->recordActivity(
            subject: $assignmentSubmission,
            event: ActivityEvent::ASSIGNMENT_SUBMITTED,
            category: 'learning',
            description: 'Submitted an assignment',
            properties: [
                'assignment_id' => $assignmentSubmission->assignment_id,
            ],
        );
    }

    /**
     * Handle the AssignmentSubmission "updated" event.
     */
    public function updated(
        AssignmentSubmission $assignmentSubmission
    ): void {
        // Record a submission or resubmission.
        if (
            $assignmentSubmission->wasChanged('submitted_at')
            && $assignmentSubmission->submitted_at !== null
        ) {
            $this->recordActivity(
                subject: $assignmentSubmission,
                event: ActivityEvent::ASSIGNMENT_SUBMITTED,
                category: 'learning',
                description: 'Submitted or resubmitted an assignment',
                properties: [
                    'assignment_id' => $assignmentSubmission->assignment_id,
                ],
            );

            return;
        }

        // Record grading only when the assignment is actually graded.
        if (
            $assignmentSubmission->wasChanged('graded_at')
            && $assignmentSubmission->graded_at !== null
        ) {
            $this->recordActivity(
                subject: $assignmentSubmission,
                event: ActivityEvent::ASSIGNMENT_GRADED,
                category: 'learning',
                description: 'Your assignment was graded',
                properties: [
                    'assignment_id' => $assignmentSubmission->assignment_id,
                    'score' => $assignmentSubmission->score,
                ],
                userId: (int) $assignmentSubmission->user_id,
            );
        }
    }

    /**
     * Handle the AssignmentSubmission "deleted" event.
     */
    public function deleted(
        AssignmentSubmission $assignmentSubmission
    ): void {
        //
    }

    /**
     * Handle the AssignmentSubmission "restored" event.
     */
    public function restored(
        AssignmentSubmission $assignmentSubmission
    ): void {
        //
    }

    /**
     * Handle the AssignmentSubmission "force deleted" event.
     */
    public function forceDeleted(
        AssignmentSubmission $assignmentSubmission
    ): void {
        //
    }
}