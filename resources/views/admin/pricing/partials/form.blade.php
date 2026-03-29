<h3 class="text-lg font-bold text-[#1E293B] border-b pb-3 mb-5">Parameter Proyek</h3>

<div class="space-y-6">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Calon Klien (Opsional)</label>
        <input type="text" x-model="clientName" placeholder="Masukkan nama klien..."
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm">
        <p class="text-xs text-gray-400 mt-1">Digunakan untuk nama pada dokumen PDF penawaran.</p>
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-3">Jenis Layanan / Paket</label>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <template x-for="item in paketList" :key="item.id">
                <label
                    :class="paket === item.id ? 'border-amber-500 bg-amber-50' : 'border-gray-200 hover:border-amber-300'"
                    class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none transition-all">
                    <input type="radio" name="paket" x-model="paket" :value="item.id" class="sr-only">
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="block text-sm font-bold text-[#1E293B]" x-text="item.nama"></span>
                            <span class="mt-1 flex items-center text-xs text-gray-500" x-text="item.desc"></span>
                        </span>
                    </span>
                    <i x-show="paket === item.id" class="fa-solid fa-circle-check text-amber-500 text-xl"></i>
                </label>
            </template>
        </div>
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-3">Sumber Kode Aplikasi</label>
        <div class="flex gap-4">
            <label class="flex items-center cursor-pointer">
                <input type="radio" x-model="sumberApp" value="internal"
                    class="w-5 h-5 text-amber-500 border-gray-300 focus:ring-amber-500">
                <span class="ml-2 text-sm text-gray-700 font-medium">Buatan Karyantara</span>
            </label>
            <label class="flex items-center cursor-pointer">
                <input type="radio" x-model="sumberApp" value="eksternal"
                    class="w-5 h-5 text-amber-500 border-gray-300 focus:ring-amber-500">
                <span class="ml-2 text-sm text-gray-700 font-medium">Buatan Luar (Bawa Sendiri)</span>
            </label>
        </div>
        <p x-show="sumberApp === 'eksternal'" x-transition class="text-xs text-amber-600 mt-2 font-medium">
            <i class="fa-solid fa-triangle-exclamation"></i> Terdapat biaya tambahan untuk effort memahami alur/kode
            legacy.
        </p>
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-3">Tingkat Kesulitan / Volume Pekerjaan</label>
        <select x-model="kesulitan"
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm">
            <option value="standar">Standar / Ringan</option>
            <option value="menengah">Menengah (Banyak Revisi / Cukup Rumit)</option>
            <option value="sulit">Sulit / Perombakan Besar</option>
        </select>
    </div>
</div>
