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
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['session_minutes_min', 'session_minutes_max']);

            $table->string('badge_text')->nullable()->after('level_label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['badge_text']);

            $table->unsignedInteger('session_minutes_min')->nullable();
            $table->unsignedInteger('session_minutes_max')->nullable();
        });
    }
};
