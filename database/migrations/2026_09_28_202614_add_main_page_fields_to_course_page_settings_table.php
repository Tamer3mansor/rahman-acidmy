<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Copy shown in the "صفحة الأطفال/الكبار الرئيسية" dashboard tabs. Every field
 * is scoped to one audience and nullable so the table can grow on production
 * without a data backfill; the seeder supplies the French defaults.
 *
 * The copy columns are `text`, not `varchar(255)`: `course_page_settings` sits
 * close to the InnoDB 65,535-byte row limit and a single varchar(255) costs
 * 1,020 bytes under utf8mb4, which is more than the remaining headroom. `text`
 * is stored off-row and only costs a pointer, so the whole set fits.
 *
 * Each column is guarded by `hasColumn` because MySQL applies an ALTER TABLE
 * statement per column: when the row-size error aborted a previous run, the
 * earlier columns in the list were already committed. Re-running must skip
 * those instead of failing on "Duplicate column name".
 */
return new class extends Migration
{
    /** @var array<int, string> */
    private array $added = [];

    public function up(): void
    {
        foreach (['kids', 'adults'] as $audience) {
            $this->addText($audience.'_catalog_title', $audience.'_wa_url');
            $this->addText($audience.'_catalog_subtitle', $audience.'_catalog_title');
            $this->addText($audience.'_catalog_empty_text', $audience.'_catalog_subtitle');

            $this->addText($audience.'_card_cta_text', $audience.'_catalog_empty_text');
            $this->addText($audience.'_card_age_template', $audience.'_card_cta_text');
            $this->addText($audience.'_card_level_prefix', $audience.'_card_age_template');

            $this->addText($audience.'_testimonials_label', $audience.'_card_level_prefix');

            $this->addText($audience.'_session_label', $audience.'_testimonials_label');
            $this->addText($audience.'_session_title', $audience.'_session_label');
            $this->addText($audience.'_session_subtitle', $audience.'_session_title');
            $this->addJson($audience.'_session_items', $audience.'_session_subtitle');

            $this->addText($audience.'_final_title', $audience.'_session_items');
            $this->addText($audience.'_final_subtitle', $audience.'_final_title');
            $this->addText($audience.'_final_cta_text', $audience.'_final_subtitle');
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
