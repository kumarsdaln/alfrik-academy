<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type')->default('article')->index();
            $table->string('category')->nullable()->index();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->string('cover_image')->nullable();
            $table->unsignedSmallInteger('reading_minutes')->default(4);
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('company');
            $table->string('location')->default('Remote');
            $table->string('workplace_type')->default('remote');
            $table->string('employment_type')->default('full_time');
            $table->string('seniority')->nullable();
            $table->string('salary_range')->nullable();
            $table->text('summary');
            $table->longText('description');
            $table->json('skills')->nullable();
            $table->string('application_url')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('cover_note')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('status')->default('submitted')->index();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();
            $table->unique(['job_post_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
        Schema::dropIfExists('job_posts');
        Schema::dropIfExists('insights');
    }
};
