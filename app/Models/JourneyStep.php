<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JourneyStep extends Model
{
    use HasFactory;

    protected $table = 'landing_journey_steps';

    public $timestamps = true;

    protected $fillable = [
        'step_number',
        'icon',
        'title',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'step_number' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
