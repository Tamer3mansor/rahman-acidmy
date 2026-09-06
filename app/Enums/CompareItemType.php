<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CompareItemType: string implements HasLabel
{
    case Problem = 'problem';

    case Solution = 'solution';

    public function getLabel(): string
    {
        return match ($this) {
            self::Problem => 'مشكلة (✕)',
            self::Solution => 'حل (✓)',
        };
    }
}
