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
        Schema::table('course_page_settings', function (Blueprint $table) {
            $table->string('kids_curriculum_label')->nullable()->after('kids_badge');
            $table->string('kids_curriculum_title')->nullable()->after('kids_curriculum_label');
            $table->text('kids_curriculum_subtitle')->nullable()->after('kids_curriculum_title');
            $table->json('kids_curriculum_items')->nullable()->after('kids_curriculum_subtitle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            $table->dropColumn([
                'kids_curriculum_label',
                'kids_curriculum_title',
                'kids_curriculum_subtitle',
                'kids_curriculum_items',
            ]);
        });
    }
};