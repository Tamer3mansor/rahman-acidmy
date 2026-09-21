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
            $table->string('icon')->nullable()->change();

            $table->dropColumn(['age_band_max']);
            $table->dropColumn(['session_minutes']);

            $table->unsignedInteger('session_minutes_min')->nullable()->after('age_band_min');
            $table->unsignedInteger('session_minutes_max')->nullable()->after('session_minutes_min');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['session_minutes_min', 'session_minutes_max']);

            $table->unsignedInteger('age_band_max')->nullable();
            $table->unsignedInteger('session_minutes')->default(45);
        });
    }
};
