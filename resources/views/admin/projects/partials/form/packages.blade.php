<div class="col-span-1 md:col-span-2 mt-2">
    <x-forms.label value="Pilih Paket Pengerjaan" class="text-amber-700" />

    <p class="text-xs font-bold text-amber-600 mt-2 mb-1 border-b border-amber-100 pb-1">Kategori: Skripsi (Awal - Akhir)
    </p>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
        <label
            class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none transition-all duration-200"
            :class="package === 'aplikasi' ? 'border-amber-500 ring-1 ring-amber-500 bg-amber-50/30' :
                'border-gray-200 hover:bg-gray-50'">
            <input type="radio" name="skripsi_package" value="aplikasi" class="sr-only" x-model="package">
            <span class="flex flex-1 flex-col">
                <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                        class="fa-solid fa-code text-blue-500 mr-1.5"></i> App Saja</span>
                <span class="mt-1 flex items-center text-[10px] leading-tight text-gray-500">Hanya pembuatan
                    program.</span>
            </span>
            <i class="fa-solid fa-circle-check text-amber-500 text-lg absolute top-3 right-3"
                x-show="package === 'aplikasi'"></i>
        </label>

        <label
            class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none transition-all duration-200"
            :class="package === 'naskah' ? 'border-amber-500 ring-1 ring-amber-500 bg-amber-50/30' :
                'border-gray-200 hover:bg-gray-50'">
            <input type="radio" name="skripsi_package" value="naskah" class="sr-only" x-model="package">
            <span class="flex flex-1 flex-col">
                <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                        class="fa-solid fa-file-word text-amber-600 mr-1.5"></i> Naskah Saja</span>
                <span class="mt-1 flex items-center text-[10px] leading-tight text-gray-500">Skripsi Bab 1-5
                    full.</span>
            </span>
            <i class="fa-solid fa-circle-check text-amber-500 text-lg absolute top-3 right-3"
                x-show="package === 'naskah'"></i>
        </label>

        <label
            class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none transition-all duration-200"
            :class="package === 'keduanya' ? 'border-amber-500 ring-1 ring-amber-500 bg-amber-50/30' :
                'border-gray-200 hover:bg-gray-50'">
            <input type="radio" name="skripsi_package" value="keduanya" class="sr-only" x-model="package">
            <span class="flex flex-1 flex-col">
                <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                        class="fa-solid fa-layer-group text-emerald-500 mr-1.5"></i> All-in</span>
                <span class="mt-1 flex items-center text-[10px] leading-tight text-gray-500">Aplikasi & naskah
                    full.</span>
            </span>
            <i class="fa-solid fa-circle-check text-amber-500 text-lg absolute top-3 right-3"
                x-show="package === 'keduanya'"></i>
        </label>
    </div>

    <p class="text-xs font-bold text-teal-600 mt-2 mb-1 border-b border-teal-100 pb-1">Kategori: Sempro (Bab 1 - 3)</p>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
        <label
            class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none transition-all duration-200"
            :class="package === 'sempro_naskah' ? 'border-teal-500 ring-1 ring-teal-500 bg-teal-50/30' :
                'border-gray-200 hover:bg-gray-50'">
            <input type="radio" name="skripsi_package" value="sempro_naskah" class="sr-only" x-model="package">
            <span class="flex flex-1 flex-col">
                <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                        class="fa-solid fa-file-lines text-teal-600 mr-1.5"></i> Sempro 1-3</span>
                <span class="mt-1 flex items-center text-[10px] leading-tight text-gray-500">Naskah Bab 1 sampai
                    3.</span>
            </span>
            <i class="fa-solid fa-circle-check text-teal-500 text-lg absolute top-3 right-3"
                x-show="package === 'sempro_naskah'"></i>
        </label>

        <label
            class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none transition-all duration-200"
            :class="package === 'sempro_bab3' ? 'border-teal-500 ring-1 ring-teal-500 bg-teal-50/30' :
                'border-gray-200 hover:bg-gray-50'">
            <input type="radio" name="skripsi_package" value="sempro_bab3" class="sr-only" x-model="package">
            <span class="flex flex-1 flex-col">
                <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                        class="fa-regular fa-file-lines text-teal-500 mr-1.5"></i> Sempro Bab 3</span>
                <span class="mt-1 flex items-center text-[10px] leading-tight text-gray-500">Hanya naskah Bab 3
                    saja.</span>
            </span>
            <i class="fa-solid fa-circle-check text-teal-500 text-lg absolute top-3 right-3"
                x-show="package === 'sempro_bab3'"></i>
        </label>

        <label
            class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none transition-all duration-200"
            :class="package === 'sempro_keduanya' ? 'border-teal-500 ring-1 ring-teal-500 bg-teal-50/30' :
                'border-gray-200 hover:bg-gray-50'">
            <input type="radio" name="skripsi_package" value="sempro_keduanya" class="sr-only" x-model="package">
            <span class="flex flex-1 flex-col">
                <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                        class="fa-solid fa-cubes-stacked text-teal-600 mr-1.5"></i> Sempro All-in</span>
                <span class="mt-1 flex items-center text-[10px] leading-tight text-gray-500">App + Naskah Bab
                    1-3.</span>
            </span>
            <i class="fa-solid fa-circle-check text-teal-500 text-lg absolute top-3 right-3"
                x-show="package === 'sempro_keduanya'"></i>
        </label>
    </div>

    <p class="text-xs font-bold text-purple-600 mt-2 mb-1 border-b border-purple-100 pb-1">Kategori: Sidang / Hasil
        (Lanjutan)</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <label
            class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none transition-all duration-200"
            :class="package === 'sidang_aplikasi' ? 'border-purple-500 ring-1 ring-purple-500 bg-purple-50/30' :
                'border-gray-200 hover:bg-gray-50'">
            <input type="radio" name="skripsi_package" value="sidang_aplikasi" class="sr-only" x-model="package">
            <span class="flex flex-1 flex-col">
                <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                        class="fa-solid fa-laptop-code text-purple-500 mr-1.5"></i> Revisi App</span>
                <span class="mt-1 flex items-center text-[10px] leading-tight text-gray-500">App hasil Sempro
                    revisi/lanjut.</span>
            </span>
            <i class="fa-solid fa-circle-check text-purple-500 text-lg absolute top-3 right-3"
                x-show="package === 'sidang_aplikasi'"></i>
        </label>

        <label
            class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none transition-all duration-200"
            :class="package === 'sidang_naskah' ? 'border-purple-500 ring-1 ring-purple-500 bg-purple-50/30' :
                'border-gray-200 hover:bg-gray-50'">
            <input type="radio" name="skripsi_package" value="sidang_naskah" class="sr-only" x-model="package">
            <span class="flex flex-1 flex-col">
                <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                        class="fa-solid fa-book-open text-purple-600 mr-1.5"></i> Bab 4-5</span>
                <span class="mt-1 flex items-center text-[10px] leading-tight text-gray-500">Naskah lanjutan Bab
                    4-5.</span>
            </span>
            <i class="fa-solid fa-circle-check text-purple-500 text-lg absolute top-3 right-3"
                x-show="package === 'sidang_naskah'"></i>
        </label>

        <label
            class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none transition-all duration-200"
            :class="package === 'sidang_bab4' ? 'border-purple-500 ring-1 ring-purple-500 bg-purple-50/30' :
                'border-gray-200 hover:bg-gray-50'">
            <input type="radio" name="skripsi_package" value="sidang_bab4" class="sr-only" x-model="package">
            <span class="flex flex-1 flex-col">
                <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                        class="fa-solid fa-vial-circle-check text-purple-600 mr-1.5"></i> Bab 4 Saja</span>
                <span class="mt-1 flex items-center text-[10px] leading-tight text-gray-500">Khusus Bab 4 /
                    Blackbox.</span>
            </span>
            <i class="fa-solid fa-circle-check text-purple-500 text-lg absolute top-3 right-3"
                x-show="package === 'sidang_bab4'"></i>
        </label>

        <label
            class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none transition-all duration-200"
            :class="package === 'sidang_keduanya' ? 'border-purple-500 ring-1 ring-purple-500 bg-purple-50/30' :
                'border-gray-200 hover:bg-gray-50'">
            <input type="radio" name="skripsi_package" value="sidang_keduanya" class="sr-only" x-model="package">
            <span class="flex flex-1 flex-col">
                <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                        class="fa-solid fa-medal text-purple-600 mr-1.5"></i> Sidang All-in</span>
                <span class="mt-1 flex items-center text-[10px] leading-tight text-gray-500">Revisi App + Bab
                    4-5.</span>
            </span>
            <i class="fa-solid fa-circle-check text-purple-500 text-lg absolute top-3 right-3"
                x-show="package === 'sidang_keduanya'"></i>
        </label>
    </div>
