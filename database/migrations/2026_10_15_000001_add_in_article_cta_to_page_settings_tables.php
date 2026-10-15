<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Makes the in-article CTA block rendered inside the blog and lesson details
 * pages editable from the dashboard. Every column is nullable and the seeded
 * values match the copy that is rendered today, so the view keeps the previous
 * French wording as the fallback and production output does not change until an
 * admin customises it. The lessons page also carries a badge line above the
 * headline, so `cta_badge` exists on `lesson_page_settings` only.
 */
return new class extends Migration
{
    /** @var array<string, string> */
    private const BLOG_COPY = [
        'cta_title' => 'Vous souhaitez un enseignant expérimenté pour accompagner votre enfant ?',
        'cta_text' => "Réservez dès maintenant une séance d'essai gratuite avec les meilleurs enseignants du Coran pour enfants.",
        'cta_button_label' => 'Réserver un essai gratuit',
    ];

    /** @var array<string, string> */
    private const LESSON_COPY = [
        'cta_badge' => 'Application pratique directe',
        'cta_title' => "Aimez-vous notre méthode d'explication ?",
        'cta_text' => "Réservez une séance d'essai en direct avec un enseignant spécialisé pour appliquer ces leçons avec votre enfant, étape par étape.",
        'cta_button_label' => "Réserver l'essai gratuit",
    ];

    public function up(): void
    {
        Schema::table('blog_page_settings', function (Blueprint $table): void {
            $table->string('cta_title')->nullable()->after('sidebar_text');
            $table->text('cta_text')->nullable()->after('cta_title');
            $table->string('cta_button_label')->nullable()->after('cta_text');
            $table->string('cta_button_url')->nullable()->after('cta_button_label');
        });

        DB::table('blog_page_settings')->update(self::BLOG_COPY);

        Schema::table('lesson_page_settings', function (Blueprint $table): void {
            $table->string('cta_badge')->nullable()->after('sidebar_text');
            $table->string('cta_title')->nullable()->after('cta_badge');
            $table->text('cta_text')->nullable()->after('cta_title');
            $table->string('cta_button_label')->nullable()->after('cta_text');
            $table->string('cta_button_url')->nullable()->after('cta_button_label');
        });

        DB::table('lesson_page_settings')->update(self::LESSON_COPY);
    }

    public function down(): void
    {
        Schema::table('blog_page_settings', function (Blueprint $table): void {
            $table->dropColumn(['cta_title', 'cta_text', 'cta_button_label', 'cta_button_url']);
        });

        Schema::table('lesson_page_settings', function (Blueprint $table): void {
            $table->dropColumn(['cta_badge', 'cta_title', 'cta_text', 'cta_button_label', 'cta_button_url']);
        });
    }
};
