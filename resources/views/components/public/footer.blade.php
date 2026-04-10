<footer class="bg-[#0F172A] text-white pt-16 pb-8 border-t border-slate-800/50 relative overflow-hidden">

    <div
        class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[800px] h-[200px] bg-amber-500/5 blur-[120px] rounded-full pointer-events-none">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-8">

            <div>
                <h3 class="text-3xl font-archive font-normal mb-4 tracking-wide text-white">
                    KARYANTARA SOLUTION<span class="text-amber-500">.</span>
                </h3>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                    Mitra terbaik Anda dalam mewujudkan solusi digital yang inovatif, modern, dan profesional. Kami
                    mengubah kode menjadi nilai bisnis.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-bold tracking-widest uppercase mb-6 text-white flex items-center gap-3">
                    Tautan Cepat
                    <span class="w-8 h-[2px] bg-amber-500/80 inline-block"></span>
                </h4>
                <ul class="space-y-3 text-sm text-slate-400 font-medium">
                    <li>
                        <a href="{{ route('portfolio') }}"
                            class="hover:text-amber-400 hover:translate-x-2 transition-all duration-300 inline-block">
                            Portofolio
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('testimonial') }}"
                            class="hover:text-amber-400 hover:translate-x-2 transition-all duration-300 inline-block">
                            Testimonial Klien
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}"
                            class="hover:text-amber-400 hover:translate-x-2 transition-all duration-300 inline-block">
                            Kontak Kami
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('terms') }}"
                            class="hover:text-amber-400 hover:translate-x-2 transition-all duration-300 inline-block">
                            Syarat & Ketentuan
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold tracking-widest uppercase mb-6 text-white flex items-center gap-3">
                    Hubungi Kami
                    <span class="w-8 h-[2px] bg-amber-500/80 inline-block"></span>
                </h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-[#1E293B] border border-slate-700 flex items-center justify-center text-amber-500 flex-shrink-0 shadow-[0_0_10px_rgba(245,158,11,0.1)]">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </div>
                        <span class="mt-1.5">karyantarasolution@gmail.com</span>
                    </li>
                    <li class="flex items-start gap-3 group">
                        <div
                            class="w-8 h-8 rounded-full bg-[#1E293B] border border-slate-700 flex items-center justify-center text-amber-500 flex-shrink-0 shadow-[0_0_10px_rgba(245,158,11,0.1)] group-hover:bg-amber-500 group-hover:text-[#1E293B] transition-colors">
                            <i class="fa-brands fa-instagram text-xs"></i>
                        </div>
                        <a href="https://instagram.com/karyantarasolution" target="_blank"
                            class="mt-1.5 group-hover:text-amber-400 transition-colors">
                            @karyantarasolution
                        </a>
                    </li>
                    <li class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-[#1E293B] border border-slate-700 flex items-center justify-center text-amber-500 flex-shrink-0 shadow-[0_0_10px_rgba(245,158,11,0.1)]">
                            <i class="fa-solid fa-phone text-xs"></i>
                        </div>
                        <span class="mt-1.5">+62 851-2423-7625</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-[#1E293B] border border-slate-700 flex items-center justify-center text-amber-500 flex-shrink-0 shadow-[0_0_10px_rgba(245,158,11,0.1)]">
                            <i class="fa-solid fa-location-dot text-xs"></i>
                        </div>
                        <span class="mt-1.5">Banjarmasin, Indonesia</span>
                    </li>
                </ul>
            </div>

        </div>

        <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500 text-center sm:text-left">
                &copy; 2026-{{ date('Y') }} <span class="text-slate-300 font-semibold">Karyantara Solution</span>.
                All rights reserved.
            </p>

            <div class="flex items-center gap-4 text-slate-500">
                <a href="#" class="hover:text-amber-400 transition-colors"><i
                        class="fa-brands fa-github text-lg"></i></a>
                <a href="#" class="hover:text-amber-400 transition-colors"><i
                        class="fa-brands fa-linkedin text-lg"></i></a>
            </div>
        </div>

    </div>
</footer>
