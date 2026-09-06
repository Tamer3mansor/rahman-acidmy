<?php

namespace App\Models;

use App\Enums\CompareItemType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompareItem extends Model
{
    use HasFactory;

    protected $table = 'landing_compare_items';

    public $timestamps = true;

    protected $fillable = [
        'type',
        'text',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'type' => CompareItemType::class,
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
