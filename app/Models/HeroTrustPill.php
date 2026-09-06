<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroTrustPill extends Model
{
    use HasFactory;

    protected $table = 'landing_hero_trust_pills';

    public $timestamps = true;

    protected $fillable = [
        'icon',
        'text',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
