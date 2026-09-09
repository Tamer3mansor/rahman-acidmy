<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            $table->string('kids_showcase_emoji')->nullable()->after('kids_wa_url');
            $table->string('kids_showcase_title')->nullable()->after('kids_showcase_emoji');
            $table->text('kids_showcase_subtitle')->nullable()->after('kids_showcase_title');
            $table->string('adults_showcase_emoji')->nullable()->after('adults_wa_url');
            $table->string('adults_showcase_title')->nullable()->after('adults_showcase_emoji');
            $table->text('adults_showcase_subtitle')->nullable()->after('adults_showcase_title');
        });
    }

    public function down(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            $table->dropColumn([
                'kids_showcase_emoji', 'kids_showcase_title', 'kids_showcase_subtitle',
                'adults_showcase_emoji', 'adults_showcase_title', 'adults_showcase_subtitle',
            ]);
        });
    }
};
