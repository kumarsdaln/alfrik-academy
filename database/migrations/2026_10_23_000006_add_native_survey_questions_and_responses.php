<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->jsonb('survey_questions')->nullable();
        });

        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insight_id')->constrained('insights')->cascadeOnDelete();
            $table->char('respondent_hash', 64);
            $table->jsonb('answers');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();
            $table->unique(['insight_id', 'respondent_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
        Schema::table('insights', function (Blueprint $table) {
            $table->dropColumn('survey_questions');
        });
    }
};
