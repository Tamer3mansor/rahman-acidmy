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
        Schema::table('landing_faqs', function (Blueprint $table) {
            $table->boolean('show_cta2')->default(false)->after('cta_url');
            $table->string('cta2_text')->nullable()->after('show_cta2');
            $table->string('cta2_url')->nullable()->after('cta2_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_faqs', function (Blueprint $table) {
            $table->dropColumn(['show_cta2', 'cta2_text', 'cta2_url']);
        });
    }
};
