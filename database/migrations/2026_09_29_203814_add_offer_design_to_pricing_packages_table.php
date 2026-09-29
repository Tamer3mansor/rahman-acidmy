<?php

use App\Models\PricingPackage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pricing_packages', function (Blueprint $table) {
            if (! Schema::hasColumn('pricing_packages', 'show_offer_design')) {
                $table->boolean('show_offer_design')->default(false)->after('price');
            }

            if (! Schema::hasColumn('pricing_packages', 'offer_badge_text')) {
                $table->string('offer_badge_text')->nullable()->after('show_offer_design');
            }
        });

        // Every special package used to render the offer design unconditionally,
        // so the flag is backfilled on to keep the live site unchanged after
        // this deploy. New packages opt in explicitly from the dashboard.
        DB::table('pricing_packages')
            ->where('pricing_type', PricingPackage::TYPE_SPECIAL)
            ->where(function ($query) {
                $query->whereNull('show_offer_design')->orWhere('show_offer_design', false);
            })
            ->update([
                'show_offer_design' => true,
                'offer_badge_text' => PricingPackage::DEFAULT_OFFER_BADGE_TEXT,
            ]);
    }

    public function down(): void
    {
        Schema::table('pricing_packages', function (Blueprint $table) {
            $columns = array_values(array_filter(
                ['show_offer_design', 'offer_badge_text'],
                fn (string $column): bool => Schema::hasColumn('pricing_packages', $column),
            ));

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
