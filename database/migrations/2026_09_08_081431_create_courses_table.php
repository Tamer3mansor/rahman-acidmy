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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('audience');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->default('📖');
            $table->string('card_theme')->default('green');
            $table->string('short_description');
            $table->longText('description');
            $table->unsignedInteger('age_band_min')->nullable();
            $table->unsignedInteger('age_band_max')->nullable();
            $table->unsignedInteger('session_minutes')->default(45);
            $table->string('level_label')->nullable();
            $table->json('curriculum_items')->nullable();
            $table->json('session_features')->nullable();
            $table->json('journey_steps')->nullable();
            $table->json('suitability_checks')->nullable();
            $table->json('faqs')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('audience');
            $table->index(['audience', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
