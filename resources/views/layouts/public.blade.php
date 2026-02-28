@props(['title' => 'Karyantara Solution - Web & Mobile App Development'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-[#1E293B]">
                        Karyantara Solution<span class="text-amber-500">.</span>
                    </a>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}"
                        class="text-gray-600 hover:text-[#1E293B] font-medium transition">Beranda</a>
                    <a href="{{ route('portfolio') }}"
                        class="text-gray-600 hover:text-[#1E293B] font-medium transition">Portofolio</a>
                    <a href="{{ route('testimonial') }}"
                        class="text-gray-600 hover:text-[#1E293B] font-medium transition">Testimonial</a>
                    <a href="{{ route('about') }}"
                        class="text-gray-600 hover:text-[#1E293B] font-medium transition">Tentang Kami</a>
                </div>

                <div class="hidden md:flex">
                    <a href="{{ route('contact') }}"
                        class="bg-[#1E293B] text-white px-5 py-2.5 rounded-md font-medium hover:bg-opacity-90 transition shadow-sm">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="bg-[#1E293B] text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">Karyantara Solution</h3>
                    <p class="text-gray-400 text-sm">Mitra terbaik Anda dalam mewujudkan solusi digital yang inovatif,
                        modern, dan profesional.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-amber-400">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('portfolio') }}" class="hover:text-white transition">Portofolio</a></li>
                        <li><a href="{{ route('testimonial') }}" class="hover:text-white transition">Testimonial
                                Klien</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-white transition">Syarat & Ketentuan</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-amber-400">Kontak</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><i class="fa-solid fa-envelope mr-2"></i> karyantarasolution@gmail.com</li>
                        <li><i class="fa-solid fa-phone mr-2"></i> +62 812 3456 7890</li>
                        <li><i class="fa-solid fa-location-dot mr-2"></i> Banjarmasin, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} Karyantara Solution. All rights reserved.
            </div>
        </div>
    </footer>

</body>

</html>
