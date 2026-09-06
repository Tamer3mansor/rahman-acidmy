<?php

namespace App\Models;

use Database\Factories\PricingPackageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPackage extends Model
{
    /** @use HasFactory<PricingPackageFactory> */
    use HasFactory;

    public const DURATIONS = [30, 45, 60];

    public const BASE_RATES = [
        30 => 5.00,
        45 => 7.50,
        60 => 10.00,
    ];

    protected $fillable = [
        'name',
        'badge',
        'badge_style',
        'description',
        'classes_count',
        'price_per_30',
        'price_per_45',
        'price_per_60',
        'features',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'classes_count' => 'integer',
        'price_per_30' => 'float',
        'price_per_45' => 'float',
        'price_per_60' => 'float',
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function rateFor(int $minutes): float
    {
        return (float) $this->{"price_per_{$minutes}"};
    }

    public function totalFor(int $minutes): float
    {
        return round($this->classes_count * $this->rateFor($minutes), 2);
    }

    public function originalFor(int $minutes): float
    {
        return round($this->classes_count * static::BASE_RATES[$minutes], 2);
    }

    public function savingsFor(int $minutes): float
    {
        return round($this->originalFor($minutes) - $this->totalFor($minutes), 2);
    }
}
