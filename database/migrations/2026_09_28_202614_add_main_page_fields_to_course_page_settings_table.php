<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Copy shown in the "صفحة الأطفال/الكبار الرئيسية" dashboard tabs. Every field
 * is scoped to one audience and nullable so the table can grow on production
 * without a data backfill; the seeder supplies the French defaults.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            foreach (['kids', 'adults'] as $audience) {
                // Catalog grid head.
                $table->string($audience.'_catalog_title')->nullable()->after($audience.'_wa_url');
                $table->text($audience.'_catalog_subtitle')->nullable()->after($audience.'_catalog_title');
                $table->string($audience.'_catalog_empty_text')->nullable()->after($audience.'_catalog_subtitle');

                // Course card.
                $table->string($audience.'_card_cta_text')->nullable()->after($audience.'_catalog_empty_text');
                $table->string($audience.'_card_age_template')->nullable()->after($audience.'_card_cta_text');
                $table->string($audience.'_card_level_prefix')->nullable()->after($audience.'_card_age_template');

                // Testimonials section head.
                $table->string($audience.'_testimonials_label')->nullable()->after($audience.'_card_level_prefix');

                // "كيف تكون الحصة" section. Absent on the page until an editor
                // fills it in, which is what makes the third fallback tier
                // reachable for session_features.
                $table->string($audience.'_session_label')->nullable()->after($audience.'_testimonials_label');
                $table->string($audience.'_session_title')->nullable()->after($audience.'_session_label');
                $table->text($audience.'_session_subtitle')->nullable()->after($audience.'_session_title');
                $table->json($audience.'_session_items')->nullable()->after($audience.'_session_subtitle');

                // Final booking band closing the page.
                $table->string($audience.'_final_title')->nullable()->after($audience.'_session_items');
                $table->text($audience.'_final_subtitle')->nullable()->after($audience.'_final_title');
                $table->string($audience.'_final_cta_text')->nullable()->after($audience.'_final_subtitle');
            }
        });
    }

    public function down(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            $columns = [];

            foreach (['kids', 'adults'] as $audience) {
                $columns = array_merge($columns, [
                    $audience.'_catalog_title',
                    $audience.'_catalog_subtitle',
                    $audience.'_catalog_empty_text',
                    $audience.'_card_cta_text',
                    $audience.'_card_age_template',
                    $audience.'_card_level_prefix',
                    $audience.'_testimonials_label',
                    $audience.'_session_label',
                    $audience.'_session_title',
                    $audience.'_session_subtitle',
                    $audience.'_session_items',
                    $audience.'_final_title',
                    $audience.'_final_subtitle',
                    $audience.'_final_cta_text',
                ]);
            }

            $table->dropColumn($columns);
        });
    }
};
