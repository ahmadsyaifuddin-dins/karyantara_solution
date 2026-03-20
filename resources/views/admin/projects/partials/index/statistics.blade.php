<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div
        class="relative overflow-hidden bg-gradient-to-br from-amber-300 via-amber-400 to-amber-600 rounded-xl p-6 border border-amber-300 shadow-lg shadow-amber-500/40 flex items-center justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-500/50">

        <div
            class="absolute top-0 right-0 w-32 h-32 bg-white/40 rounded-full blur-3xl -mr-10 -mt-10 transition-transform duration-700 group-hover:scale-150">
        </div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/20 rounded-full blur-2xl -ml-8 -mb-8"></div>
        <div
            class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
        </div>

        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-1">
                <p class="text-sm font-bold text-amber-900 uppercase tracking-wider drop-shadow-sm">Total Pendapatan
                    Bersih</p>
                <span
                    class="px-2 py-0.5 text-[10px] font-black bg-[#1E293B] text-amber-400 border border-[#1E293B] rounded-md shadow-sm">
                    {{ $totalProjects }} Proyek
                </span>
            </div>
            <h4 class="text-2xl font-black text-[#1E293B] mt-1 drop-shadow-sm">Rp
                {{ number_format($totalNetIncome, 0, ',', '.') }}</h4>
        </div>

        <div
            class="relative z-10 w-12 h-12 bg-white/40 backdrop-blur-sm border border-white/50 text-[#1E293B] rounded-full flex items-center justify-center text-xl shadow-inner group-hover:rotate-12 transition-transform duration-300">
            <i class="fa-solid fa-wallet"></i>
        </div>
    </div>

    <div
        class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow duration-300 hover:-translate-y-1">
        <div>
            <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Sudah Terbayar</p>
            <h4 class="text-2xl font-black text-emerald-600 mt-1">Rp
                {{ number_format($totalPaid, 0, ',', '.') }}</h4>
        </div>
        <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center text-xl">
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>
    </div>

    <div
        class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow duration-300 hover:-translate-y-1">
        <div>
            <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Sisa Pembayaran</p>
            <h4 class="text-2xl font-black text-red-500 mt-1">Rp
                {{ number_format($totalRemaining, 0, ',', '.') }}</h4>
        </div>
        <div class="w-12 h-12 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-xl">
            <i class="fa-solid fa-file-invoice"></i>
        </div>
    </div>

</div>
