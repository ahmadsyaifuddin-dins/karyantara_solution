<div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden" id="form-ulasan"
    x-data="{ showReferenceModal: false }">
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
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fa-solid fa-lock text-gray-400 mr-1"></i>Email tidak akan dipublikasikan.
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#1E293B] mb-2">No. WhatsApp <span
                            class="text-red-500">*</span></label>
                    <input type="tel" name="phone_number" value="{{ old('phone_number') }}" required
                        placeholder="Contoh: 081234567890" pattern="[0-9]{12,15}"
                        title="Gunakan angka saja, 12-15 digit"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">

                    <div class="mt-2 bg-green-50 p-2.5 rounded-lg border border-green-100 flex items-start gap-2">
                        <i class="fa-brands fa-whatsapp text-green-600 mt-0.5"></i>
                        <p class="text-[11px] text-green-800 leading-tight font-medium">
                            Kerahasiaan terjamin tingkat tinggi. Nomor tidak akan dipublikasikan dan hanya digunakan
                            untuk keperluan konfirmasi admin, <b>*Gunakan angka saja, 12-15 digit </b>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-[#1E293B] mb-2">Jabatan / Instansi <span
                            class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="client_title" value="{{ old('client_title') }}"
                        placeholder="Ketik jabatan atau instansi Anda..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">

                    <button type="button" @click="showReferenceModal = true"
                        class="mt-2 flex items-center text-xs font-bold text-amber-600 hover:text-amber-700 transition-colors group">
                        <i
                            class="fa-solid fa-lightbulb text-amber-400 mr-1.5 group-hover:text-amber-500 transition-colors"></i>
                        Bingung isi apa? Cek referensi disini
                    </button>
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

    <div x-show="showReferenceModal" style="display: none;"
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center pt-16 mt-12 sm:pt-0"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div x-show="showReferenceModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity"
            @click="showReferenceModal = false"></div>

        <div x-show="showReferenceModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform flex flex-col rounded-2xl bg-white text-left shadow-xl transition-all w-full max-w-4xl mx-4 max-h-[85vh] border border-gray-100 z-50">

            <div class="bg-[#1E293B] px-6 py-4 flex justify-between items-center rounded-t-2xl shrink-0">
                <h3 class="text-lg font-bold text-white flex items-center" id="modal-title">
                    <i class="fa-solid fa-lightbulb text-amber-500 mr-2"></i> Referensi Pengisian
                </h3>
                <button @click="showReferenceModal = false" class="text-gray-400 hover:text-white transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <div class="px-6 py-6 bg-white overflow-y-auto flex-1">
                <p class="text-sm text-gray-600 mb-5 text-center md:text-left">
                    Anda bebas mengisi kolom <span class="font-bold text-[#1E293B]">"Jabatan / Instansi"</span> dengan
                    identitas yang paling mewakili Anda. Berikut adalah beberapa contohnya:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <h4 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-2"><i
                                class="fa-solid fa-building mr-1"></i> Perusahaan / Bisnis</h4>
                        <ul class="text-sm text-gray-700 space-y-1.5 list-disc list-inside ml-1 font-medium">
                            <li>CEO PT. Maju Jaya Bersama</li>
                            <li>Owner "Kopi Senja"</li>
                            <li>Manager Marketing Toko Makmur</li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <h4 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-2"><i
                                class="fa-solid fa-graduation-cap mr-1"></i> Pendidikan / Akademik</h4>
                        <ul class="text-sm text-gray-700 space-y-1.5 list-disc list-inside ml-1 font-medium">
                            <li>Mahasiswa Uniska FTI Banjarmasin</li>
                            <li>Mahasiswa Teknik Informatika Semester 8</li>
                            <li>Dosen Teknik Informatika</li>
                            <li>Guru SMAN 1 Jakarta</li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <h4 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-2"><i
                                class="fa-solid fa-landmark mr-1"></i> Pemerintahan / Organisasi</h4>
                        <ul class="text-sm text-gray-700 space-y-1.5 list-disc list-inside ml-1 font-medium">
                            <li>Kepala Desa Suka Makmur</li>
                            <li>Ketua Karang Taruna RW 05</li>
                            <li>Staf Dinas Kesehatan Daerah</li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <h4 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-2"><i
                                class="fa-solid fa-laptop-code mr-1"></i> Pekerja Bebas / Personal</h4>
                        <ul class="text-sm text-gray-700 space-y-1.5 list-disc list-inside ml-1 font-medium">
                            <li>Freelance Graphic Designer</li>
                            <li>Content Creator</li>
                            <li>Wirausaha / Personal</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 text-right rounded-b-2xl shrink-0">
                <button type="button" @click="showReferenceModal = false"
                    class="inline-flex w-full justify-center rounded-xl bg-[#1E293B] px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-gray-800 transition sm:w-auto">
                    Tutup & Lanjut Mengisi
                </button>
            </div>
        </div>
    </div>
</div>
