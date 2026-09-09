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
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('category')->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->text('excerpt')->nullable()->change();
            $table->longText('body')->nullable()->change();
            $table->unsignedInteger('reading_time')->nullable()->change();
            $table->unsignedInteger('sort_order')->nullable()->change();
            $table->string('pdf_url')->nullable()->after('audio_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('pdf_url');
            $table->string('category')->nullable(false)->change();
            $table->string('title')->nullable(false)->change();
            $table->text('excerpt')->nullable(false)->change();
            $table->longText('body')->nullable(false)->change();
            $table->unsignedInteger('reading_time')->default(5)->nullable(false)->change();
            $table->unsignedInteger('sort_order')->default(0)->nullable(false)->change();
        });
    }
};
