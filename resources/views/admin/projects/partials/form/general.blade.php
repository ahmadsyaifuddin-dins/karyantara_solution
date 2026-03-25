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

    <div>
        <x-forms.label value="Nama Klien" required="true" />
        <x-forms.input type="text" name="client_name" value="{{ old('client_name', $project->client_name ?? '') }}"
            required />
    </div>

    <div>
        <x-forms.label value="Status Pengerjaan" required="true" />
        <x-forms.dropdown name="status" required>
            <option value="Pending" {{ old('status', $project->status ?? 'Pending') == 'Pending' ? 'selected' : '' }}>
                Pending</option>
            <option value="Progress" {{ old('status', $project->status ?? '') == 'Progress' ? 'selected' : '' }}>
                Progress</option>
            <option value="Revisi" {{ old('status', $project->status ?? '') == 'Revisi' ? 'selected' : '' }}>Revisi
            </option>
            <option value="Selesai" {{ old('status', $project->status ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai
            </option>
        </x-forms.dropdown>
    </div>
</div>
