<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Copy shown in the "المحتوى المشترك — الأطفال/الكبار" dashboard tabs for the
 * course detail page itself. The legacy `details_booking_*` / `details_cta_title`
 * / `details_form_title` columns are intentionally left in place: they are
 * backfilled into the new per-audience columns and dropped in a later release.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            $table->text('details_kids_hero_label')->nullable()->after('details_booking_note');
            $table->text('details_kids_trial_btn_text')->nullable()->after('details_kids_hero_label');
            $table->text('details_kids_trial_url')->nullable()->after('details_kids_trial_btn_text');
            $table->text('details_kids_whatsapp_btn_text')->nullable()->after('details_kids_trial_url');
            $table->text('details_kids_back_label')->nullable()->after('details_kids_whatsapp_btn_text');

            $table->text('details_adults_hero_label')->nullable()->after('details_kids_back_label');
            $table->text('details_adults_trial_btn_text')->nullable()->after('details_adults_hero_label');
            $table->text('details_adults_trial_url')->nullable()->after('details_adults_trial_btn_text');
            $table->text('details_adults_whatsapp_btn_text')->nullable()->after('details_adults_trial_url');
            $table->text('details_adults_back_label')->nullable()->after('details_adults_whatsapp_btn_text');

            foreach (['kids', 'adults'] as $audience) {
                $table->text('details_'.$audience.'_suitability_label')->nullable()->after('details_'.$audience.'_back_label');
                $table->text('details_'.$audience.'_suitability_title')->nullable()->after('details_'.$audience.'_suitability_label');
                $table->text('details_'.$audience.'_curriculum_label')->nullable()->after('details_'.$audience.'_suitability_title');
                $table->text('details_'.$audience.'_curriculum_title')->nullable()->after('details_'.$audience.'_curriculum_label');
                $table->text('details_'.$audience.'_session_label')->nullable()->after('details_'.$audience.'_curriculum_title');
                $table->text('details_'.$audience.'_session_title')->nullable()->after('details_'.$audience.'_session_label');
                $table->text('details_'.$audience.'_session_subtitle')->nullable()->after('details_'.$audience.'_session_title');
                $table->text('details_'.$audience.'_testimonials_label')->nullable()->after('details_'.$audience.'_session_subtitle');
                $table->text('details_'.$audience.'_testimonials_title')->nullable()->after('details_'.$audience.'_testimonials_label');
                $table->text('details_'.$audience.'_journey_label')->nullable()->after('details_'.$audience.'_testimonials_title');
                $table->text('details_'.$audience.'_journey_title')->nullable()->after('details_'.$audience.'_journey_label');
                $table->text('details_'.$audience.'_faq_label')->nullable()->after('details_'.$audience.'_journey_title');
                $table->text('details_'.$audience.'_faq_title')->nullable()->after('details_'.$audience.'_faq_label');
                $table->text('details_'.$audience.'_related_title')->nullable()->after('details_'.$audience.'_faq_title');
                $table->text('details_'.$audience.'_related_cta_text')->nullable()->after('details_'.$audience.'_related_title');
                $table->text('details_'.$audience.'_booking_title')->nullable()->after('details_'.$audience.'_related_cta_text');
                $table->text('details_'.$audience.'_booking_subtitle')->nullable()->after('details_'.$audience.'_booking_title');
                $table->text('details_'.$audience.'_booking_note')->nullable()->after('details_'.$audience.'_booking_subtitle');
                $table->text('details_'.$audience.'_sidebar_title')->nullable()->after('details_'.$audience.'_booking_note');
            }
        });
    }

    public function down(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            $columns = [];

            foreach (['kids', 'adults'] as $audience) {
                $columns = array_merge($columns, [
                    'details_'.$audience.'_hero_label',
                    'details_'.$audience.'_trial_btn_text',
                    'details_'.$audience.'_trial_url',
                    'details_'.$audience.'_whatsapp_btn_text',
                    'details_'.$audience.'_back_label',
                    'details_'.$audience.'_suitability_label',
                    'details_'.$audience.'_suitability_title',
                    'details_'.$audience.'_curriculum_label',
                    'details_'.$audience.'_curriculum_title',
                    'details_'.$audience.'_session_label',
                    'details_'.$audience.'_session_title',
                    'details_'.$audience.'_session_subtitle',
                    'details_'.$audience.'_testimonials_label',
                    'details_'.$audience.'_testimonials_title',
                    'details_'.$audience.'_journey_label',
                    'details_'.$audience.'_journey_title',
                    'details_'.$audience.'_faq_label',
                    'details_'.$audience.'_faq_title',
                    'details_'.$audience.'_related_title',
                    'details_'.$audience.'_related_cta_text',
                    'details_'.$audience.'_booking_title',
                    'details_'.$audience.'_booking_subtitle',
                    'details_'.$audience.'_booking_note',
                    'details_'.$audience.'_sidebar_title',
                ]);
            }

            $table->dropColumn($columns);
        });
    }
};
