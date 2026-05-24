<nav x-data="{ mobileMenuOpen: false }"
    class="bg-slate-950 backdrop-blur-lg border-b border-slate-950 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">

            {{-- LOGO AREA --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('logo/logo_transparent.webp') }}" alt="Logo Karyantara Solution"
                        class="h-11 sm:h-16 w-auto object-contain transform group-hover:scale-105 transition-transform duration-300 drop-shadow-[0_0_8px_rgba(255,255,255,0.1)]">

                    <span
                        class="text-2xl font-extrabold text-white tracking-tight sm:block group-hover:text-amber-400 transition-colors duration-300">
                        Karyantara Solution<span class="text-amber-500">.</span>
                    </span>
                </a>
            </div>

            {{-- DESKTOP MENU --}}
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

            {{-- DESKTOP CTA BUTTONS --}}
            <div class="hidden md:flex items-center">
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="bg-gradient-to-r from-amber-500 to-amber-600 text-[#1E293B] px-5 py-2.5 rounded-lg font-bold hover:shadow-[0_0_15px_rgba(245,158,11,0.4)] hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-gauge-high"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('contact') }}"
                        class="bg-[#1E293B]/50 text-slate-200 border border-slate-600 backdrop-blur-md px-5 py-2.5 rounded-lg font-medium hover:text-white hover:border-amber-500 hover:bg-[#1E293B] transition-all hover:-translate-y-0.5">
                        Hubungi Kami
                    </a>
                @endauth
            </div>

            {{-- MOBILE MENU BUTTON --}}
            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="text-slate-300 hover:text-amber-500 focus:outline-none transition-colors">
                    <i class="fa-solid fa-bars text-2xl" x-show="!mobileMenuOpen"></i>
                    <i class="fa-solid fa-xmark text-2xl" x-show="mobileMenuOpen" style="display: none;"></i>
                </button>
            </div>

        </div>
    </div>

    {{-- MOBILE MENU DROPDOWN --}}
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden bg-[#0F172A] border-t border-slate-800 absolute w-full shadow-2xl" style="display: none;">

        <div class="pt-2 pb-4 space-y-1 px-2">
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

        <div class="px-4 py-4 border-t border-slate-800 bg-[#1E293B]/30">
            @auth
                <a href="{{ route('admin.dashboard') }}"
                    class="flex justify-center items-center gap-2 w-full bg-gradient-to-r from-amber-500 to-amber-600 text-[#1E293B] px-5 py-3 rounded-lg font-bold shadow-sm">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard Admin
                </a>
            @else
                <a href="{{ route('contact') }}"
                    class="block text-center w-full bg-[#1E293B] border border-slate-600 text-white px-5 py-3 rounded-lg font-medium hover:border-amber-500 transition-colors">
                    Hubungi Kami
                </a>
            @endauth
        </div>
    </div>
</nav>
