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

    <title>{{ config('app.name', 'Karyantara Admin') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        @include('layouts.navigation')

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <header
                class="bg-white shadow-sm sticky top-0 z-30 flex items-center justify-between px-4 py-3 sm:px-6 lg:px-8 lg:justify-end">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden text-gray-500 focus:outline-none hover:text-[#1E293B] transition">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <div class="flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-white hover:text-[#1E293B] focus:outline-none transition ease-in-out duration-150">
                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                <div class="ms-2">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                <i class="fa-regular fa-user mr-2"></i> {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-600">
                                    <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            @isset($header)
                <div class="bg-white border-b border-gray-200 px-4 py-5 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            @endisset

            <main class="p-4 sm:p-6 lg:p-8 w-full max-w-9xl mx-auto">
                {{ $slot }}
            </main>

        </div>
    </div>

    <x-flash-message />

    @stack('scripts')

    <div x-data="bgMusicPlayer({{ Auth::user()->autoplay_music ? 'true' : 'false' }}, '{{ Route::currentRouteName() }}')" class="fixed bottom-6 right-6 z-50 flex items-center gap-3">

        <div
            class="bg-white px-3 py-1.5 rounded-lg shadow-lg border border-gray-100 text-xs font-semibold text-[#1E293B] opacity-0 hover:opacity-100 transition-opacity duration-300 hidden sm:block">
            <span x-text="isPlaying ? 'Playing BGM...' : 'BGM Paused'"></span>
        </div>

        <button @click="toggleMusic()"
            class="w-14 h-14 rounded-full flex items-center justify-center shadow-2xl transition-all duration-300 border-2"
            :class="isPlaying ? 'bg-amber-500 border-amber-400 text-white animate-pulse' :
                'bg-[#1E293B] border-slate-700 text-amber-500 hover:bg-slate-800'">

            <i class="fa-solid text-2xl transition-transform duration-300"
                :class="isPlaying ? 'fa-circle-pause scale-110' : 'fa-music'"></i>

        </button>
    </div>
</body>

</html>
