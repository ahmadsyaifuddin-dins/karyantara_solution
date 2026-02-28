<x-public-layout title="Kontak Kami - Karyantara Solution">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-[#1E293B]">Hubungi Kami</h1>
            <div class="w-24 h-1 bg-amber-500 mx-auto mt-4 rounded-full mb-6"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">Punya ide proyek atau pertanyaan seputar layanan kami? Jangan ragu
                untuk menghubungi kami.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-start">
                    <div class="text-amber-500 text-2xl mr-4"><i class="fa-solid fa-envelope"></i></div>
                    <div>
                        <h4 class="font-bold text-[#1E293B]">Email</h4>
                        <p class="text-gray-600 text-sm mt-1">karyantarasolution@gmail.com</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-start">
                    <div class="text-amber-500 text-2xl mr-4"><i class="fa-brands fa-whatsapp"></i></div>
                    <div>
                        <h4 class="font-bold text-[#1E293B]">WhatsApp</h4>
                        <p class="text-gray-600 text-sm mt-1">+62 812 3456 7890</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-start">
                    <div class="text-amber-500 text-2xl mr-4"><i class="fa-solid fa-location-dot"></i></div>
                    <div>
                        <h4 class="font-bold text-[#1E293B]">Alamat</h4>
                        <p class="text-gray-600 text-sm mt-1">Banjarmasin, Kalimantan Selatan, Indonesia</p>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-2xl font-bold text-[#1E293B] mb-6">Kirim Pesan</h3>
                <form class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text"
                                class="w-full border-gray-300 rounded-md focus:border-[#1E293B] focus:ring-[#1E293B]"
                                placeholder="John Doe">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                            <input type="email"
                                class="w-full border-gray-300 rounded-md focus:border-[#1E293B] focus:ring-[#1E293B]"
                                placeholder="john@example.com">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Subjek</label>
                        <input type="text"
                            class="w-full border-gray-300 rounded-md focus:border-[#1E293B] focus:ring-[#1E293B]"
                            placeholder="Tanya Jasa Pembuatan Website">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pesan</label>
                        <textarea rows="4" class="w-full border-gray-300 rounded-md focus:border-[#1E293B] focus:ring-[#1E293B]"
                            placeholder="Tuliskan detail kebutuhan Anda..."></textarea>
                    </div>
                    <button type="button"
                        class="w-full bg-[#1E293B] text-white font-semibold py-3 rounded-md hover:bg-opacity-90 transition">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-public-layout>
