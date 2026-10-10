<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Makes the sidebar widget heading and description of the blog and lesson
 * details pages editable from the dashboard, alongside the two CTA buttons.
 * Both columns are nullable; the seeded values match the copy that is rendered
 * today, and the view keeps the previous French wording as the fallback.
 */
return new class extends Migration
{
    private const COLUMNS = ['sidebar_title', 'sidebar_text'];

    /** @var array<string, string> */
    private const COPY = [
        'sidebar_title' => 'Commencez le parcours de votre enfant',
        'sidebar_text' => "Donnez à votre enfant les bonnes orientations dès le début pour gagner des années d'essais.",
    ];

    public function up(): void
    {
        foreach (['blog_page_settings', 'lesson_page_settings'] as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->string('sidebar_title')->nullable()->after('sidebar_whatsapp_url');
                $table->text('sidebar_text')->nullable()->after('sidebar_title');
            });

            DB::table($table)->update(self::COPY);
        }
    }

    public function down(): void
    {
        foreach (['blog_page_settings', 'lesson_page_settings'] as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->dropColumn(self::COLUMNS);
            });
        }
    }
};
