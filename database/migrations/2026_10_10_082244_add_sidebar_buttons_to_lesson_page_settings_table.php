<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Makes the two sidebar CTA buttons of the lesson details page editable from
 * the dashboard. The text and link are stored on the lesson page settings row;
 * an empty link falls back to the previous behaviour in the view, so production
 * output does not change until an admin customises them.
 */
return new class extends Migration
{
    /** @var array<string, string> */
    private const COPY = [
        'sidebar_trial_label' => 'Essai gratuit',
        'sidebar_whatsapp_label' => 'Contactez-nous via WhatsApp',
    ];

    public function up(): void
    {
        Schema::table('lesson_page_settings', function (Blueprint $table) {
            $table->string('sidebar_trial_label')->nullable()->after('description');
            $table->string('sidebar_trial_url')->nullable()->after('sidebar_trial_label');
            $table->string('sidebar_whatsapp_label')->nullable()->after('sidebar_trial_url');
            $table->string('sidebar_whatsapp_url')->nullable()->after('sidebar_whatsapp_label');
        });

        DB::table('lesson_page_settings')->update(self::COPY);
    }

    public function down(): void
    {
        Schema::table('lesson_page_settings', function (Blueprint $table) {
            $table->dropColumn([
                'sidebar_trial_label',
                'sidebar_trial_url',
                'sidebar_whatsapp_label',
                'sidebar_whatsapp_url',
            ]);
        });
    }
};
