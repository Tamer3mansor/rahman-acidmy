<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Admin-picked "related articles" shown as recommendations at the bottom of a
 * blog post, mirroring the course_related_course pattern. Self-referencing
 * pivot; the detail page falls back to same-category posts when empty.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_post_related', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_blog_post_id')->constrained(table: 'blog_posts')->cascadeOnDelete();
            $table->unique(['blog_post_id', 'related_blog_post_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_post_related');
    }
};
