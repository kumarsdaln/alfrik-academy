<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('webinar_events', function (Blueprint $table) {
            $table->unsignedInteger('price_minor')->default(0);
            $table->char('currency', 3)->default('usd');
        });

        Schema::table('webinar_registrations', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('webinar_event_id')->constrained()->nullOnDelete();
            $table->string('payment_status')->default('not_required')->index();
            $table->unsignedInteger('amount_minor')->default(0);
            $table->char('currency', 3)->default('usd');
            $table->string('stripe_checkout_session_id')->nullable()->unique();
            $table->string('stripe_payment_intent_id')->nullable()->unique();
            $table->text('checkout_url')->nullable();
            $table->text('receipt_url')->nullable();
            $table->timestampTz('paid_at')->nullable();
            $table->timestampTz('expires_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('webinar_registrations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique(['stripe_checkout_session_id']);
            $table->dropUnique(['stripe_payment_intent_id']);
            $table->dropIndex(['payment_status']);
            $table->dropColumn(['user_id', 'payment_status', 'amount_minor', 'currency', 'stripe_checkout_session_id', 'stripe_payment_intent_id', 'checkout_url', 'receipt_url', 'paid_at', 'expires_at']);
        });

        Schema::table('webinar_events', function (Blueprint $table) {
            $table->dropColumn(['price_minor', 'currency']);
        });
    }
};
