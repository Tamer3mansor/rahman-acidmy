<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->photo_path ? $this->resolveMediaUrl($this->photo_path) : null,
        );
    }

    private function resolveMediaUrl(string $path): string
    {
        foreach (['https://', 'http://', 'data:'] as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return $path;
            }
        }

        return asset('storage/'.$path);
    }
}
