<section
    class="relative w-full min-h-screen overflow-hidden border-b border-gray-800 flex items-center justify-center py-20 md:py-28">

    {{-- Video Background --}}
    <div class="absolute inset-0 z-0">
        <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover z-0">
            {{-- URL Video --}}
            <source
                src="https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260210_031346_d87182fb-b0af-4273-84d1-c6fd17d6bf0f.mp4"
                type="video/mp4" />
        </video>

        {{-- Overlay Gelap Terang (Opacity 30%) --}}
        <div class="absolute inset-0 bg-[#0F172A]/30 mix-blend-multiply pointer-events-none"></div>
        <div
            class="absolute inset-0 bg-gradient-to-b from-transparent via-[#0F172A]/20 to-[#0F172A] pointer-events-none">
        </div>
    </div>

    {{-- Konten Hero Utama --}}
    <div
        class="relative z-10 flex flex-col items-center text-center px-4 sm:px-6 max-w-7xl mx-auto w-full mt-10 md:mt-0">

        {{-- Tagline Pill --}}
        <div
            class="inline-flex items-center gap-3 px-2 py-1.5 pr-4 rounded-xl backdrop-blur-xl border border-amber-500/30 bg-[#1E293B]/50 shadow-[0_0_20px_rgba(245,158,11,0.15)] mb-8 transform transition hover:scale-105 cursor-default">
            <span
                class="bg-gradient-to-r from-amber-400 to-amber-600 text-[#1E293B] font-bold text-xs px-3 py-1.5 rounded-lg shadow-[0_0_10px_rgba(245,158,11,0.3)]">
                Karyantara
            </span>
            <span class="font-medium text-sm text-slate-200 tracking-wide font-archive uppercase">
                Solusi Digital Anda
            </span>
        </div>

        {{-- Headline --}}
        <h1
            class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight mb-6 leading-[1.1] drop-shadow-2xl max-w-5xl">
            Wujudkan Ide Digital Anda <br class="hidden md:block" />
            Bersama <span
                class="font-archive font-normal tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-amber-500 to-amber-600">KARYANTARA
                SOLUTION</span>
        </h1>

        {{-- Subtext --}}
        <p class="text-lg md:text-xl text-slate-200 max-w-3xl mx-auto mb-10 leading-relaxed font-light drop-shadow-lg">
            Kami adalah <span class="font-semibold text-white font-archive">software house</span> profesional penyedia
            jasa pembuatan Website, Sistem Informasi, dan Aplikasi Mobile di Banjarmasin.
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6 w-full sm:w-auto">
            <a href="{{ route('portfolio') }}"
                class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-[#1E293B] font-bold text-base hover:brightness-110 transition-all shadow-[0_0_20px_rgba(245,158,11,0.3)] hover:shadow-[0_0_30px_rgba(245,158,11,0.5)] flex items-center justify-center gap-2 hover:-translate-y-1 duration-300 group">
                Lihat Portofolio Kami
                <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </a>
            <a href="{{ route('contact') }}"
                class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#1E293B]/60 border border-slate-500/50 text-white backdrop-blur-md font-bold text-base hover:bg-[#1E293B]/90 hover:border-amber-500/50 transition-all flex items-center justify-center gap-2 hover:-translate-y-1 duration-300 shadow-lg">
                Konsultasi Gratis
            </a>
        </div>

        {{-- FITUR / MITRA DIGITAL CARD --}}
        <div
            class="mt-24 md:mt-28 w-full animate-floating backdrop-blur-xl bg-[#1E293B]/70 border border-white/10 border-t-amber-500/40 rounded-2xl p-8 md:p-10 shadow-2xl relative overflow-hidden group hover:border-t-amber-500/80 transition-colors duration-500 text-left">

            {{-- Kilauan cahaya transparan di dalam card --}}
            <div
                class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/5 to-transparent pointer-events-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 md:gap-6 relative z-10 items-center">

                {{-- Kolom Judul Card --}}
                <div class="md:col-span-1 md:border-r border-slate-700 md:pr-6">
                    <h3 class="text-2xl md:text-3xl font-extrabold text-white leading-tight">
                        Mitra Digital<br>
                        <span class="text-amber-500">Terpercaya</span>
                    </h3>
                </div>

                {{-- Poin 1 --}}
                <div class="md:pl-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-code text-amber-500 text-sm"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white">Kualitas Terbaik</h4>
                    </div>
                    <p class="text-sm text-slate-300 leading-relaxed">Sistem dibangun dengan standar industri untuk
                        performa optimal.</p>
                </div>

                {{-- Poin 2 --}}
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-rocket text-amber-500 text-sm"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white">Pengerjaan Cepat</h4>
                    </div>
                    <p class="text-sm text-slate-300 leading-relaxed">Implementasi metode efisien agar proyek selesai
                        tepat waktu.</p>
                </div>

                {{-- Poin 3 --}}
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-shield-halved text-amber-500 text-sm"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white">Keamanan Ekstra</h4>
                    </div>
                    <p class="text-sm text-slate-300 leading-relaxed">Proteksi data berlapis dan struktur kode yang aman
                        & rapi.</p>
                </div>

            </div>
        </div>

    </div>
</section>
