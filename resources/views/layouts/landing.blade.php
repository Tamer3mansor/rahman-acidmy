<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title', config('seo.default_title'))</title>
    <meta name="description" content="@yield('description', config('seo.default_description'))">
    <meta name="robots" content="{{ $isIndexed ?? true ? 'index,follow' : 'noindex,nofollow' }}">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- hreflang --}}
    <link rel="alternate" hreflang="fr" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="ar" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="x-default" href="{{ config('app.url') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Ar-Rahman Academy')">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset(config('seo.og_image')))">
    <meta property="og:site_name" content="Ar-Rahman Academy">
    <meta property="og:locale" content="fr_FR">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Ar-Rahman Academy')">
    <meta name="twitter:description" content="@yield('description')">
    <meta name="twitter:image" content="@yield('og_image', asset(config('seo.og_image')))">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/landing.css', 'resources/js/landing.js'])

    @yield('styles')
    @yield('head')

    {{-- Organization Schema --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "EducationalOrganization",
        "name": "Ar-Rahman Academy",
        "alternateName": "Académie Ar-Rahman",
        "url": "https://el-rahman.looptech.cloud",
        "logo": "https://el-rahman.looptech.cloud/images/logo.png",
        "description": "Cours de Coran et de langue arabe en ligne pour enfants et adultes. Enseignants diplômés d'Al-Azhar et titulaires d'Ijazah.",
        "telephone": "+201028268553",
        "email": "contact@arrahman-academy.com",
        "foundingDate": "2024",
        "areaServed": ["FR", "BE", "CA", "MA", "DZ", "TN"],
        "availableLanguage": ["French", "Arabic"],
        "sameAs": [
            "https://wa.me/201028268553"
        ]
    }
    </script>
</head>
<body class="@yield('bodyClass')">

    @yield('content')

    @yield('scripts')

</body>
</html>