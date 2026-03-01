@csrf

<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-forms.label for="client_name" value="Nama Klien" :required="true" />
            <x-forms.input id="client_name" name="client_name" type="text"
                value="{{ old('client_name', $testimonial->client_name ?? '') }}" required />
            @error('client_name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-forms.label for="email" value="Email Kontak" :required="true" />
            <x-forms.input id="email" name="email" type="email"
                value="{{ old('email', $testimonial->email ?? '') }}" required />
            @error('email')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-forms.label for="phone_number" value="Nomor WhatsApp" :required="true" />
            <x-forms.input id="phone_number" name="phone_number" type="text"
                value="{{ old('phone_number', $testimonial->phone_number ?? '') }}" placeholder="Contoh: 081234567890"
                required />
            <p class="text-[10px] text-gray-400 mt-1">Input 08... akan otomatis dikonversi ke 628... di sistem.</p>
            @error('phone_number')
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
    <button type="submit"
        class="bg-[#1E293B] text-white px-6 py-2 rounded-lg hover:bg-opacity-90 transition font-bold shadow-sm">
        <i class="fa-solid fa-save mr-2"></i> Simpan Data Testimonial
    </button>
</div>
