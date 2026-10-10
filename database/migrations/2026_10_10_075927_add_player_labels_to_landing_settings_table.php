<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the aria-labels for the two extra testimonial player controls (the
 * progress/seek bar and the fullscreen toggle) so they stay editable from the
 * dashboard like the other player labels. Both columns are nullable; the seeded
 * values match the copy that is now rendered.
 */
return new class extends Migration
{
    /** @var array<string, string> */
    private const COPY = [
        'testimonial_seek_label' => 'Position de lecture',
        'testimonial_fullscreen_label' => 'Plein écran',
    ];

    public function up(): void
    {
        Schema::table('landing_settings', function (Blueprint $table) {
            foreach (array_keys(self::COPY) as $column) {
                $table->text($column)->nullable()->after('testimonial_volume_label');
            }
        });

        DB::table('landing_settings')->update(self::COPY);
    }

    public function down(): void
    {
        Schema::table('landing_settings', function (Blueprint $table) {
            $table->dropColumn(array_keys(self::COPY));
        });
    }
};
