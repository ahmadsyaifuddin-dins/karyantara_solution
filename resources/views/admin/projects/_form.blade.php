<div x-data="{ clientType: '{{ old('client_type', $project->client_type ?? 'mahasiswa') }}' }">

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
                <option value="Pending" {{ old('status', $project->status) == 'Pending' ? 'selected' : '' }}>Pending
                </option>
                <option value="Progress" {{ old('status', $project->status) == 'Progress' ? 'selected' : '' }}>Progress
                </option>
                <option value="Revisi" {{ old('status', $project->status) == 'Revisi' ? 'selected' : '' }}>Revisi
                </option>
                <option value="Selesai" {{ old('status', $project->status) == 'Selesai' ? 'selected' : '' }}>Selesai
                </option>
            </x-forms.dropdown>
        </div>
    </div>

    <div x-show="clientType === 'mahasiswa'" x-collapse
        class="bg-amber-50/50 p-6 rounded-lg border border-amber-100 mb-6 grid grid-cols-1 md:grid-cols-2 gap-6"
        style="display: none;">
        <h3 class="col-span-1 md:col-span-2 font-bold text-amber-700 border-b border-amber-200 pb-2">
            <i class="fa-solid fa-graduation-cap mr-2"></i>Data Spesifik Mahasiswa
        </h3>

        <div>
            <x-forms.label value="NPM / NIM" />
            <x-forms.input type="text" name="npm" value="{{ old('npm', $project->npm) }}" />
        </div>
        <div>
            <x-forms.label value="Kelas / Jurusan" />
            <x-forms.input type="text" name="class_name" value="{{ old('class_name', $project->class_name) }}" />
        </div>
        <div>
            <x-forms.label value="Dosen Pembimbing 1" />
            <x-forms.input type="text" name="dospem_1" value="{{ old('dospem_1', $project->dospem_1) }}" />
        </div>
        <div>
            <x-forms.label value="Dosen Pembimbing 2" />
            <x-forms.input type="text" name="dospem_2" value="{{ old('dospem_2', $project->dospem_2) }}" />
        </div>
        <div class="col-span-1 md:col-span-2">
            <x-forms.label value="Judul Skripsi (Fix)" />
            <x-forms.input type="text" name="skripsi_title"
                value="{{ old('skripsi_title', $project->skripsi_title) }}" />
        </div>
    </div>

    <div class="mb-6">
        <x-forms.label value="Deskripsi Pekerjaan (Fitur yang dibuat)" required="true" />
        <x-forms.textarea name="project_description" rows="3"
            required>{{ old('project_description', $project->project_description) }}</x-forms.textarea>
    </div>

    <div class="bg-emerald-50/30 p-6 rounded-lg border border-emerald-100 mb-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <h3 class="col-span-1 md:col-span-3 font-bold text-emerald-700 border-b border-emerald-200 pb-2">
            <i class="fa-solid fa-rupiah-sign mr-2"></i>Keuangan
        </h3>

        <div>
            <x-forms.label value="Pendapatan Bersih (Harga Fix)" required="true" />
            <x-forms.currency name="net_income" value="{{ old('net_income', $project->net_income ?? 0) }}"
                required="true" /> <span class="text-xs text-gray-500 mt-1 block">Harga final setelah potong fee
                broker.</span>
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
                    {{ old('payment_method', $project->payment_method) == 'transfer' ? 'selected' : '' }}>Transfer
                    Bank/E-Wallet</option>
                <option value="cash"
                    {{ old('payment_method', $project->payment_method) == 'cash' ? 'selected' : '' }}>Cash (Tunai)
                </option>
            </x-forms.dropdown>
        </div>
    </div>

    <div class="mb-8">
        <x-forms.label value="Catatan Revisi" />
        <x-forms.textarea name="revision_notes" rows="2"
            placeholder="Contoh: Dosen minta tambah fitur cetak laporan...">{{ old('revision_notes', $project->revision_notes) }}</x-forms.textarea>
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
