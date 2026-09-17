<?php

namespace App\Models;

use App\Casts\TestimonialTypeCast;
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
        'type' => TestimonialTypeCast::class,
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
