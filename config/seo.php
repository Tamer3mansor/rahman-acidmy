<?php

return [

    'url' => env('SEO_URL', 'https://el-rahman.looptech.cloud'),

    'lang' => env('SEO_LANG', 'fr'),

    'default_title' => 'Ar-Rahman Academy | Cours de Coran et arabe en ligne en France, Belgique et Canada',

    'default_description' => 'Cours de Coran et de langue arabe en ligne pour enfants et adultes en France, Belgique et Canada. Enseignants diplômés Al-Azhar.',

    'og_image' => env('SEO_OG_IMAGE', 'images/og-image.jpg'),

    'whatsapp' => env('SEO_WHATSAPP', 'https://wa.me/201028268553'),

    // Google Search Console verification code (user token only).
    // Paste the value from the GSC "HTML tag" verification method, e.g. "abc123...".
    'google_verification' => env('GOOGLE_SITE_VERIFICATION', ''),

    // Single source of truth for the Organization structured data
    // rendered in <head>. Populated from .env where sensible.
    'organization' => [
        'name' => env('SEO_ORG_NAME', 'Ar-Rahman Academy'),
        'alternateName' => env('SEO_ORG_ALT_NAME', 'Académie Ar-Rahman'),
        'url' => env('SEO_URL', 'https://el-rahman.looptech.cloud'),
        'logo' => env('SEO_ORG_LOGO', 'https://el-rahman.looptech.cloud/images/logo.png'),
        'description' => 'Cours de Coran et de langue arabe en ligne pour enfants et adultes. Enseignants diplômés d\'Al-Azhar et titulaires d\'Ijazah.',
        'telephone' => env('SEO_ORG_PHONE', '+201028268553'),
        'whatsapp' => env('SEO_WHATSAPP', 'https://wa.me/201028268553'),
        'email' => env('SEO_ORG_EMAIL', 'contact@arrahman-academy.com'),
        'foundingDate' => '2024',
        'priceRange' => '€€',
        'areaServed' => ['FR', 'BE', 'CA', 'MA', 'DZ', 'TN'],
        'availableLanguage' => ['French', 'Arabic'],
    ],
];
