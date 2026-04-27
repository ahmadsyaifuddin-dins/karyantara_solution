{{-- BAGIAN 1: DOMPET PENDAPATAN (Hanya super_admin) --}}
@role('super_admin')
    <div>
        <h3 class="text-lg font-extrabold text-[#1E293B] mb-4 flex items-center">
            <i class="fa-solid fa-wallet text-emerald-500 mr-2"></i> Dompet Pendapatan Saya
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div
                class="bg-gradient-to-br from-[#1E293B] to-slate-800 rounded-2xl p-6 shadow-md text-white relative overflow-hidden group hover:shadow-lg transition-all border border-amber-500/30">
                <i
                    class="fa-solid fa-sack-dollar absolute -right-4 -bottom-4 text-7xl text-amber-500/10 group-hover:scale-110 transition-transform"></i>
                <p class="text-xs font-bold text-amber-500 uppercase tracking-wider mb-1">Total Pendapatan Saya</p>
                <h3 class="text-2xl font-black mt-1">Rp {{ number_format($myTotalEarnings ?? 0, 0, ',', '.') }}</h3>
                <div class="mt-4 flex items-center gap-2 text-xs font-medium text-slate-300">
                    <span class="bg-white/10 px-2 py-1 rounded">Total Menangani <b>{{ $myTotalProjects ?? 0 }}</b>
                        Proyek</span>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-6 border border-blue-100 shadow-sm hover:border-blue-300 transition-colors relative overflow-hidden group">
                <div
                    class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50/50 rounded-full blur-xl group-hover:bg-blue-100/50 transition duration-500 pointer-events-none">
                </div>
                <div class="flex items-center justify-between mb-3 relative z-10">
                    <p class="text-[10px] font-extrabold text-blue-600 uppercase tracking-wider leading-tight">Dev
                        Aplikasi<br><span class="text-gray-400">MAHASISWA</span></p>
                    <i class="fa-solid fa-graduation-cap text-blue-200 text-2xl"></i>
                </div>
                <h3 class="text-xl font-black text-[#1E293B] relative z-10">Rp
                    {{ number_format($myAppEarnings ?? 0, 0, ',', '.') }}</h3>
                <p class="text-[10px] font-bold text-gray-500 mt-3 flex items-center gap-1 relative z-10">
                    <i class="fa-solid fa-laptop-code text-blue-400"></i> {{ $myAppProjectsCount ?? 0 }} Aplikasi Skripsi
                </p>
            </div>

            <div
                class="bg-white rounded-2xl p-6 border border-indigo-100 shadow-sm hover:border-indigo-300 transition-colors relative overflow-hidden group">
                <div
                    class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50/50 rounded-full blur-xl group-hover:bg-indigo-100/50 transition duration-500 pointer-events-none">
                </div>
                <div class="flex items-center justify-between mb-3 relative z-10">
                    <p class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-wider leading-tight">Penulis
                        Naskah<br><span class="text-gray-400">SKRIPSI / PAPER</span></p>
                    <i class="fa-solid fa-pen-nib text-indigo-200 text-2xl"></i>
                </div>
                <h3 class="text-xl font-black text-[#1E293B] relative z-10">Rp
                    {{ number_format($myWriterEarnings ?? 0, 0, ',', '.') }}</h3>
                <p class="text-[10px] font-bold text-gray-500 mt-3 flex items-center gap-1 relative z-10">
                    <i class="fa-solid fa-book-open text-indigo-400"></i> {{ $myWriterProjectsCount ?? 0 }} Naskah
                </p>
            </div>

            <div
                class="bg-white rounded-2xl p-6 border border-amber-200 shadow-sm hover:border-amber-400 transition-colors relative overflow-hidden group">
                <div
                    class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50/50 rounded-full blur-xl group-hover:bg-amber-100/50 transition duration-500 pointer-events-none">
                </div>
                <div class="flex items-center justify-between mb-3 relative z-10">
                    <p class="text-[10px] font-extrabold text-amber-600 uppercase tracking-wider leading-tight">Dev
                        Aplikasi<br><span class="text-gray-400">CORPORATE</span></p>
                    <i class="fa-solid fa-building text-amber-200 text-2xl"></i>
                </div>
                <h3 class="text-xl font-black text-[#1E293B] relative z-10">Rp
                    {{ number_format($myUmumEarnings ?? 0, 0, ',', '.') }}</h3>
                <p class="text-[10px] font-bold text-gray-500 mt-3 flex items-center gap-1 relative z-10">
                    <i class="fa-solid fa-handshake text-amber-400"></i> {{ $myUmumProjectsCount ?? 0 }} Proyek Perusahaan
                </p>
            </div>

        </div>
    </div>
@endrole

{{-- BAGIAN 2: PERFORMA GLOBAL KARYANTARA --}}
<div class="pt-4 @role('super_admin') border-t border-gray-200 mt-8 @endrole">
    <h3 class="text-lg font-extrabold text-[#1E293B] mb-4 flex items-center">
        <i class="fa-solid fa-chart-pie text-blue-500 mr-2"></i> Performa Global Karyantara
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Card Global 1 & 2: Hanya super_admin --}}
        @role('super_admin')
            <div
                class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-start gap-4 hover:-translate-y-1 transition-transform">
                <div
                    class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500 text-xl shrink-0 mt-1">
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Omset Global</p>
                    <h3 class="text-xl font-black text-[#1E293B] mt-0.5">Rp
                        {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                    <div class="mt-2 flex flex-wrap gap-2 text-[9px] font-bold">
                        <span class="text-blue-600 bg-blue-50 border border-blue-100 px-1.5 py-0.5 rounded shadow-sm"
                            title="Omset Aplikasi">
                            <i class="fa-solid fa-code"></i> Rp {{ number_format($appRevenue ?? 0, 0, ',', '.') }}
                        </span>
                        <span class="text-amber-600 bg-amber-50 border border-amber-100 px-1.5 py-0.5 rounded shadow-sm"
                            title="Omset Naskah">
                            <i class="fa-solid fa-file-word"></i> Rp {{ number_format($writerRevenue ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4 hover:-translate-y-1 transition-transform">
                <div
                    class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 text-2xl shrink-0">
                    <i class="fa-solid fa-bars-progress"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Proyek Berjalan</p>
                    <h3 class="text-2xl font-black text-[#1E293B] mt-1">{{ $activeProjects ?? 0 }} <span
                            class="text-sm text-gray-400 font-medium">Proyek</span></h3>
                </div>
            </div>
        @endrole

        {{-- Card Global 3 & 4: Bisa dilihat Role Lain (Bebas) --}}
        <div
            class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4 hover:-translate-y-1 transition-transform">
            <div
                class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 text-2xl shrink-0">
                <i class="fa-solid fa-star-half-stroke"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Review Pending</p>
                <h3 class="text-2xl font-black text-[#1E293B] mt-1">{{ $pendingTestimonials ?? 0 }} <span
                        class="text-sm text-gray-400 font-medium">Ulasan</span></h3>
            </div>
        </div>

        <div
            class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4 hover:-translate-y-1 transition-transform">
            <div
                class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-500 text-2xl shrink-0">
                <i class="fa-solid fa-chart-simple"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Tayangan</p>
                <h3 class="text-2xl font-black text-[#1E293B] mt-1">
                    {{ number_format($totalVisitors ?? 0, 0, ',', '.') }} <span
                        class="text-sm text-gray-400 font-medium">Views</span>
                </h3>
            </div>
        </div>

    </div>
</div>
