<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <title>{{ $title }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">

    <x-public.navbar />

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <x-public.footer />

</body>

</html>
