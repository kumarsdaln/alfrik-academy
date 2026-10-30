<?php

namespace App\Observers;

use App\Enums\ActivityEvent;
use App\Models\Payment;
use App\Support\Activity\DispatchesUserActivity;

class PaymentObserver
{
    use DispatchesUserActivity;

    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        // A payment record may be created already paid or failed.
        $this->recordStatusActivity($payment, true);
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        if (! $payment->wasChanged('status')) {
            return;
        }

        $this->recordStatusActivity($payment);
    }

    /**
     * Record activity for meaningful payment status transitions.
     */
    private function recordStatusActivity(
        Payment $payment,
        bool $created = false,
    ): void {
        $status = strtolower((string) $payment->status);

        $activity = match ($status) {
            'paid', 'completed', 'succeeded' => [
                'event' => ActivityEvent::PAYMENT_COMPLETED,
                'description' => 'Payment completed successfully',
            ],
            'failed' => [
                'event' => ActivityEvent::PAYMENT_FAILED,
                'description' => 'Payment failed',
            ],
            'refunded' => [
                'event' => ActivityEvent::PAYMENT_REFUNDED,
                'description' => 'Payment refunded',
            ],
            default => null,
        };

        if ($activity === null) {
            return;
        }

        // Do not treat an already-existing paid/failed/refunded record
        // as a new transition unless it was created in that final state.
        $this->recordActivity(
            subject: $payment,
            event: $activity['event'],
            category: 'payments',
            description: $activity['description'],
            properties: [
                'payment_id' => $payment->getKey(),
                'course_id' => $payment->course_id,
                'cohort_id' => $payment->cohort_id,
                'amount_minor' => $payment->amount_minor,
                'currency' => $payment->currency,
                'status' => $status,
            ],
            userId: $payment->user_id
                ? (int) $payment->user_id
                : null,
        );
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}