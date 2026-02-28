<div class="text-center mb-16">
    <span class="text-sm font-bold text-amber-500 tracking-wider uppercase mb-2 block">
        Perjanjian Kerjasama
    </span>
    <h1 class="text-4xl md:text-5xl font-extrabold text-[#1E293B]">Syarat & Ketentuan</h1>
    <div class="w-24 h-1.5 bg-gradient-to-r from-amber-400 to-amber-600 mx-auto mt-6 rounded-full mb-6"></div>
    <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
        Demi kenyamanan dan kelancaran proyek bersama, harap pelajari aturan kerja <b>Karyantara Solution</b> di bawah ini.
        <br>
        <div class="flex items-center justify-center gap-4 mt-4 text-sm text-gray-400 font-medium">
            <span>
                <i class="fa-regular fa-clock mr-1 text-amber-500"></i>
                Terakhir Diperbarui: {{ now()->locale('id')->translatedFormat('d F Y') }}
            </span>
            <span class="border-l border-gray-300 pl-4" title="Total Pengunjung Unik">
                <i class="fa-regular fa-eye mr-1 text-amber-500"></i>
                Dilihat: {{ number_format($viewCount, 0, ',', '.') }} kali
            </span>
        </div>
    </p>
</div>