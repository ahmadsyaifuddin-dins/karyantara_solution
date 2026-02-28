<div
    class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-t-lg shadow-sm border-b border-gray-200">
    <div class="flex items-center gap-2 mb-4 sm:mb-0">
        <span class="text-sm font-semibold text-gray-500 mr-2 border-r pr-4 border-gray-300">
            <span x-text="selectedIds.length"></span> Terpilih
        </span>

        <button @click="submitBulk('approve')" :disabled="selectedIds.length === 0"
            class="px-3 py-1.5 text-xs font-bold rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed bg-green-100 text-green-700 hover:bg-green-200">
            <i class="fa-solid fa-check mr-1"></i> ACC Terpilih
        </button>
        <button @click="submitBulk('hide')" :disabled="selectedIds.length === 0"
            class="px-3 py-1.5 text-xs font-bold rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed bg-amber-100 text-amber-700 hover:bg-amber-200">
            <i class="fa-solid fa-eye-slash mr-1"></i> Sembunyikan Terpilih
        </button>
        <button @click="submitBulk('delete')" :disabled="selectedIds.length === 0"
            class="px-3 py-1.5 text-xs font-bold rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed bg-red-100 text-red-700 hover:bg-red-200">
            <i class="fa-solid fa-trash mr-1"></i> Hapus Terpilih
        </button>
    </div>

    <div class="flex items-center gap-2">
        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider mr-2">Global:</span>
        <button @click="submitAll('approve')"
            class="px-3 py-1.5 text-xs font-bold bg-[#1E293B] text-white rounded-md hover:bg-gray-800 transition shadow-sm">
            <i class="fa-solid fa-check-double mr-1"></i> ACC Semua
        </button>
        <button @click="submitAll('hide')"
            class="px-3 py-1.5 text-xs font-bold bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition shadow-sm">
            <i class="fa-solid fa-eye-slash mr-1"></i> Sembunyikan Semua
        </button>
    </div>
</div>
