<form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="opacity-0 absolute -z-50 h-0 w-0 overflow-hidden" aria-hidden="true">
        <label for="company_website">Tinggalkan kosong jika Anda manusia:</label>
        <input type="text" name="company_website" id="company_website" tabindex="-1" autocomplete="off">
    </div>

    <div class="mb-6">
        <label class="block text-sm font-semibold text-[#1E293B] mb-2">Nama Lengkap <span
                class="text-red-500">*</span></label>
        <input type="text" name="client_name" x-model="name" required placeholder="Nama Kamu"
            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="block text-sm font-semibold text-[#1E293B] mb-2">Email Valid <span
                    class="text-red-500">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="akunemail@gmail.com"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
            <p class="text-xs text-gray-500 mt-1">
                <i class="fa-solid fa-lock text-gray-400 mr-1"></i>Email tidak akan dipublikasikan.
            </p>
        </div>
        <div>
            <label class="block text-sm font-semibold text-[#1E293B] mb-2">No. WhatsApp <span
                    class="text-red-500">*</span></label>
            <input type="tel" name="phone_number" value="{{ old('phone_number') }}" required
                placeholder="Contoh: 081234567890" pattern="[0-9]{10,15}" title="Gunakan angka saja, 10-15 digit"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">

            <div class="mt-2 bg-green-50 p-2.5 rounded-lg border border-green-100 flex items-start gap-2">
                <i class="fa-brands fa-whatsapp text-green-600 mt-0.5"></i>
                <p class="text-[11px] text-green-800 leading-tight font-medium">
                    Kerahasiaan terjamin tingkat tinggi. Nomor tidak akan dipublikasikan dan hanya digunakan
                    untuk keperluan konfirmasi admin, <b>*Gunakan angka saja, 10-15 digit </b>.
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="block text-sm font-semibold text-[#1E293B] mb-2">Jabatan / Instansi <span
                    class="text-gray-400 font-normal">(Opsional)</span></label>
            <input type="text" name="client_title" x-model="title" placeholder="Ketik jabatan atau instansi Anda..."
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">

            <button type="button" @click="showReferenceModal = true"
                class="mt-2 flex items-center text-xs font-bold text-amber-600 hover:text-amber-700 transition-colors group">
                <i class="fa-solid fa-lightbulb text-amber-400 mr-1.5 group-hover:text-amber-500 transition-colors"></i>
                Bingung isi apa? Cek referensi disini
            </button>
        </div>
        <div>
            <label class="block text-sm font-semibold text-[#1E293B] mb-2">Foto Profil <span
                    class="text-gray-400 font-normal">(Opsional)</span></label>
            <input type="file" name="profile_image" accept="image/*" @change="handleImageSelect"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
        </div>
    </div>

    <div class="mb-6">
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
        <textarea name="testimonial" x-model="review" required rows="4"
            placeholder="Ceritakan pengalaman luar biasa Anda bersama kami..."
            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors resize-none"></textarea>
    </div>

    <div>
        <button type="submit"
            class="w-full md:w-auto px-8 py-4 bg-[#1E293B] text-white font-bold rounded-xl hover:bg-gray-800 focus:ring-4 focus:ring-amber-500/50 transition transform hover:-translate-y-1 shadow-lg flex items-center justify-center group">
            <i class="fa-solid fa-paper-plane mr-2 group-hover:text-amber-500 transition-colors"></i>
            Kirim Ulasan
        </button>
    </div>
</form>
