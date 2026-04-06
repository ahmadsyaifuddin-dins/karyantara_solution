@csrf

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-forms.label for="name" value="Nama Jabatan" :required="true" />
            <x-forms.input id="name" name="name" type="text" value="{{ old('name', $position->name ?? '') }}"
                placeholder="Cth: Frontend Developer" required />
            @error('name')
                <span class="text-sm text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-forms.label for="department" value="Divisi (Department)" />
            <x-forms.input id="department" name="department" type="text"
                value="{{ old('department', $position->department ?? '') }}" placeholder="Cth: Engineering" />
            @error('department')
                <span class="text-sm text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-forms.label for="parent_id" value="Atasan Langsung" />
            <x-forms.dropdown name="parent_id" id="parent_id">
                <option value="">-- Pucuk Pimpinan (Tidak Ada Atasan) --</option>
                @foreach ($parentPositions as $parent)
                    <option value="{{ $parent->id }}"
                        {{ old('parent_id', $position->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }} {{ $parent->department ? '(' . $parent->department . ')' : '' }}
                    </option>
                @endforeach
            </x-forms.dropdown>
            <p class="text-xs text-gray-400 mt-1">Kosongkan jika ini adalah jabatan tertinggi (CEO/CTO).</p>
            @error('parent_id')
                <span class="text-sm text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div x-data="{ icon: '{{ old('icon', $position->icon ?? 'fa-solid fa-user') }}' }">
            <x-forms.label for="icon" value="Class Ikon (FontAwesome)" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                    <i :class="icon || 'fa-solid fa-user'"></i>
                </div>
                <x-forms.input id="icon" name="icon" type="text" x-model="icon" class="pl-10"
                    placeholder="Cth: fa-solid fa-laptop-code" />
            </div>
            <p class="text-xs text-gray-400 mt-1"><a href="https://fontawesome.com/search?o=r&m=free" target="_blank"
                    class="text-amber-600 hover:underline">Cari ikon di sini</a>.</p>
            @error('icon')
                <span class="text-sm text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
        <div>
            <x-forms.label for="color_bg" value="Warna Background Badge" />
            <x-forms.dropdown name="color_bg" id="color_bg">
                <option value="bg-gray-100"
                    {{ old('color_bg', $position->color_bg ?? '') == 'bg-gray-100' ? 'selected' : '' }}>Abu-abu
                    (Default)</option>
                <option value="bg-[#1E293B]"
                    {{ old('color_bg', $position->color_bg ?? '') == 'bg-[#1E293B]' ? 'selected' : '' }}>Slate Blue
                    (Utama)</option>
                <option value="bg-amber-500"
                    {{ old('color_bg', $position->color_bg ?? '') == 'bg-amber-500' ? 'selected' : '' }}>Amber (Emas)
                </option>
                <option value="bg-blue-50"
                    {{ old('color_bg', $position->color_bg ?? '') == 'bg-blue-50' ? 'selected' : '' }}>Biru Lembut
                </option>
                <option value="bg-emerald-50"
                    {{ old('color_bg', $position->color_bg ?? '') == 'bg-emerald-50' ? 'selected' : '' }}>Hijau Lembut
                </option>
                <option value="bg-purple-50"
                    {{ old('color_bg', $position->color_bg ?? '') == 'bg-purple-50' ? 'selected' : '' }}>Ungu Lembut
                </option>
                <option value="bg-rose-50"
                    {{ old('color_bg', $position->color_bg ?? '') == 'bg-rose-50' ? 'selected' : '' }}>Merah Lembut
                </option>
            </x-forms.dropdown>
        </div>

        <div>
            <x-forms.label for="color_text" value="Warna Teks Badge" />
            <x-forms.dropdown name="color_text" id="color_text">
                <option value="text-gray-700"
                    {{ old('color_text', $position->color_text ?? '') == 'text-gray-700' ? 'selected' : '' }}>Abu-abu
                    (Default)</option>
                <option value="text-white"
                    {{ old('color_text', $position->color_text ?? '') == 'text-white' ? 'selected' : '' }}>Putih
                </option>
                <option value="text-[#1E293B]"
                    {{ old('color_text', $position->color_text ?? '') == 'text-[#1E293B]' ? 'selected' : '' }}>Slate
                    Blue (Utama)</option>
                <option value="text-amber-500"
                    {{ old('color_text', $position->color_text ?? '') == 'text-amber-500' ? 'selected' : '' }}>Amber
                    (Emas)</option>
                <option value="text-blue-700"
                    {{ old('color_text', $position->color_text ?? '') == 'text-blue-700' ? 'selected' : '' }}>Biru
                    Gelap</option>
                <option value="text-emerald-700"
                    {{ old('color_text', $position->color_text ?? '') == 'text-emerald-700' ? 'selected' : '' }}>Hijau
                    Gelap</option>
                <option value="text-purple-700"
                    {{ old('color_text', $position->color_text ?? '') == 'text-purple-700' ? 'selected' : '' }}>Ungu
                    Gelap</option>
                <option value="text-rose-700"
                    {{ old('color_text', $position->color_text ?? '') == 'text-rose-700' ? 'selected' : '' }}>Merah
                    Gelap</option>
            </x-forms.dropdown>
        </div>
    </div>

    <div>
        <x-forms.label for="description" value="Deskripsi Tugas & Peran" />
        <x-forms.textarea-ai id="description" name="description" rows="3"
            placeholder="Jelaskan secara singkat tanggung jawab posisi ini..." aiUrl="{{ route('admin.ai.enhance') }}">
            {{ old('description', $position->description ?? '') }}
        </x-forms.textarea-ai>
        @error('description')
            <span class="text-sm text-red-500 mt-1 block">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="mt-8 pt-5 border-t border-gray-100 flex justify-end items-center gap-3">
    <a href="{{ route('admin.positions.index') }}"
        class="px-5 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
        Batal
    </a>
    <button type="submit"
        class="bg-[#1E293B] text-white px-6 py-2.5 rounded-lg hover:bg-slate-800 focus:ring-4 focus:ring-slate-200 transition font-semibold flex items-center gap-2">
        <i class="fa-solid fa-save"></i> {{ isset($position) ? 'Simpan Perubahan' : 'Simpan Jabatan' }}
    </button>
</div>
