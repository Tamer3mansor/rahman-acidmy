<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * Where a testimonial is allowed to show up. A testimonial carries a list of
 * these, so the dashboard owns the placement instead of the placement being
 * implied by the testimonial type.
 */
enum TestimonialPlacement: string implements HasLabel
{
    case Landing = 'landing';

    case Kids = 'kids';

    case Adults = 'adults';

    public function getLabel(): string
    {
        return match ($this) {
            self::Landing => 'الصفحة الرئيسية',
            self::Kids => 'صفحة الأطفال + صفحات كورسات الأطفال',
            self::Adults => 'صفحة الكبار + صفحات كورسات الكبار',
        };
    }
}
