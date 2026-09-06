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
        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('parent_name');
            $table->tinyInteger('student_age');
            $table->string('phone');
            $table->string('email');
            $table->enum('level', ['Débutant', 'Intermédiaire', 'Avancé', 'Je ne sais pas']);
            $table->json('schedule');
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'scheduled', 'postponed'])->default('new');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
    }
};
