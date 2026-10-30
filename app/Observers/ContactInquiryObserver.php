<?php

namespace App\Observers;

use App\Models\ContactInquiry;
use App\Support\Activity\DispatchesUserActivity;

class ContactInquiryObserver
{
    use DispatchesUserActivity;

    /**
     * Handle the ContactInquiry "created" event.
     */
    public function created(ContactInquiry $inquiry): void
    {
        // Contact inquiries may come from guests, so don't automatically
        // attach them to a user activity timeline.
        // Record the submission in your audit or inquiry workflow instead.
    }

    /**
     * Handle the ContactInquiry "updated" event.
     */
    public function updated(ContactInquiry $inquiry): void
    {
        if (! $inquiry->wasChanged('status')) {
            return;
        }

        if ($inquiry->status !== 'handled') {
            return;
        }

        // ContactInquiry has no guaranteed user_id in the supplied schema.
        // Keep this as an operational activity rather than attributing it
        // to an arbitrary user.
        //
        // Record it explicitly from the admin workflow with the actual
        // administrator as actor, or use audit_events.
    }

    public function deleted(ContactInquiry $inquiry): void
    {
        //
    }

    public function restored(ContactInquiry $inquiry): void
    {
        //
    }

    public function forceDeleted(ContactInquiry $inquiry): void
    {
        //
    }
}