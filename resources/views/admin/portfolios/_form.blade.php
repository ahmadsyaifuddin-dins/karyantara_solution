@csrf
<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-forms.label for="title" value="Judul Proyek" :required="true" />
            <x-forms.input id="title" name="title" type="text" value="{{ old('title', $portfolio->title ?? '') }}"
                required />
            @error('title')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <x-forms.label for="category" value="Kategori Proyek" :required="true" />
            <x-forms.dropdown id="category" name="category" required>
                <option value="">Pilih Kategori</option>
                <option value="Web Development"
                    {{ old('category', $portfolio->category ?? '') == 'Web Development' ? 'selected' : '' }}>Web
                    Development</option>
                <option value="Mobile App"
                    {{ old('category', $portfolio->category ?? '') == 'Mobile App' ? 'selected' : '' }}>Mobile App
                </option>
                <option value="UI/UX Design"
                    {{ old('category', $portfolio->category ?? '') == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design
                </option>
                <option value="Lainnya"
                    {{ old('category', $portfolio->category ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </x-forms.dropdown>
            @error('category')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div>
        <x-forms.label for="description" value="Deskripsi Singkat" :required="true" />
        <x-forms.textarea id="description" name="description" rows="4"
            required>{{ old('description', $portfolio->description ?? '') }}</x-forms.textarea>
        @error('description')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-forms.label for="client_name" value="Nama Klien (Opsional)" />
            <x-forms.input id="client_name" name="client_name" type="text"
                value="{{ old('client_name', $portfolio->client_name ?? '') }}" />
            @error('client_name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <x-forms.label for="project_url" value="URL Proyek (Opsional)" />
            <x-forms.input id="project_url" name="project_url" type="url"
                value="{{ old('project_url', $portfolio->project_url ?? '') }}" placeholder="https://..." />
            @error('project_url')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div>
        <x-forms.label for="image" value="Gambar/Thumbnail Portofolio" :required="!isset($portfolio)" />
        @if (isset($portfolio))
            <div class="mb-2">
                <img src="{{ asset('uploads/portfolios/' . $portfolio->image) }}" alt="Preview"
                    class="h-32 object-cover rounded border border-gray-300">
            </div>
        @endif
        <input type="file" name="image" id="image" accept="image/*" :required="!isset($portfolio)"
            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#1E293B] file:text-white hover:file:bg-opacity-90 transition">
        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maks 2MB.</p>
        @error('image')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="mt-6 flex justify-end">
    <button type="submit"
        class="bg-[#1E293B] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition font-semibold">
        Simpan Data
    </button>
</div>
