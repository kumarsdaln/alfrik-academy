<?php

namespace App\Observers;

use App\Enums\ActivityEvent;
use App\Models\JobApplication;
use App\Support\Activity\DispatchesUserActivity;

class JobApplicationObserver
{
    use DispatchesUserActivity;

    /**
     * Handle the JobApplication "created" event.
     */
    public function created(JobApplication $jobApplication): void
    {
        $this->recordActivity(
            subject: $jobApplication,
            event: ActivityEvent::JOB_APPLICATION_SUBMITTED,
            category: 'careers',
            description: 'Submitted a job application',
            properties: [
                'job_post_id' => $jobApplication->job_post_id,
            ],
            userId: (int) $jobApplication->user_id,
        );
    }

    /**
     * Handle the JobApplication "updated" event.
     */
    public function updated(JobApplication $jobApplication): void
    {
        if (! $jobApplication->wasChanged('status')) {
            return;
        }

        $this->recordActivity(
            subject: $jobApplication,
            event: ActivityEvent::JOB_APPLICATION_STATUS_CHANGED,
            category: 'careers',
            description: 'Job application status updated',
            properties: [
                'job_post_id' => $jobApplication->job_post_id,
                'status' => $jobApplication->status,
            ],
            userId: (int) $jobApplication->user_id,
        );
    }

    /**
     * Handle the JobApplication "deleted" event.
     */
    public function deleted(JobApplication $jobApplication): void
    {
        //
    }

    /**
     * Handle the JobApplication "restored" event.
     */
    public function restored(JobApplication $jobApplication): void
    {
        //
    }

    /**
     * Handle the JobApplication "force deleted" event.
     */
    public function forceDeleted(JobApplication $jobApplication): void
    {
        //
    }
}