<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The public contact e-mail is footer content, so it is edited from the landing
 * settings footer tab next to the other footer fields instead of the system
 * settings page. The existing value (if any) is copied across before the old
 * column is dropped so deployed sites keep rendering the same address.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_settings', function (Blueprint $table) {
            $table->string('footer_contact_email', 255)->nullable()->after('footer_link_email');
        });

        $email = DB::table('system_settings')->value('email');

        if (filled($email)) {
            DB::table('landing_settings')->update(['footer_contact_email' => $email]);
        }

        Schema::table('system_settings', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }

    public function down(): void
    {
        $email = DB::table('landing_settings')->value('footer_contact_email');

        Schema::table('system_settings', function (Blueprint $table) {
            $table->string('email', 255)->nullable()->after('whatsapp_number');
        });

        if (filled($email)) {
            DB::table('system_settings')->update(['email' => $email]);
        }

        Schema::table('landing_settings', function (Blueprint $table) {
            $table->dropColumn('footer_contact_email');
        });
    }
};
