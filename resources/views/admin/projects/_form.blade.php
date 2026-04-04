<div x-data="{
    clientType: '{{ old('client_type', $project->client_type ?? 'mahasiswa') }}',
    package: '{{ old('skripsi_package', $project->skripsi_package ?? '') }}',
    customTeam: {{ json_encode(old('custom_team', $project->custom_team ?? [])) }},

    addTeamMember() {
        this.customTeam.push({ user_id: '', role: '', fee: 0 });
    },
    removeTeamMember(index) {
        this.customTeam.splice(index, 1);
    }
}">

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-5 mb-6 rounded-r-xl shadow-sm animate-pulse">
            <div class="flex items-center mb-3">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-xl mr-2"></i>
                <h3 class="text-red-800 font-extrabold text-lg">Waduh! Ada {{ $errors->count() }} isian yang kurang
                    tepat:</h3>
            </div>
            <ul class="list-disc list-inside text-sm text-red-600 ml-2 space-y-1.5 font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('admin.projects.partials.form.general')

    <div x-show="clientType === 'mahasiswa'" x-collapse
        class="bg-amber-50/50 p-6 rounded-lg border border-amber-100 mb-6 grid grid-cols-1 md:grid-cols-2 gap-6"
        style="display: none;">
        <h3 class="col-span-1 md:col-span-2 font-bold text-amber-700 border-b border-amber-200 pb-2">
            <i class="fa-solid fa-graduation-cap mr-2"></i>Data Spesifik Mahasiswa
        </h3>

        @include('admin.projects.partials.form.packages')
        @include('admin.projects.partials.form.academic')
    </div>

    @include('admin.projects.partials.form.custom-team')

    <div class="mb-6">
        <x-forms.label value="Deskripsi Pekerjaan (Fitur yang dibuat)" required="true" />
        <x-forms.textarea-ai name="project_description" rows="3" required
            aiUrl="{{ route('admin.ai.enhance') }}">{{ old('project_description', $project->project_description ?? '') }}</x-forms.textarea-ai>
    </div>

    @include('admin.projects.partials.form.finance')

    <div class="mb-8">
        <x-forms.label value="Catatan Revisi" />
        <x-forms.textarea-ai name="revision_notes" rows="2"
            placeholder="Contoh: Klien minta tambah fitur laporan PDF..."
            aiUrl="{{ route('admin.ai.enhance') }}">{{ old('revision_notes', $project->revision_notes ?? '') }}</x-forms.textarea-ai>
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
