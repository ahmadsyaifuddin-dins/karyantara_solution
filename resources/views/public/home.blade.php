<x-public-layout title="Beranda - Karyantara Solution">

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

            <h1
                class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-[#1E293B] tracking-tight mb-8 leading-[1.1]">
                Wujudkan Ide Digital Anda <br class="hidden md:block">
                Bersama <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-amber-600">Karyantara</span>
            </h1>

            <p class="mt-4 text-xl md:text-2xl text-gray-500 max-w-3xl mx-auto mb-12 leading-relaxed">
                Kami adalah <span class="font-semibold text-[#1E293B]">software house</span> penyedia jasa pembuatan
                Website dan Aplikasi Mobile profesional, cepat, dan terpercaya.
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

    <section class="py-24 bg-gray-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-sm font-bold text-amber-500 tracking-wider uppercase mb-2">Layanan Kami</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-[#1E293B]">Solusi Untuk Setiap Kebutuhan</h3>
                <div class="w-24 h-1.5 bg-gradient-to-r from-amber-400 to-amber-600 mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group">
                    <div
                        class="w-16 h-16 bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 rounded-xl flex items-center justify-center text-3xl mb-8 shadow-sm">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-[#1E293B] mb-4 group-hover:text-blue-600 transition-colors">Web
                        Development</h3>
                    <p class="text-gray-600 leading-relaxed">Pembuatan website company profile, e-commerce, hingga
                        sistem informasi kustom berbasis web dengan teknologi terbaru.</p>
                </div>

                <div
                    class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group">
                    <div
                        class="w-16 h-16 bg-green-50 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300 rounded-xl flex items-center justify-center text-3xl mb-8 shadow-sm">
                        <i class="fa-brands fa-android"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-[#1E293B] mb-4 group-hover:text-green-600 transition-colors">
                        Mobile Apps</h3>
                    <p class="text-gray-600 leading-relaxed">Pengembangan aplikasi mobile berbasis Android yang
                        responsif, ringan, berkinerja tinggi, dan user-friendly.</p>
                </div>

                <div
                    class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group">
                    <div
                        class="w-16 h-16 bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300 rounded-xl flex items-center justify-center text-3xl mb-8 shadow-sm">
                        <i class="fa-solid fa-pen-nib"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-[#1E293B] mb-4 group-hover:text-purple-600 transition-colors">
                        UI/UX Design</h3>
                    <p class="text-gray-600 leading-relaxed">Desain antarmuka yang tidak hanya memanjakan mata, tapi
                        juga memberikan pengalaman pengguna (user experience) terbaik.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-[#1E293B] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-sm font-bold text-amber-500 tracking-wider uppercase mb-2">Kenapa Karyantara?</h2>
                    <h3 class="text-3xl md:text-4xl font-extrabold mb-6 leading-tight">Mitra Strategis Untuk Pertumbuhan
                        Bisnis Anda</h3>
                    <p class="text-gray-400 mb-8 text-lg leading-relaxed">Kami tidak sekadar menulis kode, kami
                        membangun solusi. Setiap baris program yang kami buat didedikasikan untuk memecahkan masalah
                        bisnis Anda.</p>

                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center text-amber-500 text-xl">
                                <i class="fa-solid fa-rocket"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">Pengerjaan Cepat & Tepat</h4>
                                <p class="text-gray-400 text-sm">Metodologi kerja yang efisien memastikan proyek selesai
                                    sesuai tenggat waktu tanpa mengorbankan kualitas.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center text-amber-500 text-xl">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">Dukungan Penuh</h4>
                                <p class="text-gray-400 text-sm">Kami memberikan layanan maintenance dan dukungan teknis
                                    yang responsif setelah proyek selesai.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div
                        class="aspect-square bg-gradient-to-tr from-gray-800 to-gray-700 rounded-3xl p-8 relative overflow-hidden shadow-2xl border border-gray-700">
                        <div
                            class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10">
                        </div>
                        <div class="relative h-full flex flex-col items-center justify-center text-center">
                            <i class="fa-solid fa-code text-7xl text-amber-500 mb-6 drop-shadow-lg"></i>
                            <h4 class="text-2xl font-bold mb-2">Kualitas Kode Premium</h4>
                            <p class="text-gray-400">Arsitektur aplikasi yang bersih, aman, dan mudah dikembangkan untuk
                                jangka panjang.</p>
                        </div>
                    </div>
                    <div
                        class="absolute -bottom-6 -left-6 w-24 h-24 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNGQkJGMjQiLz48L3N2Zz4=')] opacity-50 z-[-1]">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-gradient-to-br from-amber-400 to-amber-600 rounded-3xl p-10 md:p-16 text-center shadow-2xl relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-5xl font-extrabold text-[#1E293B] mb-6">Siap Memulai Proyek Anda?</h2>
                    <p class="text-[#1E293B] font-medium text-lg mb-10 max-w-2xl mx-auto opacity-90">Mari diskusikan ide
                        Anda bersama tim ahli kami. Konsultasi gratis, tanpa biaya tersembunyi.</p>
                    <a href="{{ route('contact') }}"
                        class="inline-block bg-[#1E293B] text-white px-10 py-4 rounded-xl font-bold text-lg hover:bg-gray-900 transition-colors shadow-lg hover:shadow-xl hover:-translate-y-1 transform">
                        Hubungi Kami Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-public-layout>
