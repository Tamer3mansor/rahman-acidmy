<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingWhyItem extends Model
{
    use HasFactory;

    protected $table = 'landing_why_items';

    public $timestamps = true;

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
