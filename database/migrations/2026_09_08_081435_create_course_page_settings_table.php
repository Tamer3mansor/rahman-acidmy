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
        Schema::create('course_page_settings', function (Blueprint $table) {
            $table->id();

            $table->string('kids_label');
            $table->string('kids_title');
            $table->string('kids_title_accent')->nullable();
            $table->string('kids_subtitle');
            $table->string('kids_badge');
            $table->string('kids_cta_title');
            $table->string('kids_cta_url')->default('#');
            $table->string('kids_wa_title');
            $table->string('kids_wa_url')->default('#');

            $table->string('adults_label');
            $table->string('adults_title');
            $table->string('adults_title_accent')->nullable();
            $table->string('adults_subtitle');
            $table->string('adults_badge');
            $table->string('adults_cta_title');
            $table->string('adults_cta_url')->default('#');
            $table->string('adults_wa_title');
            $table->string('adults_wa_url')->default('#');

            $table->string('details_booking_title');
            $table->string('details_booking_subtitle');
            $table->string('details_cta_title');
            $table->string('details_form_title');
            $table->string('details_booking_note')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_page_settings');
    }
};
