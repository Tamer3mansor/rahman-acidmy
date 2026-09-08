<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CourseAudience: string implements HasLabel
{
    case Kids = 'kids';

    case Adults = 'adults';

    public function getLabel(): string
    {
        return match ($this) {
            self::Kids => 'أطفال',
            self::Adults => 'كبار',
        };
    }
}
