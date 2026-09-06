<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_settings', function (Blueprint $table): void {
            $table->string('hero_media_type', 10)->default('video')->after('hero_video_path');
        });
    }

    public function down(): void
    {
        Schema::table('landing_settings', function (Blueprint $table): void {
            $table->dropColumn('hero_media_type');
        });
    }
};
