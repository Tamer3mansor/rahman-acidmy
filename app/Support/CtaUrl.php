<?php

namespace App\Support;

class CtaUrl
{
    /**
     * Resolve a CTA URL configured in the dashboard.
     *
     * Home-page anchors such as `#trial-form` only exist on the home page, so
     * when they are used from any other route they must be prefixed with the
     * home URL. External URLs and root-relative paths are returned untouched.
     */
    public static function resolve(?string $url, string $activePage = 'home'): string
    {
        $url = trim((string) $url);

        if ($url === '' || $url === '#') {
            return $url;
        }

        if (! str_starts_with($url, '#')) {
            return $url;
        }

        return $activePage === 'home' ? $url : route('home').$url;
    }
}
