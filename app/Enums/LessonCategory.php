<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum LessonCategory: string implements HasLabel
{
    case Kids = 'kids';

    case Adults = 'adults';

    case Tajwid = 'tajwid';

    public function getLabel(): string
    {
        return match ($this) {
            self::Kids => 'أطفال',
            self::Adults => 'كبار',
            self::Tajwid => 'تجويد وتلاوة',
        };
    }
}
