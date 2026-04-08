<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <x-forms.label for="project_id" value="Pilih Proyek / Klien" required />
        <x-forms.dropdown name="project_id" id="project_id" required>
            <option value="">-- Pilih Proyek Klien --</option>
            @foreach ($projects as $project)
                <option value="{{ $project->id }}"
                    title="{{ $project->client_name }} - {{ $project->skripsi_title ?? 'Tanpa Judul' }}"
                    {{ old('project_id', $ticket->project_id ?? '') == $project->id ? 'selected' : '' }}>

                    {{ $project->client_name }} -
                    {{ \Illuminate\Support\Str::limit($project->skripsi_title ?? 'Tanpa Judul', 45) }}

                </option>
            @endforeach
        </x-forms.dropdown>
        @error('project_id')
            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label for="type" value="Tipe Revisi" required />
        <x-forms.dropdown name="type" id="type" required>
            <option value="">-- Pilih Tipe --</option>
            <option value="app" {{ old('type', $ticket->type ?? '') == 'app' ? 'selected' : '' }}>Revisi Aplikasi
            </option>
            <option value="naskah" {{ old('type', $ticket->type ?? '') == 'naskah' ? 'selected' : '' }}>Revisi Naskah
            </option>
            <option value="keduanya" {{ old('type', $ticket->type ?? '') == 'keduanya' ? 'selected' : '' }}>Revisi
                Keduanya (All-In)</option>
        </x-forms.dropdown>
        @error('type')
            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div class="md:col-span-2">
        <x-forms.label for="title" value="Judul / Fase Revisi" required />
        <x-forms.input id="title" name="title" value="{{ old('title', $ticket->title ?? '') }}"
            placeholder="Misal: Revisi Pasca Sempro, Revisi Bab 4, dll..." required />
        <p class="text-[11px] text-gray-500 mt-1">1 Tiket mewakili 1 Fase (akan dihitung 1x jatah kuota revisi).</p>
        @error('title')
            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div class="md:col-span-2">
        <x-forms.label for="description" value="Detail Catatan Revisi (Bisa copas langsung dari WA)" />
        <x-forms.textarea-ai id="description" name="description" aiUrl="{{ route('admin.ai.enhance') }}">
            {{ old('description', $ticket->description ?? '') }}
        </x-forms.textarea-ai>
        <p class="text-xs text-gray-500 mt-2"><i class="fa-solid fa-wand-magic-sparkles text-amber-500 mr-1"></i> Klik
            tombol <b>AI</b> di sudut text box untuk merapikan teks otomatis.</p>
        @error('description')
            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

</div>
