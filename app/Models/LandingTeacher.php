<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingTeacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialty',
        'photo_path',
        'emoji',
        'badges',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'badges' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
