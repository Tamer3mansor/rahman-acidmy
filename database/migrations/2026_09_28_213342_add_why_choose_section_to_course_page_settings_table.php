<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the "Pourquoi choisir Madrassat Ar-Rahman ?" section to the course
 * details page.
 *
 * The cards follow the same two tiers as the other details blocks: the audience
 * shared column overrides the audience main column, and an empty result makes
 * the view hide the section entirely.
 *
 * Labels and titles are `text`, not `varchar(255)`, because the table sits near
 * the InnoDB 65,535-byte row limit; see the main-page migration for the full
 * explanation.
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
            $this->addText('details_'.$audience.'_why_label', 'details_'.$audience.'_journey_title');
            $this->addText('details_'.$audience.'_why_title', 'details_'.$audience.'_why_label');
            $this->addJson($audience.'_why_items', 'details_'.$audience.'_why_title');
            $this->addJson($audience.'_shared_why_items', $audience.'_why_items');
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
