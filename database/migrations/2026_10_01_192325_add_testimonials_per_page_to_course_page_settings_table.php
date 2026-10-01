<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Page size for the testimonials of one audience. The audience pages used to
 * hardcode `take(3)` while the course detail pages rendered everything, so both
 * now show every testimonial the dashboard placed there and paginate at the size
 * picked here.
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
        $this->addPerPage('kids_testimonials_per_page', 'kids_testimonials_subtitle');
        $this->addPerPage('adults_testimonials_per_page', 'adults_testimonials_subtitle');
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

    private function addPerPage(string $column, string $after): void
    {
        if (Schema::hasColumn('course_page_settings', $column)) {
            return;
        }

        Schema::table('course_page_settings', function (Blueprint $table) use ($column, $after) {
            $table->unsignedTinyInteger($column)->default(6)->after($after);
        });

        $this->added[] = $column;
    }
};
