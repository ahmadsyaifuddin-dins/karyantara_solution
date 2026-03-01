<x-public-layout title="Kontak Kami - Karyantara Solution">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative overflow-hidden">

        <div
            class="absolute top-20 right-10 w-72 h-72 bg-amber-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob pointer-events-none">
        </div>
        <div
            class="absolute top-40 left-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000 pointer-events-none">
        </div>

        <div class="text-center mb-16 relative z-10">
            <span class="text-sm font-bold text-amber-500 tracking-wider uppercase mb-2 block">Mari Terhubung</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#1E293B]">Hubungi Kami</h1>
            <div class="w-24 h-1.5 bg-gradient-to-r from-amber-400 to-amber-600 mx-auto mt-6 rounded-full mb-6"></div>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
                Punya ide proyek brilian atau sekadar pertanyaan seputar layanan kami? Jangan ragu untuk menghubungi tim
                Karyantara.
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto relative z-10">

            <div class="lg:col-span-1 space-y-4">

                <div
                    class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 hover:-translate-y-1 transition-transform duration-300">
                    <h3 class="text-xl font-bold text-[#1E293B] mb-6">Informasi Kontak</h3>

                    <div class="space-y-6">
                        <a href="mailto:karyantarasolution@gmail.com" class="flex items-start group">
                            <div
                                class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 text-xl group-hover:bg-amber-500 group-hover:text-white transition-colors shrink-0">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-bold text-[#1E293B]">Email</h4>
                                <p class="text-gray-500 text-sm mt-0.5 group-hover:text-amber-600 transition-colors">
                                    karyantarasolution@gmail.com</p>
                            </div>
                        </a>

                        <a href="https://wa.me/6285124237625" target="_blank" class="flex items-start group">
                            <div
                                class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-500 text-xl group-hover:bg-green-500 group-hover:text-white transition-colors shrink-0">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-bold text-[#1E293B]">WhatsApp Admin</h4>
                                <p class="text-gray-500 text-sm mt-0.5 group-hover:text-green-600 transition-colors">+62
                                    851-2423-7625</p>
                            </div>
                        </a>

                        <div class="flex items-start group cursor-default">
                            <div
                                class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 text-xl group-hover:bg-blue-500 group-hover:text-white transition-colors shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-bold text-[#1E293B]">Kantor Pusat</h4>
                                <p class="text-gray-500 text-sm mt-0.5 leading-relaxed">Banjarmasin, Kalimantan Selatan,
                                    Indonesia</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#1E293B] p-8 rounded-3xl shadow-lg border border-gray-800 text-center">
                    <h4 class="text-white font-bold mb-4">Ikuti Perjalanan Kami</h4>
                    <div class="flex justify-center gap-4">
                        <a href="https://instagram.com/karyantarasolution" target="_blank"
                            class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-gradient-to-tr hover:from-yellow-400 hover:via-pink-500 hover:to-purple-600 transition-all hover:scale-110 shadow-sm">
                            <i class="fa-brands fa-instagram text-xl"></i>
                        </a>
                        <a href="https://threads.net/@karyantarasolution" target="_blank"
                            class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-black transition-all hover:scale-110 shadow-sm">
                            <i class="fa-brands fa-threads text-xl"></i>
                        </a>
                        <a href="https://github.com/karyantarasolution" target="_blank"
                            class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-gray-700 transition-all hover:scale-110 shadow-sm">
                            <i class="fa-brands fa-github text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white p-8 md:p-10 rounded-3xl shadow-xl border border-gray-100"
                x-data="whatsappForm()">

                <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
                    <h3 class="text-2xl font-extrabold text-[#1E293B]">Kirim Pesan Cepat</h3>
                    <i class="fa-brands fa-whatsapp text-4xl text-green-500 opacity-20"></i>
                </div>

                <form @submit.prevent="sendToWhatsApp" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-[#1E293B] mb-2">Nama Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" x-model="form.name" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all"
                                placeholder="Contoh: John Doe">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#1E293B] mb-2">Alamat Email <span
                                    class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="email" x-model="form.email"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all"
                                placeholder="john@example.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#1E293B] mb-2">Subjek Proyek <span
                                class="text-red-500">*</span></label>
                        <input type="text" x-model="form.subject" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all"
                            placeholder="Contoh: Pembuatan Website E-Commerce">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#1E293B] mb-2">Detail Pesan / Kebutuhan <span
                                class="text-red-500">*</span></label>
                        <textarea rows="5" x-model="form.message" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all resize-none"
                            placeholder="Halo Tim Karyantara, saya tertarik untuk membuat..."></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#1E293B] text-white font-bold py-4 rounded-xl hover:bg-gray-800 focus:ring-4 focus:ring-amber-500/50 transition-all transform hover:-translate-y-1 shadow-lg flex justify-center items-center gap-3 text-lg">
                        <i class="fa-brands fa-whatsapp text-2xl text-green-400"></i> Kirim via WhatsApp
                    </button>

                    <p class="text-center text-xs text-gray-500 mt-4">
                        <i class="fa-solid fa-shield-halved mr-1 text-amber-500"></i> Anda akan diarahkan ke aplikasi
                        WhatsApp dengan format pesan yang sudah rapi.
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('whatsappForm', () => ({
                form: {
                    name: '',
                    email: '',
                    subject: '',
                    message: ''
                },
                adminPhone: '6285124237625', // Ganti awalan 0 dengan 62 tanpa spasi/tanda hubung

                sendToWhatsApp() {
                    // Merakit template teks pesan WA
                    let waText = `Halo Tim Karyantara Solution!`;
                    waText += `Saya tertarik untuk berdiskusi lebih lanjut.\n\n`;
                    waText += `*Nama:* ${this.form.name}\n`;
                    if (this.form.email) {
                        waText += `*Email:* ${this.form.email}\n`;
                    }
                    waText += `*Subjek:* ${this.form.subject}\n\n`;
                    waText += `*Pesan:*\n${this.form.message}\n\n`;
                    waText += `Mohon info lebih lanjut. Terima kasih!`;

                    // Encode teks agar aman dipakai di URL
                    const encodedText = encodeURIComponent(waText);

                    // Buat link wa.me
                    const waLink = `https://wa.me/${this.adminPhone}?text=${encodedText}`;

                    // Buka WhatsApp di tab baru
                    window.open(waLink, '_blank');

                    // Opsional: Reset form setelah dikirim
                    // this.form.name = ''; this.form.email = ''; this.form.subject = ''; this.form.message = '';
                }
            }))
        })
    </script>
</x-public-layout>
