<?php

namespace App\Casts;

use App\Enums\TestimonialPlacement;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Casts the JSON `placements` column to a list of TestimonialPlacement.
 *
 * Unknown values are dropped on read so a placement that no longer exists in the
 * enum cannot break a page render, mirroring the lenient single-enum casts used
 * for `type`.
 */
class TestimonialPlacementsCast implements CastsAttributes
{
    /**
     * @return list<TestimonialPlacement>
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array
    {
        $decoded = is_array($value) ? $value : json_decode((string) $value, true);

        if (! is_array($decoded)) {
            return [];
        }

        $placements = array_map(
            fn (mixed $placement): ?TestimonialPlacement => is_string($placement)
                ? TestimonialPlacement::tryFrom($placement)
                : null,
            $decoded,
        );

        return array_values(array_filter($placements));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null) {
            return null;
        }

        $values = array_map(
            fn (mixed $placement): mixed => $placement instanceof TestimonialPlacement
                ? $placement->value
                : $placement,
            (array) $value,
        );

        $values = array_unique(array_filter($values, 'is_string'));

        return json_encode(array_values($values));
    }
}
