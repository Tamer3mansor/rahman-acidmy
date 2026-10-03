<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Label above the courses grid, e.g. "Cours pour enfants". The grid header
 * already had a title and a description of its own, but its label reused the
 * hero label of the page, so the same word had to be edited from two places to
 * change one spot. One column per audience keeps the header fully editable.
 *
 * `text`, not `varchar(255)`: `course_page_settings` sits close to the InnoDB
 * 65,535-byte row limit and a single varchar(255) costs 1,020 bytes under
 * utf8mb4. `text` is stored off-row and only costs a pointer.
 *
 * Guarded by `hasColumn` so a re-run after an aborted ALTER TABLE skips what is
 * already there instead of failing on a duplicate column. Rows that predate
 * this column are backfilled with the page label they were already rendering,
 * which keeps the published pages byte-identical and leaves the dashboard with
 * a value to edit.
 */
return new class extends Migration
{
    /** @var array<int, string> */
    private array $added = [];

    public function up(): void
    {
        $this->addText('kids_catalog_label', 'kids_wa_url');
        $this->addText('adults_catalog_label', 'adults_wa_url');

        foreach (['kids', 'adults'] as $audience) {
            DB::table('course_page_settings')
                ->whereNull($audience.'_catalog_label')
                ->update([$audience.'_catalog_label' => DB::raw($audience.'_label')]);
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

    private function addText(string $column, string $after): void
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
