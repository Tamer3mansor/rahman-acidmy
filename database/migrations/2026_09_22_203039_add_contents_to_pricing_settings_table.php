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
        Schema::table('pricing_settings', function (Blueprint $table) {
            $table->string('contents_label')->nullable();
            $table->string('contents_title')->nullable();
            $table->text('contents_subtitle')->nullable();
            $table->json('contents_items')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pricing_settings', function (Blueprint $table) {
            $table->dropColumn(['contents_label', 'contents_title', 'contents_subtitle', 'contents_items']);
        });
    }
};
