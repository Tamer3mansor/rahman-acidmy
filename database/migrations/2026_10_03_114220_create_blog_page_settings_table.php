<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Copy and SEO of the blog listing page, one row the dashboard edits. The three
 * lines above the grid were hardcoded in the view, so this table is what makes
 * them editable; every field is nullable and the view keeps the previous French
 * wording as the fallback.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_page_settings', function (Blueprint $table): void {
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
        Schema::dropIfExists('blog_page_settings');
    }
};
