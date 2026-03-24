@include('admin.meetings.partials.help-guide')

<div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{
    title: '{{ old('title', $meeting->title ?? '') }}',
    type: '{{ old('type', $meeting->type ?? '') }}',
    templates: {
        'Internal Board': ['Evaluasi Kinerja & Finansial', 'Perencanaan Strategi Q3', 'Diskusi Visi Karyantara Solution', 'Review Operasional Bulanan'],
        'Client Meeting': ['Kick-off Project [Nama Klien]', 'Requirement Gathering (Kebutuhan Sistem)', 'Presentasi Mockup UI/UX', 'Handover Project [Nama Aplikasi]'],
        'Project Sync': ['Weekly Standup Sync', 'Review Progress Development', 'Diskusi Kendala Arsitektur Database', 'Sprint Planning & Pembagian Tugas'],
        'Evaluation': ['Retrospective Pasca Rilis Proyek', 'Evaluasi Kinerja Vendor/Tim', 'Post-Mortem Analisis Bug/Server']
    }
}">
    <div class="space-y-4">

        <div>
            <x-forms.label for="title" required>Judul Rapat</x-forms.label>
            <x-forms.input type="text" name="title" id="title" x-model="title" class="mt-1" required />
            @error('title')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror

            <div x-show="type && templates[type]" x-transition class="mt-2" x-cloak>
                <p class="text-[11px] font-medium text-gray-500 mb-1.5"><i
                        class="fa-solid fa-lightbulb text-amber-500 mr-1"></i> Inspirasi Judul Cepat:</p>
                <div class="flex flex-wrap gap-2">
                    <template x-for="tmpl in templates[type]" :key="tmpl">
                        <button type="button" @click="title = tmpl"
                            class="px-2.5 py-1 text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200 rounded-md hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                            <span x-text="tmpl"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <div>
            <x-forms.label for="type" required>Jenis Rapat</x-forms.label>
            <x-forms.dropdown name="type" id="type" x-model="type" class="mt-1" required>
                <option value="" disabled {{ !isset($meeting) ? 'selected' : '' }}>Pilih Jenis...</option>
                @foreach (['Internal Board', 'Client Meeting', 'Project Sync', 'Evaluation'] as $typeOption)
                    <option value="{{ $typeOption }}"
                        {{ old('type', $meeting->type ?? '') == $typeOption ? 'selected' : '' }}>{{ $typeOption }}
                    </option>
                @endforeach
            </x-forms.dropdown>
            @error('type')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-forms.label for="agenda_summary" required>Ringkasan Agenda</x-forms.label>
            <x-forms.textarea name="agenda_summary" id="agenda_summary" rows="3" class="mt-1"
                required>{{ old('agenda_summary', $meeting->agenda_summary ?? '') }}</x-forms.textarea>
            @error('agenda_summary')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-forms.label for="start_time" required>Waktu Mulai</x-forms.label>
                <x-forms.input type="datetime-local" name="start_time" id="start_time"
                    value="{{ old('start_time', isset($meeting) ? $meeting->start_time->format('Y-m-d\TH:i') : '') }}"
                    class="mt-1" required />
                @error('start_time')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <x-forms.label for="end_time" required>Waktu Selesai</x-forms.label>
                <x-forms.input type="datetime-local" name="end_time" id="end_time"
                    value="{{ old('end_time', isset($meeting) ? $meeting->end_time->format('Y-m-d\TH:i') : '') }}"
                    class="mt-1" required />
                @error('end_time')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div>
            <x-forms.label for="location" required>Lokasi / Media</x-forms.label>
            <x-forms.input type="text" name="location" id="location"
                value="{{ old('location', $meeting->location ?? '') }}"
                placeholder="Contoh: Zoom, Google Meet, Ruang Rapat" class="mt-1" required />
            @error('location')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-forms.label for="maps_link">Link Google Maps (Opsional)</x-forms.label>
            <x-forms.input type="url" name="maps_link" id="maps_link"
                value="{{ old('maps_link', $meeting->maps_link ?? '') }}" placeholder="https://maps.google.com/..."
                class="mt-1" />
            @error('maps_link')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-forms.label for="status" required>Status Pelaksanaan</x-forms.label>
            <x-forms.dropdown name="status" id="status" class="mt-1" required>
                @foreach (['Scheduled', 'Ongoing', 'Completed', 'Canceled'] as $status)
                    <option value="{{ $status }}"
                        {{ old('status', $meeting->status ?? 'Scheduled') == $status ? 'selected' : '' }}>
                        {{ $status }}</option>
                @endforeach
            </x-forms.dropdown>
        </div>

        <div>
            <x-forms.label for="minutes_of_meeting">Notulensi / Hasil Pembahasan</x-forms.label>
            <x-forms.textarea name="minutes_of_meeting" id="minutes_of_meeting" rows="4"
                placeholder="Tuliskan hasil rapat di sini..."
                class="mt-1">{{ old('minutes_of_meeting', $meeting->minutes_of_meeting ?? '') }}</x-forms.textarea>
        </div>
    </div>
</div>

<div class="mt-8 border-t border-gray-200 pt-6" x-data="{
    items: {{ json_encode(old('action_items', $meeting->action_items ?? [])) }},
    addItem() { this.items.push({ task: '', pic: '', deadline: '' }) },
    removeItem(index) { this.items.splice(index, 1) }
}">

    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-[#1E293B]">Action Items (Tindak Lanjut)</h3>
        <button type="button" @click="addItem()"
            class="px-3 py-1.5 bg-[#1E293B] hover:bg-slate-800 text-white text-sm font-medium rounded-md transition-colors shadow-sm">
            <i class="fa-solid fa-plus mr-1"></i> Tambah Tindakan
        </button>
    </div>

    <div class="space-y-3">
        <template x-for="(item, index) in items" :key="index">
            <div
                class="flex flex-col sm:flex-row gap-3 bg-gray-50 p-3 rounded-lg border border-gray-200 items-start sm:items-center">

                <div class="flex-1 w-full">
                    <x-forms.input type="text" x-model="item.task" x-bind:name="`action_items[${index}][task]`"
                        placeholder="Apa yang harus dikerjakan?" required />
                </div>

                <div class="w-full sm:w-48">
                    <x-forms.input type="text" x-model="item.pic" x-bind:name="`action_items[${index}][pic]`"
                        placeholder="PIC (Penanggung Jawab)" required />
                </div>

                <div class="w-full sm:w-40">
                    <x-forms.input type="date" x-model="item.deadline"
                        x-bind:name="`action_items[${index}][deadline]`" required />
                </div>

                <button type="button" @click="removeItem(index)"
                    class="text-red-500 hover:bg-red-50 w-full sm:w-auto px-3 py-2 text-center rounded-md border border-red-100 transition-colors"
                    title="Hapus">
                    <i class="fa-solid fa-trash-can"></i> <span class="sm:hidden ml-1">Hapus Baris</span>
                </button>
            </div>
        </template>

        <div x-show="items.length === 0"
            class="text-center py-6 text-sm text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-300"
            x-cloak>
            <i class="fa-solid fa-list-check text-2xl text-gray-300 mb-2 block"></i>
            Belum ada tindak lanjut khusus. <br>Klik tombol <strong>Tambah Tindakan</strong> jika ada hal yang harus
            dikerjakan setelah rapat.
        </div>
    </div>
</div>
