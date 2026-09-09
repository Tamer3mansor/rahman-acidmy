<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingSettings extends Model
{
    protected $fillable = [
        'per_hour_price',
    ];

    protected $casts = [
        'per_hour_price' => 'float',
    ];

    public static function singleton(): self
    {
        return static::query()->first() ?? static::create();
    }
}
