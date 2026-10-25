<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webinar_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary', 500);
            $table->longText('description');
            $table->string('cover_image')->nullable();
            $table->timestampTz('starts_at');
            $table->string('timezone', 80)->default('Asia/Kolkata');
            $table->unsignedSmallInteger('duration_minutes')->default(60);
            $table->string('host_name');
            $table->string('host_title')->nullable();
            $table->string('meeting_url')->nullable();
            $table->string('replay_url')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestampTz('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['status', 'starts_at']);
        });

        Schema::create('webinar_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webinar_event_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->index();
            $table->string('company')->nullable();
            $table->text('question')->nullable();
            $table->string('status')->default('registered')->index();
            $table->timestampTz('registered_at');
            $table->timestamps();
            $table->unique(['webinar_event_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webinar_registrations');
        Schema::dropIfExists('webinar_events');
    }
};
