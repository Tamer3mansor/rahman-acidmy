<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the contact/social profile links shown in the footer. Every column is
 * nullable: a footer icon is only rendered for a field that has a value, so an
 * empty set leaves the footer totally clean. Values are edited from the
 * dashboard under landing-settings → footer tab.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_settings', function (Blueprint $table) {
            $table->string('footer_social_whatsapp')->nullable()->after('footer_copyright');
            $table->string('footer_social_telegram')->nullable()->after('footer_social_whatsapp');
            $table->string('footer_social_facebook')->nullable()->after('footer_social_telegram');
            $table->string('footer_social_instagram')->nullable()->after('footer_social_facebook');
            $table->string('footer_social_tiktok')->nullable()->after('footer_social_instagram');
            $table->string('footer_social_x')->nullable()->after('footer_social_tiktok');
            $table->string('footer_social_youtube')->nullable()->after('footer_social_x');
        });
    }

    public function down(): void
    {
        Schema::table('landing_settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_social_whatsapp',
                'footer_social_telegram',
                'footer_social_facebook',
                'footer_social_instagram',
                'footer_social_tiktok',
                'footer_social_x',
                'footer_social_youtube',
            ]);
        });
    }
};
