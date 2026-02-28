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

    <nav x-data="{ mobileMenuOpen: false }" class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">

                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-[#1E293B]">
                        Karyantara Solution<span class="text-amber-500">.</span>
                    </a>
                </div>

                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}"
                        class="text-gray-600 hover:text-[#1E293B] font-medium transition">Beranda</a>
                    <a href="{{ route('portfolio') }}"
                        class="text-gray-600 hover:text-[#1E293B] font-medium transition">Portofolio</a>
                    <a href="{{ route('testimonial') }}"
                        class="text-gray-600 hover:text-[#1E293B] font-medium transition">Testimonial</a>
                    <a href="{{ route('about') }}"
                        class="text-gray-600 hover:text-[#1E293B] font-medium transition">Tentang Kami</a>
                </div>

                <div class="hidden md:flex items-center">
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="bg-amber-500 text-[#1E293B] px-5 py-2.5 rounded-md font-bold hover:bg-amber-400 transition shadow-sm flex items-center gap-2">
                            <i class="fa-solid fa-gauge-high"></i> Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('contact') }}"
                            class="bg-[#1E293B] text-white px-5 py-2.5 rounded-md font-medium hover:bg-opacity-90 transition shadow-sm">
                            Hubungi Kami
                        </a>
                    @endauth
                </div>

                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-gray-500 hover:text-[#1E293B] focus:outline-none transition">
                        <i class="fa-solid fa-bars text-2xl" x-show="!mobileMenuOpen"></i>
                        <i class="fa-solid fa-xmark text-2xl" x-show="mobileMenuOpen" style="display: none;"></i>
                    </button>
                </div>

            </div>
        </div>

        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg" style="display: none;">

            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="{{ route('home') }}"
                    class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-[#1E293B] hover:bg-gray-50">Beranda</a>
                <a href="{{ route('portfolio') }}"
                    class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-[#1E293B] hover:bg-gray-50">Portofolio</a>
                <a href="{{ route('testimonial') }}"
                    class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-[#1E293B] hover:bg-gray-50">Testimonial</a>
                <a href="{{ route('about') }}"
                    class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-[#1E293B] hover:bg-gray-50">Tentang
                    Kami</a>
            </div>

            <div class="px-4 py-4 border-t border-gray-100">
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="block text-center w-full bg-amber-500 text-[#1E293B] px-5 py-3 rounded-md font-bold hover:bg-amber-400 transition shadow-sm">
                        <i class="fa-solid fa-gauge-high mr-2"></i> Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('contact') }}"
                        class="block text-center w-full bg-[#1E293B] text-white px-5 py-3 rounded-md font-medium hover:bg-opacity-90 transition shadow-sm">
                        Hubungi Kami
                    </a>
                @endauth
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
