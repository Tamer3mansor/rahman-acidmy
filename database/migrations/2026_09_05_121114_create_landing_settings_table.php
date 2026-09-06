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
        Schema::create('landing_settings', function (Blueprint $table) {
            $table->id();

            $table->string('hero_badge')->nullable();
            $table->string('hero_title')->nullable();
            $table->string('hero_title_accent')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_btn1_title')->nullable();
            $table->string('hero_btn1_url')->nullable();
            $table->string('hero_btn2_title')->nullable();
            $table->string('hero_btn2_url')->nullable();
            $table->string('hero_video_path')->nullable();
            $table->boolean('hero_video_autoplay')->default(true);
            $table->boolean('hero_video_loop')->default(true);

            $table->string('trust_label')->nullable();
            $table->string('trust_title')->nullable();
            $table->text('trust_subtitle')->nullable();
            $table->string('trust_cta_title')->nullable();

            $table->string('journey_label')->nullable();
            $table->string('journey_title')->nullable();
            $table->text('journey_subtitle')->nullable();
            $table->string('journey_cta_title')->nullable();

            $table->string('compare_label')->nullable();
            $table->string('compare_title')->nullable();
            $table->text('compare_subtitle')->nullable();
            $table->string('compare_problems_title')->nullable();
            $table->string('compare_solutions_title')->nullable();
            $table->string('compare_cta_title')->nullable();

            $table->string('teachers_label')->nullable();
            $table->string('teachers_title')->nullable();
            $table->text('teachers_subtitle')->nullable();
            $table->string('teachers_cta_title')->nullable();

            $table->string('faq_label')->nullable();
            $table->string('faq_title')->nullable();
            $table->text('faq_subtitle')->nullable();

            $table->string('form_label')->nullable();
            $table->string('form_title')->nullable();
            $table->string('form_title_accent')->nullable();
            $table->text('form_subtitle')->nullable();
            $table->string('form_card_title')->nullable();
            $table->text('form_card_subtitle')->nullable();
            $table->text('form_note')->nullable();
            $table->string('form_privacy_note')->nullable();

            $table->string('footer_brand_name')->nullable();
            $table->string('footer_brand_sub')->nullable();
            $table->text('footer_description')->nullable();
            $table->string('footer_copyright')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_settings');
    }
};
