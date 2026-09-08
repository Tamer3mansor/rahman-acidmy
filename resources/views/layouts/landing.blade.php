<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', $settings->footer_brand_name . ' | ' . $settings->footer_brand_sub)</title>
    <meta name="description" content="@yield('meta_description')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/landing.css', 'resources/js/landing.js'])

    @yield('styles')
    @yield('head')
</head>
<body class="@yield('bodyClass')">

    @yield('content')

    @yield('scripts')

</body>
</html>