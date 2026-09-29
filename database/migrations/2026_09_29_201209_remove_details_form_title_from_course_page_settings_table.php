<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('course_page_settings', 'details_form_title')) {
            return;
        }

        Schema::table('course_page_settings', function (Blueprint $table) {
            $table->dropColumn('details_form_title');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('course_page_settings', 'details_form_title')) {
            return;
        }

        Schema::table('course_page_settings', function (Blueprint $table) {
            $table->text('details_form_title')->nullable();
        });
    }
};
