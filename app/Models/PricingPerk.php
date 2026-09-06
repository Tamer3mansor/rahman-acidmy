<?php

namespace App\Models;

use Database\Factories\PricingPerkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPerk extends Model
{
    /** @use HasFactory<PricingPerkFactory> */
    use HasFactory;

    protected $fillable = [
        'icon',
        'title',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
