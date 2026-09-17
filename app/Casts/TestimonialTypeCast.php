<?php

namespace App\Casts;

use App\Enums\TestimonialType;

class TestimonialTypeCast extends LenientEnumCast
{
    protected function enumClass(): string
    {
        return TestimonialType::class;
    }
}
