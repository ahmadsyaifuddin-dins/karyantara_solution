<div x-data="{ openModalRevisi: false }">

    <div x-show="activeTab === 'mahasiswa'" style="display: none;" x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        class="grid md:grid-cols-2 gap-8">

        <div
            class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all hover:-translate-y-1 group">
            <div
                class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-amber-100 transition-colors">
                <i class="fa-solid fa-wallet text-2xl text-amber-500"></i>
            </div>
            <h3 class="text-xl font-bold text-[#1E293B] mb-4">1. Pembayaran Skripsi</h3>
            <ul class="space-y-3 text-gray-600 text-sm leading-relaxed">
                <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                    <span><strong class="text-[#1E293B]">DP Wajib:</strong> Pengerjaan dimulai setelah pembayaran DP
                        sebesar 25% atau 50% di awal.</span>
                </li>
                <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                    <span><strong class="text-[#1E293B]">Pelunasan:</strong> Sisa 50% atau Sisa 75% WAJIB dilunasi saat
                        program didemokan (video/share screen) dan SEBELUM source code dikirimkan kepada
                        mahasiswa.</span>
                </li>
                <li class="flex items-start"><i class="fa-solid fa-triangle-exclamation text-amber-500 mt-1 mr-3"></i>
                    <span><strong class="text-[#1E293B]">DP Hangus (Non-Refundable):</strong> Jika klien membatalkan
                        sepihak, DP tidak dapat dikembalikan, <span class="text-red-600 font-bold"><code>sebagai
                                kompensasi waktu pengerjaan</code></span>.</span>
                </li>
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
                    <span><strong class="text-[#1E293B]">Fix Alur di Awal:</strong> Pastikan konsep Aplikasi atau judul
                        skripsi sudah FIX yang di-ACC dosen sebelum kami koding. Pastikan agar tidak kerja dua kali dan
                        hasilnya 100% sesuai ekspektasimu</span>
                </li>
                <li class="flex items-start"><i class="fa-solid fa-xmark text-red-500 mt-1 mr-3 text-lg"></i>
                    <span><strong class="text-red-500">Ganti Judul Total:</strong> Jika di tengah jalan dosen meminta
                        ganti judul/konsep aplikasi secara total, hal tersebut terhitung sebagai <strong
                            class="text-[#1E293B]">Proyek Baru / Biaya Baru</strong>.</span>
                </li>
                <li class="flex items-start">
                    <i class="fa-solid fa-file-invoice-dollar text-blue-500 mt-1 mr-3"></i>
                    <div class="flex-1">
                        <span>Revisi minor (tampilan) <span class="font-bold text-[#1E293B]"> gratis 5x </span>.
                            Penambahan fitur ringan baru kena *charge/kopi* tambahan.</span>

                        <button @click="openModalRevisi = true" type="button"
                            class="mt-2 flex items-center gap-1.5 text-[11px] font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-md transition-colors border border-blue-100">
                            <i class="fa-solid fa-circle-info"></i> Lihat Panduan & Contoh Revisi
                        </button>
                    </div>
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
                    <span><strong class="text-[#1E293B]">Privasi Terjamin 100%:</strong> Kerahasiaan identitas
                        mahasiswa, data penelitian, dan source code terjamin sepenuhnya.</span>
                </li>
                <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                    <span><strong class="text-[#1E293B]">Bukan Portofolio Publik:</strong> Kami TIDAK AKAN
                        mempublikasikan hasil kodingan skripsi klien sebagai portofolio publik Karyantara tanpa izin
                        eksplisit (anonim).</span>
                </li>
                <li class="flex items-start"><i class="fa-solid fa-shield-halved text-blue-500 mt-1 mr-3"></i>
                    <span><strong class="text-[#1E293B]">Anti Jual Ulang (Eksklusif):</strong> Kami menjamin aplikasi
                        Anda <span class="text-red-600 font-bold">TIDAK AKAN dijual ulang</span> atau didaur ulang untuk
                        mahasiswa lain. Konsep dan <em>source code</em> adalah hak milik eksklusif Anda.</span>
                </li>
            </ul>
        </div>

        <div
            class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all hover:-translate-y-1 group">
            <div
                class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-purple-100 transition-colors">
                <i class="fa-solid fa-person-chalkboard text-2xl text-purple-500"></i>
            </div>
            <h3 class="text-xl font-bold text-[#1E293B] mb-4">4. Serah Terima & Batasan</h3>
            <ul class="space-y-3 text-gray-600 text-sm leading-relaxed">
                <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                    <span><strong class="text-[#1E293B]">Serah Terima:</strong> Mahasiswa akan mendapatkan Source Code
                        Full, Database, dan dibantu instalasi ke laptop mahasiswa via TeamViewer/AnyDesk.</span>
                </li>
                <li class="flex items-start"><i class="fa-solid fa-scale-balanced text-amber-500 mt-1 mr-3"></i>
                    <span><strong class="text-[#1E293B]">Batas Tanggung Jawab:</strong> Kami membuat aplikasi sesuai
                        dengan MoU/alur di awal. <span class="text-red-600 font-bold">Kami tidak bertanggung jawab atas
                            revisi dari dosen yang sifatnya memaksakan logika/fitur baru yang sangat kompleks </span> di
                        luar kesepakatan awal.</span>
                </li>
                <li class="flex items-start"><i class="fa-solid fa-code-pull-request text-blue-500 mt-1 mr-3"></i>
                    <span><strong class="text-[#1E293B]">Ketentuan Aplikasi Pihak Ketiga:</strong> Untuk pembuatan
                        naskah skripsi menggunakan <em>source code</em> bawaan klien (dari GitHub/luar), kami wajib
                        meninjau
                        kodenya terlebih dahulu. Kami <span class="text-red-600 font-bold">berhak menolak pengerjaan
                            naskah skripsi</span> apabila logika aplikasi dinilai terlalu kompleks, tidak terstruktur,
                        atau di
                        luar standar teknis kami.</span>
                </li>
            </ul>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="openModalRevisi" style="display: none;" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">

            <div @click.outside="openModalRevisi = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">

                <div class="bg-slate-50 border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-base font-bold text-[#1E293B] flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-blue-500"></i> Panduan Kategori Revisi
                    </h3>
                    <button @click="openModalRevisi = false"
                        class="text-gray-400 hover:text-red-500 transition-colors w-8 h-8 flex items-center justify-center rounded-full hover:bg-red-50">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto">
                    <div class="bg-green-50 p-4 rounded-2xl border border-green-100">
                        <h4 class="font-bold text-green-800 mb-2 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-check-circle"></i> Revisi Minor (Gratis 5x)
                        </h4>
                        <p class="text-xs text-green-700 leading-relaxed mb-2">Perubahan kecil pada antarmuka pengguna
                            (UI) yang tidak merubah alur program maupun struktur database.</p>
                        <ol class="text-xs text-green-800 font-medium list-decimal list-inside space-y-1">
                            <li>Mengubah warna latar/tombol</li>
                            <li>Memperbaiki *typo* (salah ketik)</li>
                            <li>Mengganti logo aplikasi</li>
                            <li>Menggeser posisi tabel atau tombol</li>
                        </ol>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100">
                        <h4 class="font-bold text-blue-800 mb-2 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-mug-hot"></i> Fitur Ringan (Charge Kopi)
                        </h4>
                        <p class="text-xs text-blue-700 leading-relaxed mb-2">Penambahan fungsionalitas kecil yang
                            memerlukan sedikit modifikasi kodingan/database.</p>
                        <ol class="text-xs text-blue-800 font-medium list-decimal list-inside space-y-1">
                            <li>Menambah 1 kolom *inputan* baru di form</li>
                            <li>Menambah filter pencarian sederhana</li>
                            <li>Menambah tombol Ekspor PDF/Excel</li>
                        </ol>
                    </div>

                    <div class="bg-red-50 p-4 rounded-2xl border border-red-100">
                        <h4 class="font-bold text-red-800 mb-2 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation"></i> Revisi Mayor (Proyek/Biaya Baru)
                        </h4>
                        <p class="text-xs text-red-700 leading-relaxed mb-2">Perombakan besar yang mengubah struktur
                            dasar, relasi database, atau inti algoritma.</p>
                        <ol class="text-xs text-red-800 font-medium list-decimal list-inside space-y-1">
                            <li>Ganti metode Algoritma (Misal: dari AHP ke SAW)</li>
                            <li>Menambah hak akses user baru (Misal: tambah *role* Kepala Cabang)</li>
                            <li>Merombak total alur bisnis aplikasi</li>
                        </ol>
                    </div>
                </div>

                <div class="bg-slate-50 border-t border-gray-100 px-6 py-4 text-center">
                    <button @click="openModalRevisi = false"
                        class="bg-[#1E293B] text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-slate-700 transition-colors w-full sm:w-auto shadow-md">
                        Saya Mengerti
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
