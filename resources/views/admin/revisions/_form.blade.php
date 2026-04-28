<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="md:col-span-2 mb-2">
        <div
            class="bg-gradient-to-r from-amber-50 to-slate-50 border border-amber-200/60 rounded-xl p-4 sm:p-5 shadow-sm flex items-start gap-4 transition-all hover:shadow-md">
            <div
                class="bg-white p-2.5 rounded-lg shadow-sm border border-amber-100 shrink-0 flex items-center justify-center">
                <i class="fa-solid fa-wand-magic-sparkles text-amber-500 text-xl animate-pulse"></i>
            </div>
            <div>
                <h4 class="text-sm font-extrabold text-[#1E293B] mb-1.5 flex items-center gap-2">
                    Fitur Cerdas AI Auto-Tagging Aktif!
                </h4>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Punya log chat revisi WA yang berantakan? Copas saja langsung ke kolom <b>Detail Catatan Revisi</b>
                    di bawah, lalu klik tombol <b>AI</b> (<i
                        class="fa-solid fa-wand-magic-sparkles text-amber-500 mx-0.5"></i>). Sistem akan otomatis
                    merapikan bahasa teks Anda sekaligus <b>memilihkan Tag Kategori yang paling tepat</b> secara
                    otomatis. Hemat waktu, tanpa ribet!
                </p>
            </div>
        </div>
    </div>
    <div>
        <x-forms.label for="project_id" value="Pilih Proyek / Klien" required />
        <x-forms.dropdown name="project_id" id="project_id" searchable required>
            <option value="">-- Pilih Proyek Klien --</option>
            @foreach ($projects as $project)
                <option value="{{ $project->id }}"
                    {{ old('project_id', $ticket->project_id ?? '') == $project->id ? 'selected' : '' }}>
                    {{ $project->client_name }} -
                    {{ \Illuminate\Support\Str::limit($project->skripsi_title ?? 'Tanpa Judul', 50) }}
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
        <x-forms.label for="tags" value="Tag Kategori (Bisa Pilih Banyak)" />
        <select x-data="searchableDropdown" x-ref="selectNode" name="tags[]" id="tags" multiple class="w-full"
            autocomplete="off" placeholder="Ketik atau pilih tag...">
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}"
                    {{ collect(old('tags', isset($ticket) ? $ticket->tags->pluck('id')->toArray() : []))->contains($tag->id) ? 'selected' : '' }}>
                    {{ $tag->name }}</option>
            @endforeach
        </select>
        <p class="text-[11px] text-gray-500 mt-1">Gunakan tag untuk mengkategorikan jenis perbaikan (contoh: Error
            Logic, UI/UX, Database).</p>
        @error('tags')
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
        <x-forms.label for="description"
            value="Detail Catatan Revisi (Bisa copas langsung dari WA/TA FTI/SIA UNISKA/Telegram)" />
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
