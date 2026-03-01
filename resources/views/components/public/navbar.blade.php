<nav x-data="{ mobileMenuOpen: false }" class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">

            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('logo/logo.png') }}" alt="Logo Karyantara Solution"
                        class="h-10 w-auto object-contain transform group-hover:scale-105 transition-transform duration-300">

                    <span
                        class="text-2xl font-extrabold text-[#1E293B] tracking-tight sm:block group-hover:text-amber-600 transition-colors">
                        Karyantara Solution<span class="text-amber-500">.</span>
                    </span>
                </a>
            </div>

            <div class="hidden md:flex space-x-8 items-center">
                <x-public.nav-link :href="route('home')" :active="request()->routeIs('home')">
                    Beranda
                </x-public.nav-link>
                <x-public.nav-link :href="route('portfolio')" :active="request()->routeIs('portfolio*')">
                    Portofolio
                </x-public.nav-link>
                <x-public.nav-link :href="route('testimonial')" :active="request()->routeIs('testimonial')">
                    Testimonial
                </x-public.nav-link>
                <x-public.nav-link :href="route('about')" :active="request()->routeIs('about')">
                    Tentang Kami
                </x-public.nav-link>
                <x-public.nav-link :href="route('terms')" :active="request()->routeIs('terms')">
                    Syarat & Ketentuan
                </x-public.nav-link>
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

        <div class="pt-2 pb-4 space-y-1">
            <x-public.mobile-nav-link :href="route('home')" :active="request()->routeIs('home')">
                Beranda
            </x-public.mobile-nav-link>
            <x-public.mobile-nav-link :href="route('portfolio')" :active="request()->routeIs('portfolio*')">
                Portofolio
            </x-public.mobile-nav-link>
            <x-public.mobile-nav-link :href="route('testimonial')" :active="request()->routeIs('testimonial')">
                Testimonial
            </x-public.mobile-nav-link>
            <x-public.mobile-nav-link :href="route('about')" :active="request()->routeIs('about')">
                Tentang Kami
            </x-public.mobile-nav-link>
            <x-public.mobile-nav-link :href="route('terms')" :active="request()->routeIs('terms')">
                Syarat & Ketentuan
            </x-public.mobile-nav-link>
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
