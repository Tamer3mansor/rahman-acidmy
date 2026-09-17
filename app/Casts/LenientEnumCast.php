<?php

namespace App\Casts;

use BackedEnum;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

abstract class LenientEnumCast implements CastsAttributes
{
    abstract protected function enumClass(): string;

    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        /** @var class-string<BackedEnum> $enum */
        $enum = $this->enumClass();

        return $value === null ? null : $enum::tryFrom($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_object($value) && $value instanceof BackedEnum) {
            return $value->value;
        }

        return $value;
    }
}
