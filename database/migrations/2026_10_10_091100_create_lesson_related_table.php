<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Admin-picked "related lessons" shown as recommendations at the bottom of a
 * free lesson, mirroring the course_related_course pattern. Self-referencing
 * pivot; the detail page falls back to same-category lessons when empty.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lesson_related', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_lesson_id')->constrained(table: 'lessons')->cascadeOnDelete();
            $table->unique(['lesson_id', 'related_lesson_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_related');
    }
};
