<section x-data="{
    mouseX: 0,
    mouseY: 0,
    isHovered: false,
    updateMouse(event) {
        // Kalkulasi posisi mouse relatif terhadap section ini
        const rect = this.$el.getBoundingClientRect();
        this.mouseX = event.clientX - rect.left;
        this.mouseY = event.clientY - rect.top;
    }
}" @mousemove="updateMouse($event); isHovered = true" @mouseleave="isHovered = false"
    class="relative bg-[#0F172A] pt-20 pb-24 lg:pt-32 lg:pb-32 overflow-hidden border-b border-gray-800">

    <div class="absolute inset-0 z-0 flex justify-center items-center pointer-events-none">
        <div class="w-full max-w-2xl h-[300px] bg-amber-500/10 blur-[120px] rounded-full"></div>
    </div>

    <div class="absolute inset-0 z-0 pointer-events-none bg-grid-pattern opacity-30"></div>

    <div class="absolute inset-0 z-0 pointer-events-none transition-opacity duration-500 ease-out"
        :class="isHovered ? 'opacity-100' : 'opacity-0'"
        :style="`background: radial-gradient(600px circle at ${mouseX}px ${mouseY}px, rgba(245, 158, 11, 0.15), transparent 40%);`">
    </div>

    <div class="absolute inset-0 z-0 pointer-events-none bg-grid-pattern transition-opacity duration-500 ease-out"
        :class="isHovered ? 'opacity-100' : 'opacity-0'"
        :style="`-webkit-mask-image: radial-gradient(400px circle at ${mouseX}px ${mouseY}px, black, transparent 60%); mask-image: radial-gradient(400px circle at ${mouseX}px ${mouseY}px, black, transparent 60%);`">
    </div>


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">

        <div
            class="inline-flex items-center font-archive gap-2 px-4 py-2 rounded-full bg-[#1E293B]/80 border border-amber-500/30 text-amber-400 font-semibold text-sm mb-8 backdrop-blur-md shadow-[0_0_15px_rgba(245,158,11,0.1)]">
            <span class="relative flex h-3 w-3">
                <span
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
            </span>
            Karyantara Solution — Solusi Digital Anda
        </div>

        <h1
            class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight mb-8 leading-[1.1] drop-shadow-xl">
            Wujudkan Ide Digital Anda <br class="hidden md:block">
            Bersama <span
                class="font-archive font-normal tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-amber-500 to-amber-600">KARYANTARA
                SOLUTION</span>
        </h1>

        <p class="mt-4 text-xl md:text-2xl text-slate-400 max-w-3xl mx-auto mb-14 leading-relaxed font-light">
            Kami adalah <span class="font-semibold text-white font-archive">software house</span> profesional penyedia
            jasa pembuatan
            Website, Sistem Informasi, dan Aplikasi Mobile di Banjarmasin.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
            <a href="{{ route('portfolio') }}"
                class="group flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 text-[#1E293B] px-8 py-4 rounded-xl font-bold transition-all shadow-[0_0_20px_rgba(245,158,11,0.3)] hover:shadow-[0_0_30px_rgba(245,158,11,0.5)] hover:-translate-y-1">
                Lihat Portofolio Kami
                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </a>
            <a href="{{ route('contact') }}"
                class="flex items-center justify-center gap-2 bg-[#1E293B]/80 text-white border border-slate-600 backdrop-blur-md px-8 py-4 rounded-xl font-bold hover:bg-[#1E293B] hover:border-amber-500/50 transition-all hover:-translate-y-1">
                Konsultasi Gratis
            </a>
        </div>

        <div
            class="mt-24 md:mt-32 animate-floating backdrop-blur-xl bg-[#1E293B]/70 border border-white/10 border-t-amber-500/40 rounded-2xl p-8 md:p-10 shadow-2xl relative overflow-hidden group hover:border-t-amber-500/80 transition-colors duration-500">

            <div
                class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/5 to-transparent pointer-events-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 md:gap-6 text-left relative z-10 items-center">

                <div class="md:col-span-1 md:border-r border-slate-700 md:pr-6">
                    <h3 class="text-2xl md:text-3xl font-extrabold text-white leading-tight">
                        Mitra Digital<br>
                        <span class="text-amber-500">Terpercaya</span>
                    </h3>
                </div>

                <div class="md:pl-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center">
                            <i class="fa-solid fa-code text-amber-500 text-sm"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white">Kualitas Terbaik</h4>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">Sistem dibangun dengan standar industri untuk
                        performa optimal.</p>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center">
                            <i class="fa-solid fa-rocket text-amber-500 text-sm"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white">Pengerjaan Cepat</h4>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">Implementasi metode efisien agar proyek selesai
                        tepat waktu.</p>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center">
                            <i class="fa-solid fa-shield-halved text-amber-500 text-sm"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white">Keamanan Ekstra</h4>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">Proteksi data berlapis dan struktur kode yang aman
                        & rapi.</p>
                </div>
            </div>
        </div>

    </div>
</section>
