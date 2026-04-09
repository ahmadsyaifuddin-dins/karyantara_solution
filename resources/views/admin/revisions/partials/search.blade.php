<div
    class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/80 backdrop-blur-sm p-4 rounded-2xl shadow-sm border border-gray-200">
    <div class="flex items-center gap-3 w-full sm:w-auto">
        <div class="bg-amber-100 p-2.5 rounded-xl text-amber-600 shadow-inner">
            <i class="fa-solid fa-filter"></i>
        </div>
        <div>
            <h3 class="font-bold text-[#1E293B] text-sm">Filter Tiket Revisi</h3>
            <p class="text-[11px] text-gray-500 font-medium">Cari berdasarkan Nama Klien, Judul, atau #ID</p>
        </div>
    </div>

    <div class="w-full sm:w-[400px]">
        <x-forms.input-search alpineModel="searchQuery" placeholder="Ketik kata kunci di sini..."
            class="bg-white border-gray-200" />
    </div>
</div>
