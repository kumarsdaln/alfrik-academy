<?php

namespace App\Observers;

use App\Models\Insight;
use App\Support\Activity\DispatchesUserActivity;

class InsightObserver
{
    use DispatchesUserActivity;

    /**
     * Handle the Insight "created" event.
     */
    public function created(Insight $insight): void
    {
        $this->recordPublicationIfNeeded($insight, true);
    }

    /**
     * Handle the Insight "updated" event.
     */
    public function updated(Insight $insight): void
    {
        if (! $insight->wasChanged('status')) {
            return;
        }

        $this->recordPublicationIfNeeded($insight);
    }

    /**
     * Record publication only when the insight is published.
     */
    private function recordPublicationIfNeeded(
        Insight $insight,
        bool $created = false,
    ): void {
        if ($insight->status !== 'published') {
            return;
        }

        // Avoid treating unrelated updates as a new publication.
        if (! $created && ! $insight->wasChanged('status')) {
            return;
        }

        $this->recordActivity(
            subject: $insight,
            event: 'insight.published',
            category: 'content',
            description: 'Published an insight',
            properties: [
                'insight_id' => $insight->getKey(),
                'type' => $insight->type,
            ],
            userId: $insight->author_id
                ? (int) $insight->author_id
                : null,
        );
    }

    public function deleted(Insight $insight): void
    {
        //
    }

    public function restored(Insight $insight): void
    {
        //
    }

    public function forceDeleted(Insight $insight): void
    {
        //
    }
}