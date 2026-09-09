<?php

namespace App\Models;

use Database\Factories\PricingPackageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPackage extends Model
{
    /** @use HasFactory<PricingPackageFactory> */
    use HasFactory;

    public const TYPE_PER_HOUR = 'per_hour';

    public const TYPE_SPECIAL = 'special';

    public const PRICING_TYPES = [
        self::TYPE_PER_HOUR => 'السعر/ساعة',
        self::TYPE_SPECIAL => 'سعر خاص',
    ];

    protected $fillable = [
        'name',
        'badge',
        'badge_style',
        'description',
        'classes_count',
        'pricing_type',
        'hours',
        'price',
        'features',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'classes_count' => 'integer',
        'pricing_type' => 'string',
        'hours' => 'float',
        'price' => 'float',
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function effectivePrice(): float
    {
        if ($this->pricing_type === static::TYPE_PER_HOUR && $this->hours !== null) {
            return round($this->hours * PricingSettings::singleton()->per_hour_price, 2);
        }

        return round((float) $this->price, 2);
    }

    public function ratePerLesson(): float
    {
        if ($this->classes_count < 1) {
            return $this->effectivePrice();
        }

        return round($this->effectivePrice() / $this->classes_count, 2);
    }
}
