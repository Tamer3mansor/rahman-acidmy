<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Copy and SEO of the free lessons listing page, one row the dashboard edits.
 * Mirrors `blog_page_settings`: the hero lines were hardcoded in the view, and
 * every field is nullable so the view keeps its wording as the fallback.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lesson_page_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('label')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title', 60)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->boolean('is_indexed')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_page_settings');
    }
};
