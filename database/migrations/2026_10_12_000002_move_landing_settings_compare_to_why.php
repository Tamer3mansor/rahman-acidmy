<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Retires the home-page comparison block ("Pourquoi Ar-Rahman Academy ?",
 * problems vs solutions) in favour of the "why choose Madrassat Ar-Rahman"
 * cards section.
 *
 * The repeatable comparison rows lived in `landing_compare_items`; the section
 * copy lived in `landing_settings.compare_*`. Both are dropped here, and the
 * new card copy (`landing_settings.why_*`) is added. The card rows themselves
 * live in `landing_why_items` (see the matching create migration).
 *
 * Columns are guarded so a re-run after a partially applied change does not
 * fail on a missing/duplicate column.
 */
return new class extends Migration
{
    /** @var array<int, string> */
    private array $compareColumns = [
        'compare_label',
        'compare_title',
        'compare_subtitle',
        'compare_problems_title',
        'compare_solutions_title',
        'compare_cta_title',
    ];

    /** @var array<int, string> */
    private array $whyColumns = [
        'why_label',
        'why_title',
        'why_subtitle',
        'why_cta_title',
    ];

    public function up(): void
    {
        Schema::dropIfExists('landing_compare_items');

        $this->dropColumns($this->compareColumns);

        if (! Schema::hasColumn('landing_settings', 'why_label')) {
            Schema::table('landing_settings', function (Blueprint $table) {
                $table->string('why_label')->nullable()->after('journey_cta_title');
                $table->string('why_title')->nullable()->after('why_label');
                $table->text('why_subtitle')->nullable()->after('why_title');
                $table->string('why_cta_title')->nullable()->after('why_subtitle');
            });
        }

        $this->seedDefaultCopy();
    }

    public function down(): void
    {
        $this->dropColumns($this->whyColumns);

        if (! Schema::hasColumn('landing_settings', 'compare_label')) {
            Schema::table('landing_settings', function (Blueprint $table) {
                $table->string('compare_label')->nullable()->after('journey_cta_title');
                $table->string('compare_title')->nullable()->after('compare_label');
                $table->text('compare_subtitle')->nullable()->after('compare_title');
                $table->string('compare_problems_title')->nullable()->after('compare_subtitle');
                $table->string('compare_solutions_title')->nullable()->after('compare_problems_title');
                $table->string('compare_cta_title')->nullable()->after('compare_solutions_title');
            });
        }

        if (! Schema::hasTable('landing_compare_items')) {
            Schema::create('landing_compare_items', function (Blueprint $table) {
                $table->id();
                $table->enum('type', ['problem', 'solution']);
                $table->string('text');
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Fill the new section copy on the existing singleton row so the block is
     * previewable right after migrating. Never overwrites curated copy.
     */
    private function seedDefaultCopy(): void
    {
        if (! Schema::hasTable('landing_settings')) {
            return;
        }

        DB::table('landing_settings')
            ->whereNull('why_title')
            ->update([
                'why_label' => 'Pourquoi Madrassat Ar-Rahman ?',
                'why_title' => 'Une éducation complète et bienveillante',
                'why_subtitle' => 'Ce qui fait notre différence au quotidien, pour chaque élève et chaque famille',
                'why_cta_title' => 'Réservez votre essai gratuit',
            ]);
    }

    /**
     * Drop only the columns that actually exist, in a single ALTER so the
     * migration stays safe to re-run.
     *
     * @param  array<int, string>  $columns
     */
    private function dropColumns(array $columns): void
    {
        $existing = array_values(array_filter(
            $columns,
            fn (string $column): bool => Schema::hasColumn('landing_settings', $column),
        ));

        if ($existing === []) {
            return;
        }

        Schema::table('landing_settings', function (Blueprint $table) use ($existing) {
            $table->dropColumn($existing);
        });
    }
};
