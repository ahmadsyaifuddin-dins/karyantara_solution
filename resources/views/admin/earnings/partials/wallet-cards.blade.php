<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    <div class="md:col-span-2 lg:col-span-2 rounded-3xl p-6 text-slate-950 relative overflow-hidden flex flex-col justify-between h-full"
        style="
            background: 
                radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.25) 0%, transparent 15%),
                radial-gradient(circle at 90% 80%, rgba(255, 255, 255, 0.2) 0%, transparent 20%),
                linear-gradient(135deg, #f5e3a8 0%, #d4af37 35%, #b28a1c 50%, #f1c40f 65%, #f9e1a8 100%);
            box-shadow: 
                0 10px 15px -3px rgba(178, 138, 28, 0.3),
                0 4px 6px -4px rgba(178, 138, 28, 0.2), 
                inset 0 1px 2px rgba(255, 255, 255, 0.5);
            border: 1px solid #c9a031;
        ">
        <i
            class="fa-solid fa-coins absolute -right-6 -bottom-10 text-[10rem] text-black/5 opacity-80 z-0 pointer-events-none"></i>

        <div class="relative z-10">
            <p class="text-xs font-bold text-slate-800/80 uppercase tracking-widest mb-1">Total Pendapatan (Semua Klien &
                Jasa)</p>
            <h2 class="text-3xl lg:text-5xl font-black tracking-tight text-slate-950">Rp
                {{ number_format($totalEarnings, 0, ',', '.') }}</h2>

            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span
                    class="inline-flex items-center gap-1.5 bg-black/50 px-2.5 py-1 rounded-full text-[11px] text-amber-200 font-medium backdrop-blur-sm shadow-sm">
                    <i class="fa-solid fa-briefcase text-amber-300"></i> {{ $totalProjects }} Proyek Total
                </span>

                @if ($totalPaidEarnings > 0)
                    <span
                        class="inline-flex items-center gap-1.5 bg-emerald-100 border border-emerald-300 px-2.5 py-1 rounded-full text-[11px] font-bold text-emerald-900 shadow-sm">
                        <i class="fa-solid fa-money-bill-wave text-emerald-600"></i> Sudah Cair: Rp
                        {{ number_format($totalPaidEarnings, 0, ',', '.') }}
                    </span>
                @endif

                @if ($totalUnpaidEarnings > 0)
                    <span
                        class="inline-flex items-center gap-1.5 bg-red-100 border border-red-300 px-2.5 py-1 rounded-full text-[11px] font-bold text-red-950 shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation text-red-600 animate-pulse"></i> Belum Cair: Rp
                        {{ number_format($totalUnpaidEarnings, 0, ',', '.') }}
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 bg-emerald-100 border border-emerald-300 px-2.5 py-1 rounded-full text-[11px] font-bold text-emerald-900 shadow-sm">
                        <i class="fa-solid fa-check-double text-emerald-600"></i> Semua Cair
                    </span>
                @endif
            </div>
        </div>

        <div class="flex gap-3 mt-6 relative z-10">
            <div
                class="bg-black/10 border border-black/10 rounded-xl p-3 flex-1 text-center backdrop-blur-sm shadow-inner">
                <p class="text-[9px] text-slate-800/80 uppercase font-bold tracking-wider mb-1">Total Aplikasi</p>
                <p class="font-bold text-sm text-slate-950">Rp
                    {{ number_format($totalAppEarnings + $pendapatanDevUmum, 0, ',', '.') }}</p>
            </div>
            <div
                class="bg-black/10 border border-black/10 rounded-xl p-3 flex-1 text-center backdrop-blur-sm shadow-inner">
                <p class="text-[9px] text-slate-800/80 uppercase font-bold tracking-wider mb-1">Total Naskah</p>
                <p class="font-bold text-sm text-slate-950">Rp {{ number_format($totalWriterEarnings, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <div
        class="md:col-span-2 lg:col-span-1 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-6 shadow-xl text-white relative overflow-hidden flex flex-col justify-between h-full border border-emerald-500/30">
        <i class="fa-solid fa-check-to-slot absolute -right-6 -bottom-6 text-8xl text-white/10 z-0"></i>

        <div class="relative z-10">
            <p class="text-xs font-bold text-emerald-100 uppercase tracking-widest mb-1 flex items-center gap-2">
                Estimasi Cair <span
                    class="bg-white/20 text-[9px] px-1.5 py-0.5 rounded text-white font-bold border border-white/20">PROYEK
                    SELESAI</span>
            </p>
            <h2 class="text-3xl lg:text-4xl font-black tracking-tight text-white mt-1">Rp
                {{ number_format($totalCompletedEarnings, 0, ',', '.') }}</h2>

            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span
                    class="inline-flex items-center gap-1.5 bg-white/10 px-2.5 py-1 rounded-full text-[11px] font-medium border border-white/20 backdrop-blur-sm">
                    <i class="fa-solid fa-clipboard-check text-emerald-200"></i> {{ $totalCompletedProjects }} Proyek
                    Selesai
                </span>
            </div>
        </div>

        <div class="flex gap-3 mt-6 relative z-10">
            <div
                class="bg-black/10 border border-white/10 rounded-xl p-3 flex-1 text-center backdrop-blur-sm relative shadow-inner">
                <p class="text-[9px] text-emerald-100 uppercase font-bold tracking-wider mb-1">Dari Aplikasi</p>
                <p class="font-bold text-sm text-white">Rp
                    {{ number_format($completedAppEarnings + $completedUmumEarnings, 0, ',', '.') }}</p>
            </div>
            <div
                class="bg-black/10 border border-white/10 rounded-xl p-3 flex-1 text-center backdrop-blur-sm relative shadow-inner">
                <p class="text-[9px] text-emerald-100 uppercase font-bold tracking-wider mb-1">Dari Naskah</p>
                <p class="font-bold text-sm text-white">Rp {{ number_format($completedWriterEarnings, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <div
        class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between h-full group hover:shadow-md transition-all duration-300">
        <div
            class="absolute -right-10 -top-10 w-48 h-48 bg-blue-50 rounded-full blur-3xl group-hover:bg-blue-100 transition duration-500 pointer-events-none">
        </div>
        <i
            class="fa-solid fa-graduation-cap absolute -right-4 -bottom-4 text-8xl text-blue-50 opacity-80 z-0 transform group-hover:-translate-y-2 group-hover:scale-110 transition duration-500"></i>

        <div class="relative z-10">
            <p
                class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 flex flex-col sm:flex-row sm:items-center gap-2">
                Dev Aplikasi
                <span
                    class="inline-block w-fit bg-blue-100 border border-blue-200 text-[9px] px-2 py-0.5 rounded text-blue-700 font-bold tracking-wider">
                    MAHASISWA
                </span>
            </p>
            <h2 class="text-3xl font-black tracking-tight text-[#1E293B]">Rp
                {{ number_format($pendapatanDevMahasiswa, 0, ',', '.') }}</h2>

            <div class="mt-3">
                <p class="text-xs text-slate-500 font-medium leading-tight">
                    <i class="fa-solid fa-user-graduate text-blue-500 mr-1.5"></i> Omset dari order aplikasi skripsi
                </p>
            </div>
        </div>
    </div>

    <div
        class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between h-full group hover:shadow-md transition-all duration-300">
        <div
            class="absolute -right-10 -top-10 w-48 h-48 bg-indigo-50 rounded-full blur-3xl group-hover:bg-indigo-100 transition duration-500 pointer-events-none">
        </div>
        <i
            class="fa-solid fa-pen-nib absolute -right-4 -bottom-4 text-8xl text-indigo-50 opacity-80 z-0 transform group-hover:-translate-y-2 group-hover:scale-110 transition duration-500"></i>

        <div class="relative z-10">
            <p
                class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 flex flex-col sm:flex-row sm:items-center gap-2">
                Penulisan Naskah
                <span
                    class="inline-block w-fit bg-indigo-100 border border-indigo-200 text-[9px] px-2 py-0.5 rounded text-indigo-700 font-bold tracking-wider">
                    SKRIPSI / PAPER
                </span>
            </p>
            <h2 class="text-3xl font-black tracking-tight text-[#1E293B]">Rp
                {{ number_format($totalWriterEarnings, 0, ',', '.') }}</h2>

            <div class="mt-3">
                <p class="text-xs text-slate-500 font-medium leading-tight">
                    <i class="fa-solid fa-book-open text-indigo-500 mr-1.5"></i> Omset dari jasa kepenulisan
                </p>
            </div>
        </div>
    </div>

    <div
        class="bg-[#1E293B] border border-slate-700 rounded-3xl p-6 shadow-xl text-white relative overflow-hidden flex flex-col justify-between h-full group transition-all duration-300 hover:shadow-2xl hover:border-slate-600">
        <div
            class="absolute -right-10 -top-10 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl group-hover:bg-amber-500/20 transition duration-500 pointer-events-none">
        </div>
        <i
            class="fa-solid fa-building absolute -right-4 -bottom-4 text-8xl text-white/5 opacity-80 z-0 transform group-hover:-translate-y-2 group-hover:scale-110 transition duration-500"></i>

        <div class="relative z-10">
            <p
                class="text-[10px] font-bold text-slate-300 uppercase tracking-widest mb-2 flex flex-col sm:flex-row sm:items-center gap-2">
                Dev Aplikasi
                <span
                    class="inline-block w-fit bg-amber-500/20 border border-amber-500/30 text-[9px] px-2 py-0.5 rounded text-amber-400 font-bold tracking-wider">
                    PERUSAHAAN
                </span>
            </p>
            <h2 class="text-3xl font-black tracking-tight text-white">Rp
                {{ number_format($pendapatanDevUmum, 0, ',', '.') }}</h2>

            <div class="mt-3">
                <p class="text-xs text-slate-400 font-medium leading-tight">
                    <i class="fa-solid fa-handshake text-amber-500 mr-1.5"></i> Omset dari klien korporat (Custom)
                </p>
            </div>
        </div>
    </div>

</div>
