<div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-500 rounded-full opacity-20 blur-2xl pointer-events-none"></div>

<h3 class="text-amber-500 font-bold text-lg mb-1 relative z-10">Estimasi Penawaran</h3>
<p class="text-gray-400 text-xs mb-6 relative z-10">Gunakan rentang harga ini untuk negosiasi.</p>

<div class="flex-grow space-y-4 relative z-10">
    <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700">
        <p class="text-gray-400 text-xs font-semibold mb-1 uppercase tracking-wider">Harga Terendah</p>
        <p class="text-2xl font-bold text-white" x-text="formatRupiah(hasilHitung.min)"></p>
    </div>

    <div class="flex items-center justify-center">
        <span class="bg-amber-500 text-[#1E293B] text-xs font-bold px-3 py-1 rounded-full">SAMPAI DENGAN</span>
    </div>

    <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700">
        <p class="text-gray-400 text-xs font-semibold mb-1 uppercase tracking-wider">Harga Tertinggi</p>
        <p class="text-3xl font-bold text-amber-500" x-text="formatRupiah(hasilHitung.max)"></p>
    </div>
</div>

<div class="mt-8 pt-6 border-t border-slate-700 relative z-10 flex flex-col gap-3">
    <button @click="copyToClipboard()"
        class="w-full bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 px-4 rounded-xl transition-colors flex items-center justify-center gap-2">
        <i class="fa-regular fa-copy"></i>
        <span x-text="copyText"></span>
    </button>

    <button @click="cetakPDF()"
        class="w-full bg-amber-500 hover:bg-amber-600 text-[#1E293B] font-bold py-3 px-4 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-[0_0_15px_rgba(245,158,11,0.4)]">
        <i class="fa-solid fa-file-pdf"></i>
        <span>Cetak PDF Penawaran</span>
    </button>
</div>
