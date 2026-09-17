<?php

namespace App\Casts;

use App\Enums\MediaType;

class MediaTypeCast extends LenientEnumCast
{
    protected function enumClass(): string
    {
        return MediaType::class;
    }
}
