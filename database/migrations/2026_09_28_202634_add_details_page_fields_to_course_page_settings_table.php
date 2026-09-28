<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Copy shown in the "المحتوى المشترك — الأطفال/الكبار" dashboard tabs for the
 * course detail page itself. The legacy `details_booking_*` / `details_cta_title`
 * / `details_form_title` columns are intentionally left in place: they are
 * backfilled into the new per-audience columns and dropped in a later release.
 *
 * Labels and titles are `text` rather than `varchar(255)` because this table
 * sits near the InnoDB 65,535-byte row limit; see the main-page migration for
 * the full explanation.
 *
 * Columns are guarded by `hasColumn` so a re-run after an aborted ALTER TABLE
 * skips what is already there instead of failing on a duplicate column.
 */
return new class extends Migration
{
    /** @var array<int, string> */
    private array $added = [];

    public function up(): void
    {
        $this->addText('details_kids_hero_label', 'details_booking_note');
        $this->addText('details_kids_trial_btn_text', 'details_kids_hero_label');
        $this->addText('details_kids_trial_url', 'details_kids_trial_btn_text');
        $this->addText('details_kids_whatsapp_btn_text', 'details_kids_trial_url');
        $this->addText('details_kids_back_label', 'details_kids_whatsapp_btn_text');

        $this->addText('details_adults_hero_label', 'details_kids_back_label');
        $this->addText('details_adults_trial_btn_text', 'details_adults_hero_label');
        $this->addText('details_adults_trial_url', 'details_adults_trial_btn_text');
        $this->addText('details_adults_whatsapp_btn_text', 'details_adults_trial_url');
        $this->addText('details_adults_back_label', 'details_adults_whatsapp_btn_text');

        foreach (['kids', 'adults'] as $audience) {
            $prefix = 'details_'.$audience.'_';
            $after = $prefix.'back_label';

            foreach ([
                'suitability_label',
                'suitability_title',
                'curriculum_label',
                'curriculum_title',
                'session_label',
                'session_title',
                'session_subtitle',
                'testimonials_label',
                'testimonials_title',
                'journey_label',
                'journey_title',
                'faq_label',
                'faq_title',
                'related_title',
                'related_cta_text',
                'booking_title',
                'booking_subtitle',
                'booking_note',
                'sidebar_title',
            ] as $key) {
                $this->addText($prefix.$key, $after);
                $after = $prefix.$key;
            }
        }
    }

    public function down(): void
    {
        $columns = $this->added;

        if ($columns === []) {
            return;
        }

        Schema::table('course_page_settings', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }

    private function addText(string $column, ?string $after = null): void
    {
        if (Schema::hasColumn('course_page_settings', $column)) {
            return;
        }

        Schema::table('course_page_settings', function (Blueprint $table) use ($column, $after) {
            $table->text($column)->nullable()->after($after);
        });

        $this->added[] = $column;
    }
};
