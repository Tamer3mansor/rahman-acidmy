<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SystemSettings extends Model
{
    protected $fillable = [
        'title',
        'description',
        'logo_path',
        'favicon_path',
    ];

    public static function singleton(): self
    {
        return static::query()->first() ?? static::create();
    }

    public static function title(): string
    {
        return static::query()->value('title') ?: config('app.name');
    }

    public function logoUrl(): ?string
    {
        if ($this->logo_path === null) {
            return null;
        }

        return Storage::disk('public')->url($this->logo_path);
    }

    public function faviconUrl(): ?string
    {
        if ($this->favicon_path === null) {
            return null;
        }

        return Storage::disk('public')->url($this->favicon_path);
    }
}
