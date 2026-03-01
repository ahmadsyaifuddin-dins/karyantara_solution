<div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden" id="form-ulasan">
    <div class="bg-[#1E293B] p-8 text-center relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500 rounded-full opacity-20 blur-2xl"></div>
        <h2 class="text-3xl font-extrabold text-white mb-2 relative z-10">Bagikan Pengalaman Anda</h2>
        <p class="text-gray-300 relative z-10">Masukan Anda sangat berharga bagi perkembangan Karyantara Solution.</p>
    </div>

    <div class="p-8 md:p-10">
        <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="opacity-0 absolute -z-50 h-0 w-0 overflow-hidden" aria-hidden="true">
                <label for="company_website">Tinggalkan kosong jika Anda manusia:</label>
                <input type="text" name="company_website" id="company_website" tabindex="-1" autocomplete="off">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-[#1E293B] mb-2">Nama Lengkap <span
                        class="text-red-500">*</span></label>
                <input type="text" name="client_name" value="{{ old('client_name') }}" required
                    placeholder="Contoh: John Doe"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-[#1E293B] mb-2">Email Valid <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="john@example.com"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                    <p class="text-xs text-gray-500 mt-1"><i class="fa-solid fa-lock text-gray-400 mr-1"></i>Tidak akan
                        dipublikasikan.</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#1E293B] mb-2">No. WhatsApp <span
                            class="text-red-500">*</span></label>
                    <input type="tel" name="phone_number" value="{{ old('phone_number') }}" required
                        placeholder="Contoh: 081234567890" pattern="[0-9]{12,15}"
                        title="Gunakan angka saja, 12-15 digit"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                    <p class="text-xs text-gray-500 mt-1"><i
                            class="fa-brands fa-whatsapp text-green-500 mr-1"></i>Gunakan angka saja (Min. 12 digit).
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-[#1E293B] mb-2">Jabatan / Instansi <span
                            class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="client_title" value="{{ old('client_title') }}"
                        placeholder="CEO PT. Maju Mundur, Mahasiswa Sem 8"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#1E293B] mb-2">Foto Profil <span
                            class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="file" name="profile_image" accept="image/*"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                </div>
            </div>

            <div class="mb-6" x-data="{ rating: {{ old('rating', 5) }}, hoverRating: 0 }">
                <label class="block text-sm font-semibold text-[#1E293B] mb-2">Rating Anda <span
                        class="text-red-500">*</span></label>
                <div class="flex space-x-2 text-2xl cursor-pointer">
                    <template x-for="i in 5" :key="i">
                        <i class="fa-solid fa-star transition-colors duration-200" @click="rating = i"
                            @mouseenter="hoverRating = i" @mouseleave="hoverRating = 0"
                            :class="(hoverRating >= i || (!hoverRating && rating >= i)) ? 'text-amber-400 drop-shadow-sm' :
                            'text-gray-300'">
                        </i>
                    </template>
                </div>
                <input type="hidden" name="rating" x-model="rating" required>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-[#1E293B] mb-2">Ulasan Anda <span
                        class="text-red-500">*</span></label>
                <textarea name="testimonial" required rows="4" placeholder="Ceritakan pengalaman luar biasa Anda bersama kami..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors resize-none">{{ old('testimonial') }}</textarea>
            </div>

            <div class="text-center">
                <button type="submit"
                    class="w-full md:w-auto px-8 py-4 bg-[#1E293B] text-white font-bold rounded-xl hover:bg-gray-800 focus:ring-4 focus:ring-amber-500/50 transition transform hover:-translate-y-1 shadow-lg flex items-center justify-center mx-auto group">
                    <i class="fa-solid fa-paper-plane mr-2 group-hover:text-amber-500 transition-colors"></i>
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
</div>
