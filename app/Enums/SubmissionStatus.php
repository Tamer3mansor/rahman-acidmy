<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SubmissionStatus: string implements HasLabel
{
    case New = 'new';

    case Contacted = 'contacted';

    case Scheduled = 'scheduled';

    case Postponed = 'postponed';

    public function getLabel(): string
    {
        return match ($this) {
            self::New => 'جديد',
            self::Contacted => 'تم التواصل',
            self::Scheduled => 'تم الجدولة',
            self::Postponed => 'مؤجل',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::New => 'danger',
            self::Contacted => 'info',
            self::Scheduled => 'success',
            self::Postponed => 'warning',
        };
    }
}
