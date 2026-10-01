<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Replaces the single `page_audience` column with a `placements` list so a
 * testimonial can be switched off the landing page instead of only ever being
 * "additional" there.
 *
 * The legacy values map as follows, since every row used to show on the landing
 * page: `none` -> landing, `kids` -> landing + kids, `adults` -> landing +
 * adults, `both` -> all three. `page_audience` is dropped in the same migration
 * because nothing reads it once the new column is in place.
 *
 * Both steps are guarded by `hasColumn` so a re-run after an aborted ALTER TABLE
 * skips what is already there instead of failing on a duplicate column.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('landing_testimonials', 'placements')) {
            Schema::table('landing_testimonials', function (Blueprint $table) {
                $table->json('placements')->nullable()->after('type');
            });
        }

        if (! Schema::hasColumn('landing_testimonials', 'page_audience')) {
            return;
        }

        DB::table('landing_testimonials')->chunkById(100, function ($rows): void {
            foreach ($rows as $row) {
                DB::table('landing_testimonials')
                    ->where('id', $row->id)
                    ->update(['placements' => json_encode($this->placementsFor($row->page_audience))]);
            }
        });

        Schema::table('landing_testimonials', function (Blueprint $table) {
            $table->dropColumn('page_audience');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('landing_testimonials', 'page_audience')) {
            Schema::table('landing_testimonials', function (Blueprint $table) {
                $table->string('page_audience')->default('none')->after('type');
            });
        }

        if (Schema::hasColumn('landing_testimonials', 'placements')) {
            DB::table('landing_testimonials')->chunkById(100, function ($rows): void {
                foreach ($rows as $row) {
                    DB::table('landing_testimonials')
                        ->where('id', $row->id)
                        ->update(['page_audience' => $this->legacyAudienceFor(json_decode((string) $row->placements, true))]);
                }
            });

            Schema::table('landing_testimonials', function (Blueprint $table) {
                $table->dropColumn('placements');
            });
        }
    }

    /**
     * @return list<string>
     */
    private function placementsFor(?string $legacyAudience): array
    {
        return match ($legacyAudience) {
            'kids' => ['landing', 'kids'],
            'adults' => ['landing', 'adults'],
            'both' => ['landing', 'kids', 'adults'],
            default => ['landing'],
        };
    }

    /**
     * @param  array<int, string>|null  $placements
     */
    private function legacyAudienceFor(?array $placements): string
    {
        $placements = $placements ?? [];
        $kids = in_array('kids', $placements, true);
        $adults = in_array('adults', $placements, true);

        return match (true) {
            $kids && $adults => 'both',
            $kids => 'kids',
            $adults => 'adults',
            default => 'none',
        };
    }
};
