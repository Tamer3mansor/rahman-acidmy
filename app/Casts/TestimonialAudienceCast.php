<?php

namespace App\Casts;

use App\Enums\TestimonialAudience;

class TestimonialAudienceCast extends LenientEnumCast
{
    protected function enumClass(): string
    {
        return TestimonialAudience::class;
    }
}
