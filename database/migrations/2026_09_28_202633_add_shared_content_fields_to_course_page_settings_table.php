<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Copy shown in the "المحتوى المشترك — الأطفال/الكبار" dashboard tabs. These
 * repeaters are the middle tier of the course content fallback chain:
 *
 *     course.{block}  →  {audience}_shared_{block}_items  →  {audience}_{block}_items
 *
 * All fields are nullable so production gains the tier without losing data.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            foreach (['kids', 'adults'] as $audience) {
                $table->json($audience.'_shared_curriculum_items')->nullable()->after($audience.'_form_subtitle');
                $table->json($audience.'_shared_about_items')->nullable()->after($audience.'_shared_curriculum_items');
                $table->json($audience.'_shared_session_items')->nullable()->after($audience.'_shared_about_items');
                $table->json($audience.'_shared_journey_items')->nullable()->after($audience.'_shared_session_items');
                $table->json($audience.'_shared_faq_items')->nullable()->after($audience.'_shared_journey_items');
            }
        });
    }

    public function down(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            $columns = [];

            foreach (['kids', 'adults'] as $audience) {
                $columns = array_merge($columns, [
                    $audience.'_shared_curriculum_items',
                    $audience.'_shared_about_items',
                    $audience.'_shared_session_items',
                    $audience.'_shared_journey_items',
                    $audience.'_shared_faq_items',
                ]);
            }

            $table->dropColumn($columns);
        });
    }
};
