<?php

namespace App\Models;

use App\Enums\TestimonialType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingTestimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'author_name',
        'author_location',
        'content',
        'media_path',
        'rating',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'type' => TestimonialType::class,
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
