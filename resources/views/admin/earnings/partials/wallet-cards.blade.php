<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div
        class="rounded-3xl p-6 text-slate-950 relative overflow-hidden flex flex-col justify-between h-full"
        style="
            background: 
                radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.25) 0%, transparent 15%), /* Efek Kilau Atas */
                radial-gradient(circle at 90% 80%, rgba(255, 255, 255, 0.2) 0%, transparent 20%), /* Efek Kilau Bawah */
                linear-gradient(135deg, #f5e3a8 0%, #d4af37 35%, #b28a1c 50%, #f1c40f 65%, #f9e1a8 100%); /* Gradasi Emas Kompleks */
            box-shadow: 
                0 10px 15px -3px rgba(178, 138, 28, 0.3), /* Shadow Luar Emas */
                0 4px 6px -4px rgba(178, 138, 28, 0.2), 
                inset 0 1px 2px rgba(255, 255, 255, 0.5); /* Shadow Dalam untuk Efek 3D */
            border: 1px solid #c9a031; /* Border Emas Halus */
        ">
        
        <i class="fa-solid fa-coins absolute -right-6 -bottom-6 text-8xl text-black/5 opacity-80"></i>
        
        <div>
            <p class="text-xs font-bold text-slate-800/80 uppercase tracking-widest mb-1">Total Pendapatan (Semua Status)</p>
            
            <h2 class="text-3xl lg:text-4xl font-black tracking-tight text-slate-950">Rp
                {{ number_format($totalEarnings, 0, ',', '.') }}</h2>

            <div class="mt-3 flex flex-wrap items-center gap-2 relative z-10">
                <span
                    class="inline-flex items-center gap-1.5 bg-black/50 px-2.5 py-1 rounded-full text-[11px] text-amber-200 font-medium backdrop-blur-sm shadow-sm">
                    <i class="fa-solid fa-briefcase text-amber-300"></i> {{ $totalProjects }} Proyek Total
                </span>
                
                @if ($totalPaidEarnings > 0)
                    <span
                        class="inline-flex items-center gap-1.5 bg-emerald-100 border border-emerald-300 px-2.5 py-1 rounded-full text-[11px] font-bold text-emerald-900 shadow-sm"
                        title="Total fee yang sudah berhasil dicairkan">
                        <i class="fa-solid fa-money-bill-wave text-emerald-600"></i> Sudah Cair: Rp
                        {{ number_format($totalPaidEarnings, 0, ',', '.') }}
                    </span>
                @endif

                @if ($totalUnpaidEarnings > 0)
                    <span
                        class="inline-flex items-center gap-1.5 bg-red-100 border border-red-300 px-2.5 py-1 rounded-full text-[11px] font-bold text-red-950 shadow-sm"
                        title="Total fee yang belum ditransfer ke Anda">
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
            <div class="bg-black/10 border border-black/10 rounded-xl p-3 flex-1 text-center backdrop-blur-sm shadow-inner">
                <p class="text-[9px] text-slate-800/80 uppercase font-bold tracking-wider mb-1">Dari Aplikasi</p>
                <p class="font-bold text-sm text-slate-950">Rp {{ number_format($totalAppEarnings, 0, ',', '.') }}</p>
            </div>
            <div class="bg-black/10 border border-black/10 rounded-xl p-3 flex-1 text-center backdrop-blur-sm shadow-inner">
                <p class="text-[9px] text-slate-800/80 uppercase font-bold tracking-wider mb-1">Dari Naskah</p>
                <p class="font-bold text-sm text-slate-950">Rp {{ number_format($totalWriterEarnings, 0, ',', '.') }}</p>
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
            <h2 class="text-3xl lg:text-4xl font-black tracking-tight text-white">Rp
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