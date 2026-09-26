<!DOCTYPE html>
<html lang="{{ config('seo.lang', 'fr') }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @if ($faviconUrl = \App\Models\SystemSettings::singleton()->faviconUrl())
        <link rel="icon" href="{{ $faviconUrl }}">
        <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
    @endif

    @if (config('seo.google_verification'))
        <meta name="google-site-verification" content="{{ config('seo.google_verification') }}">
    @endif

    <title>@yield('title', config('seo.default_title'))</title>
    <meta name="description" content="@yield('description', config('seo.default_description'))">
    <meta name="robots" content="{{ $isIndexed ?? true ? 'index,follow' : 'noindex,nofollow' }}">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- hreflang --}}
    @php
        $primaryLang = config('seo.lang', 'fr');
    @endphp
    <link rel="alternate" hreflang="{{ $primaryLang }}" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="x-default" href="{{ config('seo.url') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', config('seo.organization.name'))">
    <meta property="og:description" content="@yield('description', config('seo.default_description'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset(config('seo.og_image')))">
    <meta property="og:site_name" content="{{ config('seo.organization.name') }}">
    <meta property="og:locale" content="{{ $primaryLang }}_{{ strtoupper($primaryLang) }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', config('seo.organization.name'))">
    <meta name="twitter:description" content="@yield('description', config('seo.default_description'))">
    <meta name="twitter:image" content="@yield('og_image', asset(config('seo.og_image')))">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    {{-- Applies the stored theme before first paint so a dark-mode visitor never
         sees a white flash. Must stay inline and blocking, above the stylesheet. --}}
    <script>
        (function () {
            var stored = null;
            try {
                stored = window.localStorage.getItem('theme');
            } catch (error) {
                stored = null;
            }
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            var theme = stored === 'light' || stored === 'dark'
                ? stored
                : (prefersDark ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    @vite(['resources/css/landing.css', 'resources/js/landing.js', 'resources/js/testimonials.js'])

    @yield('styles')
    @yield('head')

    {{-- Organization Schema --}}
    @php
        $org = config('seo.organization');
        $orgSchema = null;
        if (is_array($org)) {
            $orgSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'EducationalOrganization',
                'name' => $org['name'] ?? config('app.name'),
                'alternateName' => $org['alternateName'] ?? '',
                'url' => $org['url'] ?? url()->to('/'),
                'logo' => $org['logo'] ?? asset(config('seo.og_image')),
                'description' => $org['description'] ?? '',
                'telephone' => $org['telephone'] ?? '',
                'email' => $org['email'] ?? '',
                'foundingDate' => $org['foundingDate'] ?? '',
                'priceRange' => $org['priceRange'] ?? '',
                'areaServed' => $org['areaServed'] ?? [],
                'availableLanguage' => $org['availableLanguage'] ?? [],
                'sameAs' => array_values(array_filter($org['sameAs'] ?? [$org['whatsapp'] ?? ''])),
            ];
        }
    @endphp
    @if ($orgSchema)
        <script type="application/ld+json">{!! json_encode($orgSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endif
</head>
<body class="@yield('bodyClass')">

    @yield('content')

    @yield('scripts')

</body>
</html>