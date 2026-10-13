<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The public contact phone number is footer content, so it is edited from the
 * landing settings footer tab next to the contact e-mail. The column is
 * nullable: when empty no phone link is rendered, keeping the footer clean.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('landing_settings', function (Blueprint $table) {
            $table->string('footer_contact_phone', 255)->nullable()->after('footer_contact_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_settings', function (Blueprint $table) {
            $table->dropColumn('footer_contact_phone');
        });
    }
};
