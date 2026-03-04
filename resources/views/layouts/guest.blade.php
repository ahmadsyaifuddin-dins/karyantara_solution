<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/jpeg" href="{{ asset('logo/logo_transparent.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo/logo_transparent.jpg') }}">

    <meta name="title" content="Karyantara Solution - IT Consultant & Software Development">
    <meta name="description"
        content="Karyantara Solution melayani jasa IT Consultant, Software Development, pembuatan website, aplikasi mobile, dan sistem informasi profesional di Banjarmasin.">
    <meta name="keywords"
        content="IT Consultant, Software Development, Pembuatan Website, Pembuatan Aplikasi, Jasa Skripsi IT, Karyantara Solution, Banjarmasin">
    <meta name="author" content="Karyantara Solution">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Karyantara Solution - IT Consultant & Software Development">
    <meta property="og:description"
        content="Kami memberikan solusi digital terbaik untuk bisnis dan kebutuhan akademik Anda. Profesional, cepat, dan terpercaya.">
    <meta property="og:image" content="{{ asset('logo/logo_transparent.jpg') }}">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Karyantara Solution - IT Consultant & Software Development">
    <meta property="twitter:description" content="Solusi digital terbaik untuk bisnis dan kebutuhan akademik Anda.">
    <meta property="twitter:image" content="{{ asset('logo/logo_transparent.jpg') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
