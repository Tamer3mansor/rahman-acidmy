<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MediaType: string implements HasLabel
{
    case Video = 'video';

    case Image = 'image';

    public function getLabel(): string
    {
        return match ($this) {
            self::Video => 'فيديو',
            self::Image => 'صورة',
        };
    }
}
