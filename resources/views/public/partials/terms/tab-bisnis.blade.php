<div x-show="activeTab === 'bisnis'" x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
    class="grid md:grid-cols-2 gap-8">

    <div
        class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all hover:-translate-y-1 group">
        <div
            class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-amber-100 transition-colors">
            <i class="fa-solid fa-wallet text-2xl text-amber-500"></i>
        </div>
        <h3 class="text-xl font-bold text-[#1E293B] mb-4">1. Sistem Pembayaran</h3>
        <ul class="space-y-3 text-gray-600 text-sm leading-relaxed">
            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                <span><strong class="text-[#1E293B]">DP Wajib:</strong> Pengerjaan baru akan dimulai setelah klien
                    melakukan pembayaran Down Payment (DP) sebesar 50% di awal.</span>
            </li>
            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                <span><strong class="text-[#1E293B]">Pelunasan:</strong> Sisa 50% WAJIB dilunasi saat progress selesai
                    ditunjukkan (via demo video/share screen) dan SEBELUM source code dikirimkan.</span>
            </li>
            <li class="flex items-start"><i class="fa-solid fa-triangle-exclamation text-amber-500 mt-1 mr-3"></i>
                <span><strong class="text-[#1E293B]">Non-Refundable:</strong> Jika terjadi pembatalan sepihak dari klien
                    saat proyek berjalan, DP tidak dapat dikembalikan (hangus) sebagai kompensasi waktu tim kami.</span>
            </li>
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
                <span><strong class="text-[#1E293B]">Batas Revisi Minor:</strong> Kami memberikan kesempatan revisi
                    minor maksimal 5x (Contoh: ganti warna, geser letak tombol, ubah teks kalimat).</span>
            </li>
            <li class="flex items-start"><i class="fa-solid fa-file-invoice-dollar text-blue-500 mt-1 mr-3"></i>
                <span><strong class="text-[#1E293B]">Revisi Mayor (Berdampak Biaya):</strong> Perubahan logika alur,
                    penambahan fitur baru di luar kesepakatan awal, atau rombak total desain akan dikenakan biaya
                    tambahan sesuai tingkat kesulitan.</span>
            </li>
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
                <span><strong class="text-[#1E293B]">Penyediaan Data:</strong> Klien wajib menyediakan materi (teks,
                    logo, gambar produk) yang dibutuhkan. Keterlambatan pengiriman data akan mempengaruhi estimasi waktu
                    selesai.</span>
            </li>
            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                <span><strong class="text-[#1E293B]">Estimasi Waktu:</strong> Waktu pengerjaan disepakati di awal
                    kontrak. Kami akan memberikan update progres secara berkala kepada klien.</span>
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
                <span><strong class="text-[#1E293B]">File Akhir:</strong> Klien berhak mendapatkan Source Code Full,
                    Database, dan Panduan Instalasi (jika diminta) setelah pelunasan 100%.</span>
            </li>
            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mt-1 mr-3"></i>
                <span><strong class="text-[#1E293B]">Hak Cipta:</strong> Produk akhir sepenuhnya menjadi milik klien
                    kecuali disepakati lain dalam kontrak (seperti lisensi bulanan/tahunan).</span>
            </li>
        </ul>
    </div>
</div>
