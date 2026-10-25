<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('webinar_events', function (Blueprint $table) {
            $table->string('event_type')->default('webinar')->after('slug')->index();
        });
    }

    public function down(): void
    {
        Schema::table('webinar_events', function (Blueprint $table) {
            $table->dropColumn('event_type');
        });
    }
};
