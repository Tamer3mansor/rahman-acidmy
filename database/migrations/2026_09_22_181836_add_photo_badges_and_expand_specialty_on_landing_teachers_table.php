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
        Schema::table('landing_teachers', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('badges');
            $table->string('featured_label', 100)->nullable()->after('is_featured');
            $table->string('specialty', 400)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_teachers', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'featured_label']);
            $table->string('specialty')->change();
        });
    }
};
