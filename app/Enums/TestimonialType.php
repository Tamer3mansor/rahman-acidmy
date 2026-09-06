<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TestimonialType: string implements HasLabel
{
    case Video = 'video';

    case Whatsapp = 'whatsapp';

    case Google = 'google';

    public function getLabel(): string
    {
        return match ($this) {
            self::Video => 'فيديو',
            self::Whatsapp => 'واتساب',
            self::Google => 'تقييم جوجل',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Video => 'danger',
            self::Whatsapp => 'success',
            self::Google => 'warning',
        };
    }
}
