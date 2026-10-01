<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Caps how many testimonials one audience shows. The audience pages used to
 * hardcode `take(3)` while the course detail pages rendered everything they were
 * given, so the cap now lives in the dashboard and applies to both.
 *
 * One column per audience covers the audience page and the course detail pages
 * of that audience. Guarded by `hasColumn` so a re-run after an aborted ALTER
 * TABLE skips what is already there instead of failing on a duplicate column.
 */
return new class extends Migration
{
    /** @var array<int, string> */
    private array $added = [];

    public function up(): void
    {
        $this->addLimit('kids_testimonials_limit', 'kids_testimonials_subtitle');
        $this->addLimit('adults_testimonials_limit', 'adults_testimonials_subtitle');
    }

    public function down(): void
    {
        if ($this->added === []) {
            return;
        }

        Schema::table('course_page_settings', function (Blueprint $table) {
            $table->dropColumn($this->added);
        });
    }

    private function addLimit(string $column, string $after): void
    {
        if (Schema::hasColumn('course_page_settings', $column)) {
            return;
        }

        Schema::table('course_page_settings', function (Blueprint $table) use ($column, $after) {
            $table->unsignedTinyInteger($column)->default(3)->after($after);
        });

        $this->added[] = $column;
    }
};
