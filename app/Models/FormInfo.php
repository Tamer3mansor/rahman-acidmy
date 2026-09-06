<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormInfo extends Model
{
    use HasFactory;

    protected $table = 'landing_form_infos';

    public $timestamps = true;

    protected $fillable = [
        'icon',
        'label',
        'value',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
