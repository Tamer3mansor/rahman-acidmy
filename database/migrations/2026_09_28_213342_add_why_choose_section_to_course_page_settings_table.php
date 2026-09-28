<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds the "Pourquoi choisir Madrassat Ar-Rahman ?" section to the course
     * details page.
     *
     * The cards follow the same two tiers as the other details blocks: the
     * audience shared column overrides the audience main column, and an empty
     * result makes the view hide the section entirely.
     */
    public function up(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            foreach (['kids', 'adults'] as $audience) {
                $table->text('details_'.$audience.'_why_label')->nullable()->after('details_'.$audience.'_journey_title');
                $table->text('details_'.$audience.'_why_title')->nullable()->after('details_'.$audience.'_why_label');
                $table->json($audience.'_why_items')->nullable()->after('details_'.$audience.'_why_title');
                $table->json($audience.'_shared_why_items')->nullable()->after($audience.'_why_items');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columns = [];

        foreach (['kids', 'adults'] as $audience) {
            $columns[] = 'details_'.$audience.'_why_label';
            $columns[] = 'details_'.$audience.'_why_title';
            $columns[] = $audience.'_why_items';
            $columns[] = $audience.'_shared_why_items';
        }

        Schema::table('course_page_settings', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }
};
