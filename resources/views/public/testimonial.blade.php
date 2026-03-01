<x-public-layout title="Testimonial Klien - Karyantara Solution">

    <div class="relative bg-slate-50 pt-20 pb-28 lg:pt-24 lg:pb-32 overflow-hidden min-h-screen">

        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-white to-transparent pointer-events-none">
        </div>
        <div
            class="absolute top-20 left-10 w-72 h-72 bg-amber-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob pointer-events-none">
        </div>
        <div
            class="absolute top-40 right-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="text-center mb-16">
                <span class="text-sm font-bold text-amber-500 tracking-wider uppercase mb-2 block">Ulasan Klien</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#1E293B]">Apa Kata Mereka?</h1>
                <div class="w-24 h-1.5 bg-gradient-to-r from-amber-400 to-amber-600 mx-auto mt-6 rounded-full mb-6">
                </div>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
                    Kepuasan klien adalah metrik utama kesuksesan kami. Berikut adalah pengalaman nyata mereka bekerja
                    sama dengan tim Karyantara Solution.
                </p>
            </div>

            @if (session('success'))
                <div
                    class="max-w-3xl mx-auto mb-10 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-start">
                    <i class="fa-solid fa-circle-check text-green-500 mt-0.5 mr-3 text-lg"></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="max-w-3xl mx-auto mb-10 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-start">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 mt-0.5 mr-3 text-lg"></i>
                    <div>
                        <p class="text-red-800 font-bold mb-1">Gagal mengirim ulasan:</p>
                        <ul class="text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @include('public.partials.testimonials.list')

            @include('public.partials.testimonials.form')

        </div>
    </div>
</x-public-layout>
