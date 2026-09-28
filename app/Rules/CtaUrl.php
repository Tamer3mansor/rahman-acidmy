<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates a CTA target configured from the dashboard.
 *
 * A CTA may point at a full URL, a root-relative path, or a bare `#anchor`
 * that is resolved against the home route at render time. The built-in `url`
 * rule rejects the latter two, so it cannot be used on these fields.
 */
class CtaUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $url = trim((string) $value);

        if ($url === '' || str_starts_with($url, '#')) {
            return;
        }

        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            return;
        }

        if (preg_match('#^/\S*$#', $url) === 1) {
            return;
        }

        $fail('يجب أن يكون الرابط رابطًا كاملًا (https://...) أو مسارًا يبدأ بـ / أو هاش مثل #trial-form.');
    }
}
