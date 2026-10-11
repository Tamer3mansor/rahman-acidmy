<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Turns the single lessons.course_id relation into a many-to-many pivot so a
 * lesson can be linked to more than one course, mirroring the categories setup.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_lesson', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->unique(['course_id', 'lesson_id']);
        });

        $this->migrateLegacyCourse();

        Schema::table('lessons', function (Blueprint $table) {
            $table->dropConstrainedForeignId('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
        });

        Schema::dropIfExists('course_lesson');
    }

    /**
     * Copy each lesson's existing course_id into the new pivot so no link is lost.
     */
    private function migrateLegacyCourse(): void
    {
        if (! Schema::hasColumn('lessons', 'course_id')) {
            return;
        }

        DB::table('lessons')
            ->whereNotNull('course_id')
            ->get(['id', 'course_id'])
            ->each(function (object $lesson): void {
                DB::table('course_lesson')->insert([
                    'course_id' => $lesson->course_id,
                    'lesson_id' => $lesson->id,
                ]);
            });
    }
};
