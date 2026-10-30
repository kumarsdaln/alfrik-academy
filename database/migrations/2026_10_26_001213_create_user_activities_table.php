<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Actor: nullable for guest or system activities.
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Examples: auth.login, profile.updated, course.enrolled
            $table->string('event', 100);
            $table->string('category', 50);

            // Human-readable description captured at event time.
            $table->string('description', 255);

            // Related entity, without a foreign key to every module.
            $table->string('subject_type', 100)->nullable();
            $table->string('subject_id', 100)->nullable();

            // Additional event-specific data.
            $table->jsonb('properties')->nullable();

            // When the action occurred.
            $table->timestampTz('occurred_at')->useCurrent();

            // Timeline query.
            $table->index(
                ['user_id', 'occurred_at', 'id'],
                'user_activities_user_timeline_idx'
            );

            // Administrative filtering by category and date.
            $table->index(
                ['category', 'occurred_at'],
                'user_activities_category_time_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};
