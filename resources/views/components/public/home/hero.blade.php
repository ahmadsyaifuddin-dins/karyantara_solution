<section class="relative bg-white pt-24 pb-32 lg:pt-36 lg:pb-40 overflow-hidden border-b border-gray-100">
    <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full overflow-hidden -z-10 pointer-events-none">
        <div
            class="absolute -top-24 -right-24 w-96 h-96 bg-amber-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob">
        </div>
        <div
            class="absolute top-24 -left-24 w-96 h-96 bg-slate-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000">
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div
            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-50 border border-amber-200 text-amber-600 font-semibold text-sm mb-8 shadow-sm">
            <span class="relative flex h-3 w-3">
                <span
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
            </span>
            Solusi IT Terbaik untuk Bisnis Anda
        </div>

        <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-[#1E293B] tracking-tight mb-8 leading-[1.1]">
            Wujudkan Ide Digital Anda <br class="hidden md:block">
            Bersama <span
                class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-amber-600">Karyantara</span>
        </h1>

        <p class="mt-4 text-xl md:text-2xl text-gray-500 max-w-3xl mx-auto mb-12 leading-relaxed">
            Kami adalah <span class="font-semibold text-[#1E293B]">software house</span> penyedia jasa pembuatan Website
            dan Aplikasi Mobile profesional, cepat, dan terpercaya.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
            <a href="{{ route('portfolio') }}"
                class="group flex items-center justify-center gap-2 bg-[#1E293B] text-white px-8 py-4 rounded-xl font-bold hover:bg-opacity-90 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                Lihat Karya Kami
                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </a>
            <a href="{{ route('contact') }}"
                class="flex items-center justify-center gap-2 bg-white text-[#1E293B] border-2 border-[#1E293B] px-8 py-4 rounded-xl font-bold hover:bg-gray-50 transition-all hover:-translate-y-1">
                Konsultasi Gratis
            </a>
        </div>
    </div>
</section>
