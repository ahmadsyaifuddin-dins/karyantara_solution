<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div
        class="relative overflow-hidden bg-gradient-to-br from-[#1E293B] to-slate-800 rounded-2xl p-6 shadow-md border border-slate-700 group hover:-translate-y-1 transition-all duration-300">
        <div
            class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/5 group-hover:bg-white/10 transition-colors duration-500">
        </div>
        <div
            class="absolute -right-4 -bottom-4 w-16 h-16 rounded-full bg-amber-500/10 group-hover:bg-amber-500/20 transition-colors duration-500 blur-xl">
        </div>

        <div class="flex items-center justify-between mb-6 relative z-10">
            <div
                class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center border border-white/10 backdrop-blur-sm shadow-inner">
                <i class="fa-solid fa-wallet text-xl text-amber-400"></i>
            </div>
            <span
                class="text-[10px] font-extrabold text-slate-300 bg-slate-700/50 px-2.5 py-1 rounded-full border border-slate-600 uppercase tracking-wider">Total</span>
        </div>

        <div class="relative z-10">
            <p class="text-sm font-medium text-slate-300 mb-1">Total Fee Pribadi</p>
            <h3 class="text-3xl font-extrabold text-white tracking-tight drop-shadow-sm">Rp
                {{ number_format($totalNetIncome, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div
        class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-100 group hover:-translate-y-1 hover:shadow-md hover:border-emerald-200 transition-all duration-300">
        <div
            class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-emerald-50 group-hover:bg-emerald-100 transition-colors duration-500">
        </div>

        <div class="flex items-center justify-between mb-6 relative z-10">
            <div
                class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center border border-emerald-100 group-hover:bg-emerald-100 transition-colors">
                <i class="fa-solid fa-money-bill-wave text-xl text-emerald-600"></i>
            </div>
            <span
                class="text-[10px] font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100 uppercase tracking-wider">Cair</span>
        </div>

        <div class="relative z-10">
            <p class="text-sm font-medium text-gray-500 mb-1">Fee Di Tangan (Cash)</p>
            <h3 class="text-3xl font-extrabold text-[#1E293B] tracking-tight">Rp
                {{ number_format($totalPaid, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div
        class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-gray-100 group hover:-translate-y-1 hover:shadow-md hover:border-amber-200 transition-all duration-300">
        <div
            class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-amber-50 group-hover:bg-amber-100 transition-colors duration-500">
        </div>

        <div class="flex items-center justify-between mb-6 relative z-10">
            <div
                class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center border border-amber-100 group-hover:bg-amber-100 transition-colors">
                <i class="fa-solid fa-clock-rotate-left text-xl text-amber-500"></i>
            </div>
            <span
                class="text-[10px] font-extrabold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-100 uppercase tracking-wider">Pending</span>
        </div>

        <div class="relative z-10">
            <p class="text-sm font-medium text-gray-500 mb-1">Piutang (Belum Cair)</p>
            <h3 class="text-3xl font-extrabold text-[#1E293B] tracking-tight">Rp
                {{ number_format($totalPiutang, 0, ',', '.') }}</h3>
        </div>
    </div>

</div>
