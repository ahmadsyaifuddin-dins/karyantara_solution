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
                <span><strong class="text-[#1E293B]">DP Wajib:</strong> Pengerjaan dimulai setelah pembayaran DP sebesar
                    50% di awal.</span>
            </li>
            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                <span><strong class="text-[#1E293B]">Pelunasan:</strong> Sisa 50% WAJIB dilunasi saat program didemokan
                    (video/share screen) dan SEBELUM source code dikirimkan kepada mahasiswa.</span>
            </li>
            <li class="flex items-start"><i class="fa-solid fa-triangle-exclamation text-amber-500 mt-1 mr-3"></i>
                <span><strong class="text-[#1E293B]">DP Hangus:</strong> Jika klien membatalkan sepihak, DP tidak dapat
                    dikembalikan.</span>
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
                <span><strong class="text-[#1E293B]">Fix di Awal:</strong> Pastikan konsep atau judul skripsi sudah FIX
                    yang di-ACC dosen sebelum kami koding. Pastikan agar tidak kerja dua
                    kali dan hasilnya 100% sesuai ekspektasimu</span>
            </li>
            <li class="flex items-start"><i class="fa-solid fa-xmark text-red-500 mt-1 mr-3 text-lg"></i>
                <span><strong class="text-red-500">Ganti Judul Total:</strong> Jika di tengah jalan dosen meminta ganti
                    judul/konsep aplikasi secara total, hal tersebut terhitung sebagai <strong
                        class="text-[#1E293B]">Proyek Baru / Biaya Baru</strong>.</span>
            </li>
            <li class="flex items-start"><i class="fa-solid fa-file-invoice-dollar text-blue-500 mt-1 mr-3"></i>
                <span>Revisi minor (tampilan) <b> gratis 5x </b>. Penambahan fitur baru kena *charge* tambahan.</span>
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
                <span><strong class="text-[#1E293B]">Privasi Terjamin 100%:</strong> Kerahasiaan identitas mahasiswa,
                    data penelitian, dan source code terjamin sepenuhnya.</span>
            </li>
            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                <span><strong class="text-[#1E293B]">Bukan Portofolio Publik:</strong> Kami TIDAK AKAN mempublikasikan
                    hasil kodingan skripsi klien sebagai portofolio publik Karyantara tanpa izin eksplisit
                    (anonim).</span>
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
                <span><strong class="text-[#1E293B]">Serah Terima:</strong> Mahasiswa akan mendapatkan Source Code Full,
                    Database, dan dibantu instalasi ke laptop mahasiswa via TeamViewer/AnyDesk.</span>
            </li>
            <li class="flex items-start"><i class="fa-solid fa-scale-balanced text-amber-500 mt-1 mr-3"></i>
                <span><strong class="text-[#1E293B]">Batas Tanggung Jawab:</strong> Kami membuat aplikasi sesuai dengan
                    MoU/alur di awal. Kami tidak bertanggung jawab atas revisi dari dosen yang sifatnya memaksakan
                    logika/fitur baru yang sangat kompleks di luar kesepakatan awal kita.</span>
            </li>
        </ul>
    </div>
</div>
