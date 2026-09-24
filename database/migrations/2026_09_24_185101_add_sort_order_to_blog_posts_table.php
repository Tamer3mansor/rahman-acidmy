<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('is_active');
        });

        DB::table('blog_posts')
            ->orderByDesc('published_at')
            ->orderBy('id')
            ->get()
            ->each(function (object $post, int $index): void {
                DB::table('blog_posts')
                    ->where('id', $post->id)
                    ->update(['sort_order' => $index + 1]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
