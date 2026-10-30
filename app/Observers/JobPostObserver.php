<?php

namespace App\Observers;

use App\Models\JobPost;
use App\Support\Activity\DispatchesUserActivity;

class JobPostObserver
{
    use DispatchesUserActivity;

    /**
     * Handle the JobPost "created" event.
     */
    public function created(JobPost $jobPost): void
    {
        if ($jobPost->status !== 'published') {
            return;
        }

        $this->recordPublication($jobPost, true);
    }

    /**
     * Handle the JobPost "updated" event.
     */
    public function updated(JobPost $jobPost): void
    {
        if (! $jobPost->wasChanged('status')) {
            return;
        }

        $this->recordPublication($jobPost);
    }

    /**
     * Record publication status transitions.
     */
    private function recordPublication(
        JobPost $jobPost,
        bool $created = false,
    ): void {
        $status = $jobPost->status;

        if (! $created && ! in_array($status, ['published', 'draft'], true)) {
            return;
        }

        if ($created && $status !== 'published') {
            return;
        }

        $isPublished = $status === 'published';

        $this->recordActivity(
            subject: $jobPost,
            event: $isPublished
                ? 'job_post.published'
                : 'job_post.unpublished',
            category: 'careers',
            description: $isPublished
                ? 'Published a job post'
                : 'Unpublished a job post',
            properties: [
                'job_post_id' => $jobPost->getKey(),
                'title' => $jobPost->title,
            ],
            userId: $jobPost->posted_by
                ? (int) $jobPost->posted_by
                : null,
        );
    }

    public function deleted(JobPost $jobPost): void
    {
        //
    }

    public function restored(JobPost $jobPost): void
    {
        //
    }

    public function forceDeleted(JobPost $jobPost): void
    {
        //
    }
}