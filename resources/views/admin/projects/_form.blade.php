<div x-data="{
    clientType: '{{ old('client_type', $project->client_type ?? 'mahasiswa') }}',
    package: '{{ old('skripsi_package', $project->skripsi_package ?? '') }}'
}">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="col-span-1 md:col-span-2 bg-gray-50 p-4 rounded-lg border border-gray-200">
            <x-forms.label value="Jenis Klien" required="true" />
            <div class="flex gap-6 mt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <x-forms.radio name="client_type" value="mahasiswa" x-model="clientType" />
                    <span class="text-sm font-medium">Mahasiswa (Skripsi/Tugas)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <x-forms.radio name="client_type" value="umum" x-model="clientType" />
                    <span class="text-sm font-medium">Umum (Bisnis/Corporate)</span>
                </label>
            </div>
        </div>

        <div class="col-span-1 md:col-span-2">
            <x-forms.label value="Visibilitas Pengelolaan" required="true" />
            <div class="flex gap-6 mt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <x-forms.radio name="is_shared" value="1" :checked="old('is_shared', $project->is_shared ?? 1) == 1" />
                    <span class="text-sm font-medium">Kelola Bersama (Semua Admin)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <x-forms.radio name="is_shared" value="0" :checked="old('is_shared', $project->is_shared ?? 1) == 0" />
                    <span class="text-sm font-medium">Private (Hanya Saya)</span>
                </label>
            </div>
        </div>

        <div>
            <x-forms.label value="Nama Klien" required="true" />
            <x-forms.input type="text" name="client_name" value="{{ old('client_name', $project->client_name) }}"
                required />
        </div>

        <div>
            <x-forms.label value="Status Pengerjaan" required="true" />
            <x-forms.dropdown name="status" required>
                <option value="Pending"
                    {{ old('status', $project->status ?? 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Progress" {{ old('status', $project->status ?? '') == 'Progress' ? 'selected' : '' }}>
                    Progress</option>
                <option value="Revisi" {{ old('status', $project->status ?? '') == 'Revisi' ? 'selected' : '' }}>Revisi
                </option>
                <option value="Selesai" {{ old('status', $project->status ?? '') == 'Selesai' ? 'selected' : '' }}>
                    Selesai</option>
            </x-forms.dropdown>
        </div>
    </div>

    <div x-show="clientType === 'mahasiswa'" x-collapse
        class="bg-amber-50/50 p-6 rounded-lg border border-amber-100 mb-6 grid grid-cols-1 md:grid-cols-2 gap-6"
        style="display: none;">

        <h3 class="col-span-1 md:col-span-2 font-bold text-amber-700 border-b border-amber-200 pb-2">
            <i class="fa-solid fa-graduation-cap mr-2"></i>Data Spesifik Mahasiswa
        </h3>

        <div class="col-span-1 md:col-span-2 mt-2">
            <x-forms.label value="Paket Pengerjaan Skripsi" required="true" class="text-amber-700" />
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-2">

                <label
                    class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-all duration-200"
                    :class="package === 'aplikasi' ? 'border-amber-500 ring-1 ring-amber-500 bg-amber-50/30' :
                        'border-gray-200 hover:bg-gray-50'">
                    <input type="radio" name="skripsi_package" value="aplikasi" class="sr-only" x-model="package">
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                                    class="fa-solid fa-code text-blue-500 mr-1.5"></i> Aplikasi Saja</span>
                            <span class="mt-1 flex items-center text-[11px] leading-tight text-gray-500">Hanya pembuatan
                                program/aplikasi.</span>
                        </span>
                    </span>
                    <i class="fa-solid fa-circle-check text-amber-500 text-lg absolute top-4 right-4"
                        x-show="package === 'aplikasi'"></i>
                </label>

                <label
                    class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-all duration-200"
                    :class="package === 'naskah' ? 'border-amber-500 ring-1 ring-amber-500 bg-amber-50/30' :
                        'border-gray-200 hover:bg-gray-50'">
                    <input type="radio" name="skripsi_package" value="naskah" class="sr-only" x-model="package">
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                                    class="fa-solid fa-file-word text-amber-600 mr-1.5"></i> Naskah Saja</span>
                            <span class="mt-1 flex items-center text-[11px] leading-tight text-gray-500">Hanya pembuatan
                                skripsi
                                bab 1-5.</span>
                        </span>
                    </span>
                    <i class="fa-solid fa-circle-check text-amber-500 text-lg absolute top-4 right-4"
                        x-show="package === 'naskah'"></i>
                </label>

                <label
                    class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-all duration-200"
                    :class="package === 'keduanya' ? 'border-amber-500 ring-1 ring-amber-500 bg-amber-50/30' :
                        'border-gray-200 hover:bg-gray-50'">
                    <input type="radio" name="skripsi_package" value="keduanya" class="sr-only" x-model="package">
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="block text-sm font-bold text-[#1E293B] mb-1"><i
                                    class="fa-solid fa-layer-group text-emerald-500 mr-1.5"></i> All-in
                                (Keduanya)</span>
                            <span class="mt-1 flex items-center text-[11px] leading-tight text-gray-500">Aplikasi &
                                naskah lengkap.</span>
                        </span>
                    </span>
                    <i class="fa-solid fa-circle-check text-amber-500 text-lg absolute top-4 right-4"
                        x-show="package === 'keduanya'"></i>
                </label>
            </div>
        </div>

        <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 mt-2"
            x-show="package !== '' && package !== null" x-cloak>

            <div x-show="package === 'aplikasi' || package === 'keduanya'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="bg-blue-50/50 p-4 rounded-lg border border-blue-100">
                <x-forms.label value="Pilih Developer Aplikasi" required="true" class="text-blue-700" />
                <x-forms.dropdown name="programmer_id" class="mt-1 border-blue-200 focus:ring-blue-500">
                    <option value="">-- Pilih Developer --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ old('programmer_id', $project->programmer_id ?? '') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </x-forms.dropdown>
            </div>

            <div x-show="package === 'naskah' || package === 'keduanya'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="bg-amber-50/50 p-4 rounded-lg border border-amber-100">
                <x-forms.label value="Pilih Penyusun Naskah" required="true" class="text-amber-700" />
                <x-forms.dropdown name="writer_id" class="mt-1 border-amber-200 focus:ring-amber-500">
                    <option value="">-- Pilih Penulis Naskah --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ old('writer_id', $project->writer_id ?? '') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </x-forms.dropdown>
            </div>
        </div>

        <div>
            <x-forms.label value="NPM / NIM" />
            <x-forms.input type="text" name="npm" value="{{ old('npm', $project->npm ?? '') }}" />
        </div>
        <div>
            <x-forms.label value="Kelas / Jurusan" />
            <x-forms.input type="text" name="class_name"
                value="{{ old('class_name', $project->class_name ?? '') }}" />
        </div>
        <div>
            <x-forms.label value="Dosen Pembimbing 1" />
            <x-forms.input type="text" name="dospem_1" value="{{ old('dospem_1', $project->dospem_1 ?? '') }}" />
        </div>
        <div>
            <x-forms.label value="Dosen Pembimbing 2" />
            <x-forms.input type="text" name="dospem_2" value="{{ old('dospem_2', $project->dospem_2 ?? '') }}" />
        </div>
        <div class="col-span-1 md:col-span-2">
            <x-forms.label value="Judul Skripsi (Fix)" />
            <x-forms.input type="text" name="skripsi_title"
                value="{{ old('skripsi_title', $project->skripsi_title ?? '') }}" />
        </div>
    </div>

    <div class="mb-6">
        <x-forms.label value="Deskripsi Pekerjaan (Fitur yang dibuat)" required="true" />
        <x-forms.textarea name="project_description" rows="3"
            required>{{ old('project_description', $project->project_description ?? '') }}</x-forms.textarea>
    </div>

    <div class="bg-emerald-50/30 p-6 rounded-lg border border-emerald-100 mb-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <h3 class="col-span-1 md:col-span-3 font-bold text-emerald-700 border-b border-emerald-200 pb-2">
            <i class="fa-solid fa-rupiah-sign mr-2"></i>Keuangan
        </h3>

        <div>
            <x-forms.label value="Pendapatan Bersih (Harga Fix)" required="true" />
            <x-forms.currency name="net_income" value="{{ old('net_income', $project->net_income ?? 0) }}"
                required="true" />
            <span class="text-xs text-gray-500 mt-1 block">Harga final setelah potong fee broker.</span>
        </div>
        <div>
            <x-forms.label value="Sudah Terbayar (DP/Lunas)" required="true" />
            <x-forms.currency name="paid_amount" value="{{ old('paid_amount', $project->paid_amount ?? 0) }}"
                required="true" />
        </div>
        <div>
            <x-forms.label value="Jenis Pembayaran" required="true" />
            <x-forms.dropdown name="payment_method" required>
                <option value="transfer"
                    {{ old('payment_method', $project->payment_method ?? '') == 'transfer' ? 'selected' : '' }}>
                    Transfer Bank/E-Wallet</option>
                <option value="cash"
                    {{ old('payment_method', $project->payment_method ?? '') == 'cash' ? 'selected' : '' }}>Cash
                    (Tunai)</option>
            </x-forms.dropdown>
        </div>
    </div>

    <div class="mb-8">
        <x-forms.label value="Catatan Revisi" />
        <x-forms.textarea name="revision_notes" rows="2"
            placeholder="Contoh: Dosen minta tambah fitur cetak laporan...">{{ old('revision_notes', $project->revision_notes ?? '') }}</x-forms.textarea>
    </div>

    <div class="flex justify-end gap-3 border-t border-gray-200 pt-6">
        <a href="{{ route('admin.projects.index') }}"
            class="bg-white border border-gray-300 text-gray-700 px-6 py-2.5 rounded-lg hover:bg-gray-50 transition font-semibold shadow-sm">Batal</a>
        <button type="submit"
            class="bg-[#1E293B] text-white px-6 py-2.5 rounded-lg hover:bg-gray-800 transition font-bold shadow-sm flex items-center">
            <i class="fa-solid fa-save mr-2"></i> Simpan Data Proyek
        </button>
    </div>

</div>
