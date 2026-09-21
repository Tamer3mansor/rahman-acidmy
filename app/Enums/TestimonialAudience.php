<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TestimonialAudience: string implements HasLabel
{
    case LandingOnly = 'none';

    case Kids = 'kids';

    case Adults = 'adults';

    case Both = 'both';

    public function getLabel(): string
    {
        return match ($this) {
            self::LandingOnly => 'الصفحة الرئيسية فقط',
            self::Kids => 'أطفال',
            self::Adults => 'كبار',
            self::Both => 'الاثنان (أطفال + كبار)',
        };
    }

    /**
     * The course pages this testimonial additionally appears on.
     *
     * @return list<CourseAudience>
     */
    public function courseAudiences(): array
    {
        return match ($this) {
            self::Kids => [CourseAudience::Kids],
            self::Adults => [CourseAudience::Adults],
            self::Both => [CourseAudience::Kids, CourseAudience::Adults],
            self::LandingOnly => [],
        };
    }
}
