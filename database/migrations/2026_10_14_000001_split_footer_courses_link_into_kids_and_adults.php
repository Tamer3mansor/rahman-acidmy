<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Splits the single "Nos cours" footer link into separate kids and adults
 * links, matching how the nav already exposes nav_kids_label/nav_adults_label.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_settings', function (Blueprint $table) {
            $table->text('footer_link_kids_courses')->nullable()->after('footer_link_courses');
            $table->text('footer_link_adults_courses')->nullable()->after('footer_link_kids_courses');
        });

        DB::table('landing_settings')->update([
            'footer_link_kids_courses' => 'Cours pour enfants',
            'footer_link_adults_courses' => 'Cours pour adultes',
        ]);

        Schema::table('landing_settings', function (Blueprint $table) {
            $table->dropColumn('footer_link_courses');
        });
    }

    public function down(): void
    {
        Schema::table('landing_settings', function (Blueprint $table) {
            $table->text('footer_link_courses')->nullable()->after('footer_link_home');
        });

        DB::table('landing_settings')->update([
            'footer_link_courses' => 'Nos cours',
        ]);

        Schema::table('landing_settings', function (Blueprint $table) {
            $table->dropColumn(['footer_link_kids_courses', 'footer_link_adults_courses']);
        });
    }
};
