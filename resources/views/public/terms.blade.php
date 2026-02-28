<x-public-layout title="Syarat & Ketentuan - Karyantara Solution">

    <div class="relative bg-slate-50 pt-24 pb-32 overflow-hidden min-h-screen">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-white to-transparent pointer-events-none">
        </div>
        <div
            class="absolute top-20 right-10 w-96 h-96 bg-amber-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="text-center mb-16">
                <span class="text-sm font-bold text-amber-500 tracking-wider uppercase mb-2 block">Perjanjian
                    Kerjasama</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#1E293B]">Syarat & Ketentuan</h1>
                <div class="w-24 h-1.5 bg-gradient-to-r from-amber-400 to-amber-600 mx-auto mt-6 rounded-full mb-6">
                </div>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
                    Demi kenyamanan dan kelancaran proyek bersama, harap pelajari aturan kerja <b>Karyantara
                        Solution</b> di bawah ini.
                    <br><span class="text-sm text-gray-400 mt-2 inline-block"><i class="fa-regular fa-clock mr-1"></i>
                        Pembaruan Terakhir: {{ now()->locale('id')->translatedFormat('d F Y') }}</span>
                </p>
            </div>

            <div x-data="{ activeTab: 'bisnis' }" class="max-w-6xl mx-auto">

                <div class="flex justify-center mb-12">
                    <div
                        class="inline-flex flex-col sm:flex-row bg-gray-200/50 rounded-2xl p-1.5 shadow-inner gap-1 sm:gap-0">
                        <button @click="activeTab = 'bisnis'"
                            :class="activeTab === 'bisnis' ? 'bg-white shadow-md text-[#1E293B] font-extrabold scale-100' :
                                'text-gray-500 hover:text-[#1E293B] font-semibold hover:bg-white/50 scale-95'"
                            class="px-8 py-4 rounded-xl transition-all duration-300 flex items-center justify-center gap-3 w-full sm:w-auto">
                            <i class="fa-solid fa-building text-lg"
                                :class="activeTab === 'bisnis' ? 'text-amber-500' : ''"></i>
                            Klien Bisnis / Umum
                        </button>

                        <button @click="activeTab = 'mahasiswa'"
                            :class="activeTab === 'mahasiswa' ? 'bg-white shadow-md text-[#1E293B] font-extrabold scale-100' :
                                'text-gray-500 hover:text-[#1E293B] font-semibold hover:bg-white/50 scale-95'"
                            class="px-8 py-4 rounded-xl transition-all duration-300 flex items-center justify-center gap-3 w-full sm:w-auto">
                            <i class="fa-solid fa-graduation-cap text-lg"
                                :class="activeTab === 'mahasiswa' ? 'text-amber-500' : ''"></i>
                            Klien Mahasiswa / Skripsi
                        </button>
                    </div>
                </div>

                <div x-show="activeTab === 'bisnis'" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0" class="grid md:grid-cols-2 gap-8">

                    <div
                        class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all hover:-translate-y-1 group">
                        <div
                            class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-amber-100 transition-colors">
                            <i class="fa-solid fa-wallet text-2xl text-amber-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#1E293B] mb-4">1. Sistem Pembayaran</h3>
                        <ul class="space-y-3 text-gray-600 text-sm leading-relaxed">
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">DP Wajib:</strong> Pengerjaan baru akan dimulai
                                    setelah klien melakukan pembayaran Down Payment (DP) sebesar 50% di awal.</span>
                            </li>
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">Pelunasan:</strong> Sisa 50% WAJIB dilunasi saat
                                    progress selesai ditunjukkan (via demo video/share screen) dan SEBELUM source code
                                    dikirimkan.</span>
                            </li>
                            <li class="flex items-start"><i
                                    class="fa-solid fa-triangle-exclamation text-amber-500 mt-1 mr-3"></i> <span><strong
                                        class="text-[#1E293B]">Non-Refundable:</strong> Jika terjadi pembatalan sepihak
                                    dari klien saat proyek berjalan, DP tidak dapat dikembalikan (hangus) sebagai
                                    kompensasi waktu tim kami.</span></li>
                        </ul>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all hover:-translate-y-1 group">
                        <div
                            class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-blue-100 transition-colors">
                            <i class="fa-solid fa-pen-ruler text-2xl text-blue-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#1E293B] mb-4">2. Revisi & Perubahan Fitur</h3>
                        <ul class="space-y-3 text-gray-600 text-sm leading-relaxed">
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">Batas Revisi Minor:</strong> Kami memberikan
                                    kesempatan revisi minor maksimal 5x (Contoh: ganti warna, geser letak tombol, ubah
                                    teks kalimat).</span>
                            </li>
                            <li class="flex items-start"><i
                                    class="fa-solid fa-file-invoice-dollar text-blue-500 mt-1 mr-3"></i> <span><strong
                                        class="text-[#1E293B]">Revisi Mayor (Berdampak Biaya):</strong> Perubahan logika
                                    alur, penambahan fitur baru di luar kesepakatan awal, atau rombak total desain akan
                                    dikenakan biaya tambahan sesuai tingkat kesulitan.</span></li>
                        </ul>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all hover:-translate-y-1 group">
                        <div
                            class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-emerald-100 transition-colors">
                            <i class="fa-solid fa-laptop-code text-2xl text-emerald-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#1E293B] mb-4">3. Pengerjaan & Kewajiban Klien</h3>
                        <ul class="space-y-3 text-gray-600 text-sm leading-relaxed">
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">Penyediaan Data:</strong> Klien wajib menyediakan
                                    materi (teks, logo, gambar produk) yang dibutuhkan. Keterlambatan pengiriman data
                                    akan mempengaruhi estimasi waktu selesai.</span>
                            </li>
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">Estimasi Waktu:</strong> Waktu pengerjaan
                                    disepakati di awal kontrak. Kami akan memberikan update progres secara berkala
                                    kepada klien.</span>
                            </li>
                        </ul>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all hover:-translate-y-1 group">
                        <div
                            class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-purple-100 transition-colors">
                            <i class="fa-solid fa-handshake text-2xl text-purple-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#1E293B] mb-4">4. Serah Terima Proyek</h3>
                        <ul class="space-y-3 text-gray-600 text-sm leading-relaxed">
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">File Akhir:</strong> Klien berhak mendapatkan
                                    Source Code Full, Database, dan Panduan Instalasi (jika diminta) setelah pelunasan
                                    100%.</span>
                            </li>
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">Hak Cipta:</strong> Produk akhir sepenuhnya menjadi
                                    milik klien kecuali disepakati lain dalam kontrak (seperti lisensi
                                    bulanan/tahunan).</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div x-show="activeTab === 'mahasiswa'" style="display: none;"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0" class="grid md:grid-cols-2 gap-8">

                    <div
                        class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all hover:-translate-y-1 group">
                        <div
                            class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-amber-100 transition-colors">
                            <i class="fa-solid fa-wallet text-2xl text-amber-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#1E293B] mb-4">1. Pembayaran Skripsi</h3>
                        <ul class="space-y-3 text-gray-600 text-sm leading-relaxed">
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">DP Wajib:</strong> Pengerjaan dimulai setelah
                                    pembayaran DP sebesar 50% di awal.</span>
                            </li>
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">Pelunasan:</strong> Sisa 50% WAJIB dilunasi saat
                                    program didemokan (video/share screen) dan SEBELUM source code dikirimkan kepada
                                    mahasiswa.</span>
                            </li>
                            <li class="flex items-start"><i
                                    class="fa-solid fa-triangle-exclamation text-amber-500 mt-1 mr-3"></i> <span><strong
                                        class="text-[#1E293B]">DP Hangus:</strong> Jika klien membatalkan sepihak, DP
                                    tidak dapat dikembalikan.</span></li>
                        </ul>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-amber-200 transition-all hover:-translate-y-1 group relative overflow-hidden">
                        <div
                            class="absolute -right-6 -top-6 text-amber-50 opacity-50 text-9xl pointer-events-none group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div
                            class="w-14 h-14 bg-red-50 rounded-xl flex items-center justify-center mb-6 relative z-10 group-hover:bg-red-100 transition-colors">
                            <i class="fa-solid fa-rotate-left text-2xl text-red-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#1E293B] mb-4 relative z-10">2. Revisi & Ganti Judul</h3>
                        <ul class="space-y-3 text-gray-600 text-sm leading-relaxed relative z-10">
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">Fix di Awal:</strong> Pastikan konsep atau judul
                                    skripsi sudah FIX yang di-ACC dosen sebelum kami koding.</span>
                            </li>
                            <li class="flex items-start"><i
                                    class="fa-solid fa-xmark text-red-500 mt-1 mr-3 text-lg"></i> <span><strong
                                        class="text-red-500">Ganti Judul Total:</strong> Jika di tengah jalan dosen
                                    meminta ganti judul/konsep aplikasi secara total, hal tersebut terhitung sebagai
                                    <strong class="text-[#1E293B]">Proyek Baru / Biaya Baru</strong>.</span></li>
                            <li class="flex items-start"><i
                                    class="fa-solid fa-file-invoice-dollar text-blue-500 mt-1 mr-3"></i> <span>Revisi
                                    minor (tampilan) <b> gratis 5x </b>. Penambahan fitur baru kena *charge*
                                    tambahan.</span>
                            </li>
                        </ul>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all hover:-translate-y-1 group">
                        <div
                            class="w-14 h-14 bg-slate-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-slate-200 transition-colors">
                            <i class="fa-solid fa-user-shield text-2xl text-[#1E293B]"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#1E293B] mb-4">3. Keamanan & Privasi Data</h3>
                        <ul class="space-y-3 text-gray-600 text-sm leading-relaxed">
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">Privasi Terjamin 100%:</strong> Kerahasiaan
                                    identitas mahasiswa, data penelitian, dan source code terjamin sepenuhnya.</span>
                            </li>
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">Bukan Portofolio Publik:</strong> Kami TIDAK AKAN
                                    mempublikasikan hasil kodingan skripsi klien sebagai portofolio publik Karyantara
                                    tanpa izin eksplisit (anonim).</span>
                            </li>
                        </ul>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all hover:-translate-y-1 group">
                        <div
                            class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-purple-100 transition-colors">
                            <i class="fa-solid fa-person-chalkboard text-2xl text-purple-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#1E293B] mb-4">4. Serah Terima & Dosen</h3>
                        <ul class="space-y-3 text-gray-600 text-sm leading-relaxed">
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                                <span><strong class="text-[#1E293B]">Serah Terima:</strong> Mahasiswa akan mendapatkan
                                    Source Code Full, Database, dan dibantu instalasi ke laptop mahasiswa via
                                    TeamViewer/AnyDesk.</span>
                            </li>
                            <li class="flex items-start"><i
                                    class="fa-solid fa-scale-balanced text-amber-500 mt-1 mr-3"></i> <span><strong
                                        class="text-[#1E293B]">Batas Tanggung Jawab:</strong> Kami membuat aplikasi
                                    sesuai dengan MoU/alur di awal. Kami tidak bertanggung jawab atas revisi dari dosen
                                    yang sifatnya memaksakan logika/fitur baru yang sangat kompleks di luar kesepakatan
                                    awal kita.</span></li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="max-w-4xl mx-auto mt-16 text-center border-t border-gray-200 pt-8">
                <p class="text-red-600 italic text-sm">Dengan membayar DP, Anda secara otomatis dianggap telah
                    membaca, memahami, dan menyetujui seluruh syarat & ketentuan Karyantara Solution di atas.</p>
            </div>

        </div>
    </div>
</x-public-layout>
