<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The label above the course title on the course detail page, e.g. "Programme
 * dédié aux enfants et aux jeunes". The detail hero had no per-course field, so
 * the line came from `details_{audience}_hero_label` and every course of an
 * audience shared one wording. A null column means "inherit", which keeps the
 * existing rows on the shared copy until an admin types something.
 *
 * Guarded by `hasColumn` so a re-run after an aborted ALTER TABLE skips what is
 * already there instead of failing on a duplicate column.
 */
return new class extends Migration
{
    /** @var array<int, string> */
    private array $added = [];

    public function up(): void
    {
        if (Schema::hasColumn('courses', 'hero_label')) {
            return;
        }

        Schema::table('courses', function (Blueprint $table) {
            $table->string('hero_label')->nullable()->after('short_description');
        });

        $this->added[] = 'hero_label';
    }

    public function down(): void
    {
        $columns = $this->added;

        if ($columns === []) {
            return;
        }

        Schema::table('courses', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }
};
