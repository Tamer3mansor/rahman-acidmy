<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->longText('description')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Courses saved while the column was nullable have nothing to fall
        // back on, so they get an empty string rather than failing the NOT
        // NULL constraint on the way back down.
        DB::table('courses')->whereNull('description')->update(['description' => '']);

        Schema::table('courses', function (Blueprint $table) {
            $table->longText('description')->nullable(false)->change();
        });
    }
};
