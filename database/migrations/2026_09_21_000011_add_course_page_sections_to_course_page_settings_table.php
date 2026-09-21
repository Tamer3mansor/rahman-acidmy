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
        Schema::table('course_page_settings', function (Blueprint $table) {
            $table->string('kids_showcase_image')->nullable()->after('kids_wa_url');
            $table->string('kids_about_label')->nullable()->after('kids_showcase_subtitle');
            $table->string('kids_about_title')->nullable()->after('kids_about_label');
            $table->text('kids_about_subtitle')->nullable()->after('kids_about_title');
            $table->json('kids_about_items')->nullable()->after('kids_about_subtitle');
            $table->string('kids_journey_label')->nullable()->after('kids_about_items');
            $table->string('kids_journey_title')->nullable()->after('kids_journey_label');
            $table->text('kids_journey_subtitle')->nullable()->after('kids_journey_title');
            $table->json('kids_journey_items')->nullable()->after('kids_journey_subtitle');
            $table->string('kids_faq_label')->nullable()->after('kids_journey_items');
            $table->string('kids_faq_title')->nullable()->after('kids_faq_label');
            $table->text('kids_faq_subtitle')->nullable()->after('kids_faq_title');
            $table->json('kids_faq_items')->nullable()->after('kids_faq_subtitle');
            $table->string('kids_faq_cta1_text')->nullable()->after('kids_faq_items');
            $table->string('kids_faq_cta1_url')->nullable()->after('kids_faq_cta1_text');
            $table->string('kids_faq_cta2_text')->nullable()->after('kids_faq_cta1_url');
            $table->string('kids_faq_cta2_url')->nullable()->after('kids_faq_cta2_text');
            $table->string('kids_testimonials_title')->nullable()->after('kids_faq_cta2_url');
            $table->text('kids_testimonials_subtitle')->nullable()->after('kids_testimonials_title');
            $table->string('kids_form_title')->nullable()->after('kids_testimonials_subtitle');
            $table->text('kids_form_subtitle')->nullable()->after('kids_form_title');

            $table->string('adults_showcase_image')->nullable()->after('adults_wa_url');
            $table->string('adults_about_label')->nullable()->after('adults_showcase_subtitle');
            $table->string('adults_about_title')->nullable()->after('adults_about_label');
            $table->text('adults_about_subtitle')->nullable()->after('adults_about_title');
            $table->json('adults_about_items')->nullable()->after('adults_about_subtitle');
            $table->string('adults_journey_label')->nullable()->after('adults_about_items');
            $table->string('adults_journey_title')->nullable()->after('adults_journey_label');
            $table->text('adults_journey_subtitle')->nullable()->after('adults_journey_title');
            $table->json('adults_journey_items')->nullable()->after('adults_journey_subtitle');
            $table->string('adults_faq_label')->nullable()->after('adults_journey_items');
            $table->string('adults_faq_title')->nullable()->after('adults_faq_label');
            $table->text('adults_faq_subtitle')->nullable()->after('adults_faq_title');
            $table->json('adults_faq_items')->nullable()->after('adults_faq_subtitle');
            $table->string('adults_faq_cta1_text')->nullable()->after('adults_faq_items');
            $table->string('adults_faq_cta1_url')->nullable()->after('adults_faq_cta1_text');
            $table->string('adults_faq_cta2_text')->nullable()->after('adults_faq_cta1_url');
            $table->string('adults_faq_cta2_url')->nullable()->after('adults_faq_cta2_text');
            $table->string('adults_testimonials_title')->nullable()->after('adults_faq_cta2_url');
            $table->text('adults_testimonials_subtitle')->nullable()->after('adults_testimonials_title');
            $table->string('adults_form_title')->nullable()->after('adults_testimonials_subtitle');
            $table->text('adults_form_subtitle')->nullable()->after('adults_form_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_page_settings', function (Blueprint $table) {
            $kids = [
                'kids_showcase_image', 'kids_about_label', 'kids_about_title', 'kids_about_subtitle',
                'kids_about_items', 'kids_journey_label', 'kids_journey_title', 'kids_journey_subtitle',
                'kids_journey_items', 'kids_faq_label', 'kids_faq_title', 'kids_faq_subtitle',
                'kids_faq_items', 'kids_faq_cta1_text', 'kids_faq_cta1_url', 'kids_faq_cta2_text',
                'kids_faq_cta2_url', 'kids_testimonials_title', 'kids_testimonials_subtitle',
                'kids_form_title', 'kids_form_subtitle',
            ];

            $adults = array_map(
                static fn (string $column): string => 'adults'.substr($column, 4),
                $kids
            );

            $table->dropColumn(array_merge($kids, $adults));
        });
    }
};
