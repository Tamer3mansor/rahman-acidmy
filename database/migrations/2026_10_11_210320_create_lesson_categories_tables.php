<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Moves lesson categories out of the hardcoded LessonCategory enum and the
 * lessons.category string column into a DB table managed from the dashboard,
 * mirroring the blog_categories + blog_post_category pattern.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lesson_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('lesson_category_lesson', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lesson_category_id')->constrained()->cascadeOnDelete();
            $table->unique(['lesson_id', 'lesson_category_id']);
        });

        $this->migrateLegacyCategories();

        Schema::table('lessons', function (Blueprint $table) {
            $table->dropIndex(['category', 'is_active']);
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('category')->nullable()->after('id');
            $table->index(['category', 'is_active']);
        });

        Schema::dropIfExists('lesson_category_lesson');
        Schema::dropIfExists('lesson_categories');
    }

    /**
     * Convert the existing "category" enum values stored on lessons into
     * lesson_categories rows and pivot links so no content is lost.
     */
    private function migrateLegacyCategories(): void
    {
        if (! Schema::hasColumn('lessons', 'category')) {
            return;
        }

        $labels = [
            'kids' => 'أطفال',
            'adults' => 'كبار',
            'tajwid' => 'تجويد وتلاوة',
        ];

        $legacyValues = DB::table('lessons')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        foreach ($legacyValues->values() as $sort => $value) {
            $categoryId = DB::table('lesson_categories')->insertGetId([
                'name' => $labels[$value] ?? $value,
                'slug' => $value,
                'is_active' => true,
                'sort_order' => $sort,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $lessonIds = DB::table('lessons')->where('category', $value)->pluck('id');

            foreach ($lessonIds as $lessonId) {
                DB::table('lesson_category_lesson')->insert([
                    'lesson_id' => $lessonId,
                    'lesson_category_id' => $categoryId,
                ]);
            }
        }
    }
};
