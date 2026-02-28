<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
</body>

</html>
