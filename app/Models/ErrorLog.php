<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ErrorLog extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'trace' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTracePreviewAttribute(): string
    {
        $frames = collect($this->trace ?? [])
            ->slice(0, 20)
            ->map(function (array $frame): string {
                $location = sprintf('%s:%s', $frame['file'] ?? 'unknown', $frame['line'] ?? '?');
                $caller = $frame['class'] ?? '';
                $caller .= $frame['type'] ?? '';
                $caller .= $frame['function'] ?? '';

                return $caller === '' || $caller === '?'
                    ? $location
                    : sprintf('%s %s()', $location, $caller);
            })
            ->implode(PHP_EOL);

        return $frames === '' ? $this->message : $frames;
    }
}
