<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingFaq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'show_cta',
        'cta_text',
        'cta_url',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'show_cta' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
