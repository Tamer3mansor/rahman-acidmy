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
        Schema::create('landing_testimonials', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['video', 'whatsapp', 'google']);
            $table->string('author_name');
            $table->string('author_location')->nullable();
            $table->text('content')->nullable();
            $table->string('media_path')->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_testimonials');
    }
};
