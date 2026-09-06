<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_settings', function (Blueprint $table): void {
            $table->string('header_brand_name')->nullable()->after('id');
            $table->string('header_brand_sub')->nullable()->after('header_brand_name');
            $table->string('header_logo_path', 500)->nullable()->after('header_brand_sub');
            $table->string('header_btn1_title')->nullable()->after('header_logo_path');
            $table->string('header_btn1_url')->nullable()->after('header_btn1_title');
            $table->string('header_btn2_title')->nullable()->after('header_btn1_url');
            $table->string('header_btn2_url')->nullable()->after('header_btn2_title');
        });
    }

    public function down(): void
    {
        Schema::table('landing_settings', function (Blueprint $table): void {
            $table->dropColumn([
                'header_brand_name',
                'header_brand_sub',
                'header_logo_path',
                'header_btn1_title',
                'header_btn1_url',
                'header_btn2_title',
                'header_btn2_url',
            ]);
        });
    }
};
