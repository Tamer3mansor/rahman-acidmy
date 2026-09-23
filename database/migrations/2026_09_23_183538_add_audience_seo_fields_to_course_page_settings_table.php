<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            $table->string('kids_meta_title', 60)->nullable()->after('is_indexed');
            $table->text('kids_meta_description')->nullable()->after('kids_meta_title');
            $table->string('kids_og_image')->nullable()->after('kids_meta_description');
            $table->string('adults_meta_title', 60)->nullable()->after('kids_og_image');
            $table->text('adults_meta_description')->nullable()->after('adults_meta_title');
            $table->string('adults_og_image')->nullable()->after('adults_meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            $table->dropColumn([
                'kids_meta_title',
                'kids_meta_description',
                'kids_og_image',
                'adults_meta_title',
                'adults_meta_description',
                'adults_og_image',
            ]);
        });
    }
};
