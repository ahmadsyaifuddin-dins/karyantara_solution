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
            <x-forms.label for="position" value="Jabatan / Pangkat" />
            <x-forms.input id="position" name="position" type="text"
                value="{{ old('position', $admin->position ?? '') }}" placeholder="Contoh: Backend Developer, CEO"
                class="mt-1" />
            @error('position')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-forms.label for="department" value="Divisi" />
            <x-forms.dropdown name="department" id="department" class="mt-1">
                <option value="">-- Pilih Divisi --</option>
                @foreach (['Board of Directors', 'Engineering', 'Product & Design', 'Finance & HR'] as $dept)
                    <option value="{{ $dept }}"
                        {{ old('department', $admin->department ?? '') == $dept ? 'selected' : '' }}>
                        {{ $dept }}
                    </option>
                @endforeach
            </x-forms.dropdown>
            @error('department')
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
