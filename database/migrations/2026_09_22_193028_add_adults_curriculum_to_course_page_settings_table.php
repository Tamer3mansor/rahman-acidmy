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
            $table->string('adults_curriculum_label')->nullable()->after('adults_about_items');
            $table->string('adults_curriculum_title')->nullable()->after('adults_curriculum_label');
            $table->text('adults_curriculum_subtitle')->nullable()->after('adults_curriculum_title');
            $table->json('adults_curriculum_items')->nullable()->after('adults_curriculum_subtitle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            $table->dropColumn([
                'adults_curriculum_label',
                'adults_curriculum_title',
                'adults_curriculum_subtitle',
                'adults_curriculum_items',
            ]);
        });
    }
};
