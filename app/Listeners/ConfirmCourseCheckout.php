<?php

namespace App\Listeners;

use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\WebinarEvent;
use App\Models\WebinarRegistration;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Events\WebhookReceived;

class ConfirmCourseCheckout
{
    public function handle(WebhookReceived $event): void
    {
        $payload = $event->payload;
        $type = $payload['type'] ?? '';
        $session = $payload['data']['object'] ?? [];
        if ($type === 'charge.refunded' && ($session['refunded'] ?? false) && ! empty($session['payment_intent'])) {
            DB::transaction(function () use ($session) {
                $registration = WebinarRegistration::query()->where('stripe_payment_intent_id', $session['payment_intent'])->lockForUpdate()->first();
                if ($registration && $registration->payment_status === 'paid') {
                    $registration->update(['status' => 'cancelled', 'payment_status' => 'refunded']);

                    return;
                }

                $payment = Payment::query()->where('stripe_payment_intent_id', $session['payment_intent'])->lockForUpdate()->first();
                if (! $payment || $payment->status !== 'paid') {
                    return;
                }

                $payment->update(['status' => 'refunded']);
                Enrollment::query()->where('user_id', $payment->user_id)->where('course_id', $payment->course_id)
                    ->update(['status' => 'revoked', 'payment_status' => 'refunded', 'updated_at' => now()]);
            });

            return;
        }
        if (str_starts_with($type, 'checkout.session.') && ($session['metadata']['purchase_type'] ?? null) === 'webinar_event') {
            $registrationId = filter_var($session['metadata']['registration_id'] ?? null, FILTER_VALIDATE_INT);
            if (! $registrationId) {
                return;
            }

            DB::transaction(function () use ($type, $session, $registrationId) {
                $registration = WebinarRegistration::query()->with('event')->lockForUpdate()->find($registrationId);
                if (! $registration || $registration->stripe_checkout_session_id !== ($session['id'] ?? null)) {
                    return;
                }

                if (in_array($type, ['checkout.session.expired', 'checkout.session.async_payment_failed'], true)) {
                    if ($registration->payment_status === 'pending') {
                        $registration->update(['status' => 'payment_failed', 'payment_status' => $type === 'checkout.session.expired' ? 'expired' : 'failed']);
                    }

                    return;
                }
                if (! in_array($type, ['checkout.session.completed', 'checkout.session.async_payment_succeeded'], true)) {
                    return;
                }

                $event = $registration->event;
                $received = (int) ($session['amount_total'] ?? 0);
                if (($session['payment_status'] ?? null) !== 'paid'
                    || (string) ($session['client_reference_id'] ?? '') !== (string) $registration->id
                    || $received !== (int) $registration->amount_minor
                    || strtolower((string) ($session['currency'] ?? '')) !== strtolower($registration->currency)
                    || (string) ($session['metadata']['user_id'] ?? '') !== (string) $registration->user_id
                    || (string) ($session['metadata']['event_id'] ?? '') !== (string) $registration->webinar_event_id
                    || ! $event) {
                    return;
                }
                if ($registration->payment_status === 'paid') {
                    return;
                }

                if (in_array($registration->status, ['cancelled', 'waitlisted'], true)) {
                    $registration->update([
                        'payment_status' => 'paid',
                        'stripe_payment_intent_id' => $session['payment_intent'] ?? null,
                        'paid_at' => now(),
                    ]);

                    return;
                }

                $event = WebinarEvent::query()->lockForUpdate()->find($registration->webinar_event_id);
                if (! $event || ($event->capacity !== null && $event->registrations()->whereIn('status', ['registered', 'attended'])->where('id', '<>', $registration->id)->count() >= $event->capacity)) {
                    $registration->update(['payment_status' => 'paid', 'status' => 'waitlisted', 'stripe_payment_intent_id' => $session['payment_intent'] ?? null, 'paid_at' => now()]);

                    return;
                }

                $receiptUrl = null;
                if (! empty($session['payment_intent']) && $registration->user) {
                    try {
                        $intent = $registration->user->stripe()->paymentIntents->retrieve($session['payment_intent'], ['expand' => ['latest_charge']]);
                        $receiptUrl = $intent->latest_charge?->receipt_url;
                    } catch (\Throwable $exception) {
                        report($exception);
                    }
                }

                $registration->update([
                    'status' => 'registered', 'payment_status' => 'paid',
                    'stripe_payment_intent_id' => $session['payment_intent'] ?? null,
                    'receipt_url' => $receiptUrl, 'paid_at' => now(),
                ]);
            });

            return;
        }
        if (! str_starts_with($type, 'checkout.session.') || ! isset($session['metadata']['payment_id'])) {
            return;
        }

        $paymentId = filter_var($session['metadata']['payment_id'], FILTER_VALIDATE_INT);
        if (! $paymentId) {
            return;
        }

        DB::transaction(function () use ($type, $session, $paymentId) {
            $payment = Payment::query()->lockForUpdate()->find($paymentId);
            if (! $payment || $payment->stripe_checkout_session_id !== ($session['id'] ?? null)) {
                return;
            }

            if (in_array($type, ['checkout.session.expired', 'checkout.session.async_payment_failed'], true)) {
                if ($payment->status === 'pending') {
                    $payment->update(['status' => $type === 'checkout.session.expired' ? 'expired' : 'failed']);
                }

                return;
            }

            if (! in_array($type, ['checkout.session.completed', 'checkout.session.async_payment_succeeded'], true)) {
                return;
            }

            $expected = (int) $payment->amount_minor;
            $received = (int) ($session['amount_total'] ?? 0);
            if (($session['payment_status'] ?? null) !== 'paid'
                || (string) ($session['client_reference_id'] ?? '') !== (string) $payment->id
                || $received !== $expected
                || strtolower((string) ($session['currency'] ?? '')) !== strtolower($payment->currency)
                || (string) ($session['metadata']['user_id'] ?? '') !== (string) $payment->user_id
                || (string) ($session['metadata']['course_id'] ?? '') !== (string) $payment->course_id) {
                return;
            }

            if ($payment->status === 'paid') {
                return;
            }

            $receiptUrl = null;
            if (! empty($session['payment_intent'])) {
                try {
                    $intent = $payment->user->stripe()->paymentIntents->retrieve($session['payment_intent'], ['expand' => ['latest_charge']]);
                    $receiptUrl = $intent->latest_charge?->receipt_url;
                } catch (\Throwable $exception) {
                    report($exception);
                }
            }

            $payment->update([
                'status' => 'paid',
                'stripe_payment_intent_id' => $session['payment_intent'] ?? null,
                'receipt_url' => $receiptUrl,
                'paid_at' => now(),
            ]);

            $enrollment = Enrollment::query()->firstOrNew([
                'user_id' => $payment->user_id,
                'course_id' => $payment->course_id,
            ]);

            $enrollment->fill([
                'cohort_id' => $payment->cohort_id,
                'status' => 'active',
                'payment_status' => 'paid',
                'enrolled_at' => now(),
            ])->save();
        });
    }
}
