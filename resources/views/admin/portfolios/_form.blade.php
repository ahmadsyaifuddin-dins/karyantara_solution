@csrf
<div class="space-y-6">
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
            <x-forms.label for="admin_id" value="Developer / Penanggung Jawab" :required="true" />
            <x-forms.dropdown id="admin_id" name="admin_id" required>
                <option value="">Pilih Developer</option>
                @foreach ($admins as $admin)
                    <option value="{{ $admin->id }}"
                        {{ old('admin_id', $portfolio->admin_id ?? '') == $admin->id ? 'selected' : '' }}>
                        {{ $admin->name }}
                    </option>
                @endforeach
            </x-forms.dropdown>
            @error('admin_id')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <x-forms.label for="client_name" value="Nama Klien (Opsional)" />
            <x-forms.input id="client_name" name="client_name" type="text"
                value="{{ old('client_name', $portfolio->client_name ?? '') }}" />
        </div>
        <div>
            <x-forms.label for="project_url" value="URL Proyek (Opsional)" />
            <x-forms.input id="project_url" name="project_url" type="url"
                value="{{ old('project_url', $portfolio->project_url ?? '') }}" placeholder="https://..." />
        </div>
    </div>

    <div x-data="imageGallery()" class="bg-gray-50 p-6 rounded-xl border border-gray-200">
        <h3 class="text-lg font-bold text-[#1E293B] mb-1"><i class="fa-regular fa-images text-amber-500 mr-2"></i>Galeri
            Portofolio</h3>
        <p class="text-xs text-gray-500 mb-4">Pilih satu gambar sebagai Thumbnail (Gambar Utama) yang akan tampil di
            halaman depan.</p>

        @if (isset($portfolio) && $portfolio->images->count() > 0)
            <div class="mb-6">
                <span class="text-sm font-bold text-gray-700 block mb-2">Gambar Saat Ini:</span>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($portfolio->images as $img)
                        <div class="relative group rounded-lg overflow-hidden border-2 transition-all"
                            :class="existingThumbnail == {{ $img->id }} ? 'border-amber-500 shadow-md' :
                                'border-transparent'"
                            x-show="!deletedImages.includes({{ $img->id }})">

                            <img src="{{ asset('uploads/portfolios/' . $img->image) }}"
                                class="w-full h-24 object-cover">

                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-center items-center gap-2">
                                <label
                                    class="cursor-pointer bg-white/90 px-2 py-1 rounded text-xs font-bold text-[#1E293B] hover:bg-amber-400 transition">
                                    <input type="radio" name="existing_thumbnail_id" value="{{ $img->id }}"
                                        x-model="existingThumbnail" class="hidden">
                                    Jadikan Utama
                                </label>
                                <button type="button" @click="deleteExisting({{ $img->id }})"
                                    class="bg-red-500 text-white px-2 py-1 rounded text-xs font-bold hover:bg-red-600 transition">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </div>

                            <div x-show="existingThumbnail == {{ $img->id }}"
                                class="absolute top-1 left-1 bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded">
                                UTAMA</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <template x-for="id in deletedImages">
                <input type="hidden" name="deleted_images[]" :value="id">
            </template>
        @endif

        <div>
            <x-forms.label for="images" value="Upload Gambar Baru (Bisa lebih dari 1)" :required="!isset($portfolio)" />
            <input type="file" name="images[]" id="images" multiple accept="image/*" @change="handleFileSelect"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:font-semibold file:bg-[#1E293B] file:text-white hover:file:bg-opacity-90 transition bg-white border border-gray-300 p-1">
            @error('images')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
            @error('images.*')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4" x-show="previews.length > 0" style="display: none;">
            <template x-for="(preview, index) in previews" :key="index">
                <div class="relative rounded-lg overflow-hidden border-2 transition-all cursor-pointer group"
                    :class="newThumbnailIndex === index ? 'border-amber-500 shadow-md' : 'border-gray-200 hover:border-gray-400'"
                    @click="setNewThumbnail(index)">

                    <img :src="preview" class="w-full h-24 object-cover">

                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>

                    <div class="absolute bottom-2 right-2 w-5 h-5 rounded-full border-2 bg-white flex items-center justify-center transition-colors"
                        :class="newThumbnailIndex === index ? 'border-amber-500' : 'border-gray-300'">
                        <div class="w-2.5 h-2.5 rounded-full bg-amber-500" x-show="newThumbnailIndex === index"></div>
                    </div>

                    <div x-show="newThumbnailIndex === index"
                        class="absolute top-1 left-1 bg-amber-500 text-[#1E293B] text-[10px] font-black px-2 py-0.5 rounded shadow">
                        UTAMA</div>
                </div>
            </template>
        </div>

        <input type="hidden" name="thumbnail_index" :value="newThumbnailIndex">

    </div>
</div>

<div class="mt-8 flex justify-end gap-3">
    <a href="{{ route('admin.portfolios.index') }}"
        class="bg-white border border-gray-300 text-gray-700 px-6 py-2.5 rounded-xl hover:bg-gray-50 transition font-semibold shadow-sm">Batal</a>
    <button type="submit"
        class="bg-[#1E293B] text-white px-6 py-2.5 rounded-xl hover:bg-gray-800 transition font-bold shadow-sm flex items-center">
        <i class="fa-solid fa-save mr-2"></i> Simpan Portofolio
    </button>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('imageGallery', () => ({
            // State untuk File Baru
            previews: [],
            newThumbnailIndex: 0, // Default gambar pertama yg diupload yg jadi utama

            // State untuk File Lama (Edit Mode)
            // Cari gambar lama yang is_thumbnail = 1
            existingThumbnail: {{ isset($portfolio) ? $portfolio->images->where('is_thumbnail', 1)->first()->id ?? 'null' : 'null' }},
            deletedImages: [],

            handleFileSelect(event) {
                this.previews = []; // Reset preview
                const files = event.target.files;

                if (files.length > 0) {
                    // Jika ada file baru, kita hapus centang utama dari gambar lama agar tidak bentrok
                    // (Opsional, tapi disarankan agar logic gampang)
                    // this.existingThumbnail = null;
                    this.newThumbnailIndex = 0; // Set default centang ke gambar baru ke-1
                }

                for (let i = 0; i < files.length; i++) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previews.push(e.target.result);
                    };
                    reader.readAsDataURL(files[i]);
                }
            },

            setNewThumbnail(index) {
                this.newThumbnailIndex = index;
                this.existingThumbnail =
                    null; // Uncheck gambar lama jika user milih gambar baru sbg utama
            },

            deleteExisting(id) {
                this.deletedImages.push(id);
                // Jika yang dihapus adalah thumbnail, reset
                if (this.existingThumbnail == id) {
                    this.existingThumbnail = null;
                }
            }
        }))
    })
</script>
