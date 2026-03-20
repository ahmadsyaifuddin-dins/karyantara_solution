<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div
        class="bg-gradient-to-br from-[#1E293B] to-slate-800 rounded-3xl p-6 shadow-xl text-white relative overflow-hidden flex flex-col justify-between h-full">
        <i class="fa-solid fa-coins absolute -right-6 -bottom-6 text-8xl text-white/5"></i>
        <div>
            <p class="text-xs font-bold text-slate-300 uppercase tracking-widest mb-1">Total Pendapatan (Semua Status)
            </p>
            <h2 class="text-3xl lg:text-4xl font-black tracking-tight">Rp
                {{ number_format($totalEarnings, 0, ',', '.') }}</h2>

            <div class="mt-3 flex flex-wrap items-center gap-2">
                <span
                    class="inline-flex items-center gap-1.5 bg-white/10 px-2.5 py-1 rounded-full text-[11px] font-medium border border-white/10 backdrop-blur-sm">
                    <i class="fa-solid fa-briefcase text-amber-400"></i> {{ $totalProjects }} Proyek Total
                </span>
                @if ($totalUnpaidEarnings > 0)
                    <span
                        class="inline-flex items-center gap-1.5 bg-red-500/20 px-2.5 py-1 rounded-full text-[11px] font-bold text-red-200 border border-red-500/30 backdrop-blur-sm shadow-sm"
                        title="Total fee yang belum ditransfer ke Anda">
                        <i class="fa-solid fa-triangle-exclamation text-red-400"></i> Belum Cair: Rp
                        {{ number_format($totalUnpaidEarnings, 0, ',', '.') }}
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 bg-emerald-500/20 px-2.5 py-1 rounded-full text-[11px] font-bold text-emerald-200 border border-emerald-500/30 backdrop-blur-sm shadow-sm">
                        <i class="fa-solid fa-check-double text-emerald-400"></i> Semua Cair
                    </span>
                @endif
            </div>
        </div>

        <div class="flex gap-3 mt-6 relative z-10">
            <div class="bg-white/10 border border-white/10 rounded-xl p-3 flex-1 text-center backdrop-blur-sm">
                <p class="text-[9px] text-slate-300 uppercase font-bold tracking-wider mb-1">Dari Aplikasi</p>
                <p class="font-bold text-sm text-white">Rp {{ number_format($totalAppEarnings, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white/10 border border-white/10 rounded-xl p-3 flex-1 text-center backdrop-blur-sm">
                <p class="text-[9px] text-slate-300 uppercase font-bold tracking-wider mb-1">Dari Naskah</p>
                <p class="font-bold text-sm text-white">Rp {{ number_format($totalWriterEarnings, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div
        class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-6 shadow-xl text-white relative overflow-hidden flex flex-col justify-between h-full">
        <i class="fa-solid fa-check-to-slot absolute -right-6 -bottom-6 text-8xl text-white/10"></i>
        <div>
            <p class="text-xs font-bold text-emerald-100 uppercase tracking-widest mb-1 flex items-center gap-2">
                Estimasi Saldo Cair <span
                    class="bg-white/20 text-[9px] px-1.5 py-0.5 rounded text-white font-bold">PROYEK SELESAI</span>
            </p>
            <h2 class="text-3xl lg:text-4xl font-black tracking-tight">Rp
                {{ number_format($totalCompletedEarnings, 0, ',', '.') }}</h2>

            <div class="mt-3 flex flex-wrap items-center gap-2">
                <span
                    class="inline-flex items-center gap-1.5 bg-white/20 px-2.5 py-1 rounded-full text-[11px] font-medium border border-white/20 backdrop-blur-sm">
                    <i class="fa-solid fa-clipboard-check text-emerald-200"></i> {{ $totalCompletedProjects }} Proyek
                    Beres
                </span>
            </div>
        </div>

        <div class="flex gap-3 mt-6 relative z-10">
            <div class="bg-black/10 border border-black/10 rounded-xl p-3 flex-1 text-center backdrop-blur-sm relative">
                <p class="text-[9px] text-emerald-100 uppercase font-bold tracking-wider mb-1">Dari Aplikasi</p>
                <p class="font-bold text-sm text-white">Rp {{ number_format($completedAppEarnings, 0, ',', '.') }}</p>
            </div>
            <div class="bg-black/10 border border-black/10 rounded-xl p-3 flex-1 text-center backdrop-blur-sm relative">
                <p class="text-[9px] text-emerald-100 uppercase font-bold tracking-wider mb-1">Dari Naskah</p>
                <p class="font-bold text-sm text-white">Rp {{ number_format($completedWriterEarnings, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
</div>