</div>

<div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 mt-4"
    x-show="package !== '' && package !== null" x-cloak>
    <div x-show="['aplikasi', 'keduanya', 'sempro_keduanya', 'sidang_aplikasi', 'sidang_keduanya'].includes(package)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        class="bg-blue-50/50 p-4 rounded-lg border border-blue-100">
        <x-forms.label value="Pilih Developer Aplikasi" class="text-blue-700" />
        <x-forms.dropdown name="programmer_id" class="mt-1 border-blue-200 focus:ring-blue-500">
            <option value="">-- Pilih Developer --</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    {{ old('programmer_id', $project->programmer_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}</option>
            @endforeach
        </x-forms.dropdown>
    </div>

    <div x-show="['naskah', 'keduanya', 'sempro_naskah', 'sempro_bab3', 'sempro_keduanya', 'sidang_naskah', 'sidang_keduanya', 'sidang_bab4'].includes(package)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        class="bg-amber-50/50 p-4 rounded-lg border border-amber-100">
        <x-forms.label value="Pilih Penyusun Naskah" class="text-amber-700" />
        <x-forms.dropdown name="writer_id" class="mt-1 border-amber-200 focus:ring-amber-500">
            <option value="">-- Pilih Penulis Naskah --</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    {{ old('writer_id', $project->writer_id ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}
                </option>
            @endforeach
        </x-forms.dropdown>
    </div>
</div>
