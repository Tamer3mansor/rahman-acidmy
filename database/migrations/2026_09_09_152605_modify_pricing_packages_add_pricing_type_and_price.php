<?php

use App\Models\PricingPackage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pricing_packages', function (Blueprint $table): void {
            $table->string('pricing_type')->default('special');
            $table->decimal('hours', 6, 2)->nullable();
            $table->decimal('price', 8, 2)->default(0);
        });

        PricingPackage::query()
            ->where('price', 0)
            ->each(function (PricingPackage $package): void {
                $package->forceFill(['price' => $package->price_per_45])->save();
            });

        Schema::table('pricing_packages', function (Blueprint $table): void {
            $table->dropColumn(['price_per_30', 'price_per_45', 'price_per_60']);
        });
    }

    public function down(): void
    {
        Schema::table('pricing_packages', function (Blueprint $table): void {
            $table->decimal('price_per_30', 6, 2)->default(0);
            $table->decimal('price_per_45', 6, 2)->default(0);
            $table->decimal('price_per_60', 6, 2)->default(0);
        });

        PricingPackage::query()->each(function (PricingPackage $package): void {
            $package->forceFill([
                'price_per_30' => 0,
                'price_per_45' => $package->price,
                'price_per_60' => 0,
            ])->save();
        });

        Schema::table('pricing_packages', function (Blueprint $table): void {
            $table->dropColumn(['pricing_type', 'hours', 'price']);
        });
    }
};
