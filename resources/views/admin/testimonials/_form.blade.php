@csrf

<div class="space-y-4">
    <div>
        <x-forms.label for="client_name" value="Nama Klien" :required="true" />
        <x-forms.input id="client_name" name="client_name" type="text"
            value="{{ old('client_name', $testimonial->client_name ?? '') }}" required />
        @error('client_name')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label for="client_title" value="Title / Jabatan (Opsional)" />
        <x-forms.input id="client_title" name="client_title" type="text"
            value="{{ old('client_title', $testimonial->client_title ?? '') }}"
            placeholder="Misal: Mahasiswa, CEO PT Maju Mundur" />
        @error('client_title')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label for="testimonial" value="Kalimat Testimonial" :required="true" />
        <x-forms.textarea id="testimonial" name="testimonial" rows="4"
            required>{{ old('testimonial', $testimonial->testimonial ?? '') }}</x-forms.textarea>
        @error('testimonial')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label for="rating" value="Rating Bintang" :required="true" />
        <x-forms.dropdown id="rating" name="rating" required>
            @for ($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}"
                    {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>
                    {{ $i }} Bintang
                </option>
            @endfor
        </x-forms.dropdown>
        @error('rating')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label for="profile_image" value="Gambar Profile (Opsional)" />
        <x-forms.upload-gambar name="profile_image" id="profile_image" :currentImage="$testimonial->profile_image ?? null" />
        <p class="text-xs text-gray-400 mt-1">Kosongkan jika ingin menggunakan avatar default. Maks 2MB.</p>
        @error('profile_image')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="mt-6 flex justify-end">
    <button type="submit" class="bg-[#1E293B] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition">
        Simpan Data
    </button>
</div>
