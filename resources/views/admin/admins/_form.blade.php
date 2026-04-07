@csrf

<div class="space-y-4">
    <div>
        <x-forms.label for="name" value="Nama Lengkap" :required="true" />
        <x-forms.input id="name" name="name" type="text" value="{{ old('name', $admin->name ?? '') }}" required
            autocomplete="name" />
        @error('name')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label for="email" value="Alamat Email" :required="true" />
        <x-forms.input id="email" name="email" type="email" value="{{ old('email', $admin->email ?? '') }}"
            required autocomplete="email" />
        @error('email')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-forms.label for="role" value="Hak Akses (Role)" :required="true" />
            <x-forms.dropdown name="role" id="role" class="mt-1" required>
                <option value="">-- Pilih Hak Akses --</option>

                {{-- Looping Data Role Spatie Secara Dinamis --}}
                @foreach ($roles as $r)
                    <option value="{{ $r->name }}"
                        {{ old('role', $userRole ?? ($admin->role ?? '')) == $r->name ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $r->name)) }}
                    </option>
                @endforeach

            </x-forms.dropdown>
            <p class="text-xs text-gray-400 mt-1">Menentukan fitur & menu apa saja yang bisa diakses.</p>
            @error('role')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-forms.label for="position_id" value="Jabatan/Posisi" />
            <x-forms.dropdown name="position_id" id="position_id" class="mt-1">
                <option value="">-- Pilih Jabatan --</option>
                @foreach ($positions as $pos)
                    <option value="{{ $pos->id }}"
                        {{ old('position_id', $admin->position_id ?? '') == $pos->id ? 'selected' : '' }}>
                        {{ $pos->name }} {{ $pos->department ? '(' . $pos->department . ')' : '' }}
                    </option>
                @endforeach
            </x-forms.dropdown>
            <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika belum ada jabatan.</p>
            @error('position_id')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div>
        <x-forms.label for="password" value="Password" :required="!isset($admin)" />
        <x-forms.input id="password" name="password" type="password" autocomplete="new-password" :required="!isset($admin)" />

        @if (isset($admin))
            <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
        @endif
        @error('password')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label for="password_confirmation" value="Konfirmasi Password" :required="!isset($admin)" />
        <x-forms.input id="password_confirmation" name="password_confirmation" type="password"
            autocomplete="new-password" :required="!isset($admin)" />
    </div>
</div>

<div class="mt-6 flex justify-end">
    <button type="submit"
        class="bg-[#1E293B] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition font-semibold">
        Simpan Akun
    </button>
</div>
