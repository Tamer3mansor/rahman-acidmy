<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pricing_settings', function (Blueprint $table) {
            $table->string('hero_label')->nullable()->after('per_hour_price');
            $table->string('hero_label_icon')->nullable()->after('hero_label');
            $table->string('hero_title')->nullable()->after('hero_label_icon');
            $table->text('hero_subtitle')->nullable()->after('hero_title');
            $table->string('cta_badge')->nullable()->after('hero_subtitle');
            $table->string('cta_title')->nullable()->after('cta_badge');
            $table->text('cta_text')->nullable()->after('cta_title');
            $table->string('cta_whatsapp_label')->nullable()->after('cta_text');
            $table->string('cta_whatsapp_url')->nullable()->after('cta_whatsapp_label');
            $table->string('cta_trial_label')->nullable()->after('cta_whatsapp_url');
            $table->string('cta_trial_url')->nullable()->after('cta_trial_label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pricing_settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_label',
                'hero_label_icon',
                'hero_title',
                'hero_subtitle',
                'cta_badge',
                'cta_title',
                'cta_text',
                'cta_whatsapp_label',
                'cta_whatsapp_url',
                'cta_trial_label',
                'cta_trial_url',
            ]);
        });
    }
};
