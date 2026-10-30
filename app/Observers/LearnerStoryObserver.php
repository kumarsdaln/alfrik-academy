<?php

namespace App\Observers;

use App\Models\LearnerStory;
use App\Support\Activity\DispatchesUserActivity;
use Illuminate\Support\Facades\Auth;

class LearnerStoryObserver
{
    use DispatchesUserActivity;

    /**
     * Handle the LearnerStory "created" event.
     */
    public function created(LearnerStory $learnerStory): void
    {
        if ($learnerStory->status !== 'published') {
            return;
        }

        $this->recordPublication($learnerStory, true);
    }

    /**
     * Handle the LearnerStory "updated" event.
     */
    public function updated(LearnerStory $learnerStory): void
    {
        if (! $learnerStory->wasChanged('status')) {
            return;
        }

        $this->recordPublication($learnerStory);
    }

    /**
     * Record story publication changes.
     */
    private function recordPublication(
        LearnerStory $learnerStory,
        bool $created = false,
    ): void {
        if (! $created && ! in_array(
            $learnerStory->status,
            ['published', 'draft'],
            true,
        )) {
            return;
        }

        $isPublished = $learnerStory->status === 'published';

        $this->recordActivity(
            subject: $learnerStory,
            event: $isPublished
                ? 'learner_story.published'
                : 'learner_story.unpublished',
            category: 'content',
            description: $isPublished
                ? 'Published a learner success story'
                : 'Unpublished a learner success story',
            properties: [
                'learner_story_id' => $learnerStory->getKey(),
                'course_id' => $learnerStory->course_id,
                'slug' => $learnerStory->slug,
            ],
            userId: Auth::id(),
        );
    }

    public function deleted(LearnerStory $learnerStory): void
    {
        //
    }

    public function restored(LearnerStory $learnerStory): void
    {
        //
    }

    public function forceDeleted(LearnerStory $learnerStory): void
    {
        //
    }
}