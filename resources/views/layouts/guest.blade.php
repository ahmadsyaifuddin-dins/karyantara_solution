<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Karyantara Solution') }} - Login</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('logo/logo_transparent.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo/logo_transparent.jpg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-white">

    <div class="flex min-h-screen">

        <div class="w-full lg:w-1/2 flex flex-col justify-center px-6 py-10 sm:px-12 lg:px-16">
            <div class="w-full max-w-sm mx-auto flex flex-col flex-grow justify-center">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-xs text-gray-400 font-medium">
                &copy; 2026-{{ date('Y') }} KARYANTARA SOLUTION
            </div>
        </div>

        <div class="hidden lg:flex lg:w-1/2 relative bg-cover bg-center sticky top-0 h-screen"
            style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920&auto=format&fit=crop');">

            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>

            <div class="absolute bottom-16 left-12 right-12 z-10">
                <h2 class="text-4xl font-bold text-white mb-3 drop-shadow-md">Selamat Datang</h2>
                <p class="text-gray-200 text-lg leading-relaxed drop-shadow">
                    Sistem Manajemen Proyek & Klien Karyantara Solution yang transparan, akuntabel, dan modern.
                </p>
            </div>
        </div>

    </div>

</body>

</html>
