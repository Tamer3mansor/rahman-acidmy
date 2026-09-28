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
        foreach (['kids', 'adults'] as $audience) {
            $blocks = [
                'curriculum' => $audience.'_form_subtitle',
                'about' => $audience.'_shared_curriculum_items',
                'session' => $audience.'_shared_about_items',
                'journey' => $audience.'_shared_session_items',
                'faq' => $audience.'_shared_journey_items',
            ];

            foreach ($blocks as $block => $after) {
                $this->addJson($audience.'_shared_'.$block.'_items', $after);
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

    private function addJson(string $column, ?string $after = null): void
    {
        if (Schema::hasColumn('course_page_settings', $column)) {
            return;
        }

        Schema::table('course_page_settings', function (Blueprint $table) use ($column, $after) {
            $table->json($column)->nullable()->after($after);
        });

        $this->added[] = $column;
    }
};
