<x-public-layout title="Syarat & Ketentuan - Karyantara Solution">

    <div class="relative bg-slate-50 pt-24 pb-32 overflow-hidden min-h-screen">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-white to-transparent pointer-events-none">
        </div>
        <div
            class="absolute top-20 right-10 w-96 h-96 bg-amber-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            @include('public.partials.terms.header')

            <div x-data="{ activeTab: 'mahasiswa' }" class="max-w-6xl mx-auto">

                @include('public.partials.terms.tab-navigation')

                @include('public.partials.terms.tab-mahasiswa')

                @include('public.partials.terms.tab-bisnis')

            </div>

            @include('public.partials.terms.footer')

        </div>
    </div>

</x-public-layout>
