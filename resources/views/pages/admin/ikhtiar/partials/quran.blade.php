@php
    $quranQuotes = [
        [
            'surah' => 'QS. An-Nisa : 28',
            'ayat' => 'Manusia diciptakan dalam keadaan lemah.',
            'icon' => 'fa-seedling',
            'desc' =>
                'Jangan sombong dengan kepintaran atau logika. Kita butuh pertolongan-Nya dalam setiap problem solving.',
        ],
        [
            'surah' => 'QS. Al-Infitar : 6',
            'ayat' => 'Wahai manusia, apakah yang telah memperdayakan kamu terhadap Tuhanmu...',
            'icon' => 'fa-mask',
            'desc' => 'Dunia digital, jabatan, dan uang mudah membuat kita terperdaya. Tetaplah membumi.',
        ],
        [
            'surah' => 'QS. Al-Isra : 11',
            'ayat' => 'Dan manusia itu sifatnya tergesa-gesa.',
            'icon' => 'fa-person-running',
            'desc' => 'Ingin cepat rilis, cepat beres. Sabar, periksa kembali semuanya dengan teliti agar minim bug.',
        ],
        [
            'surah' => 'QS. At-Takatsur : 1',
            'ayat' => 'Bermegah-megahan telah melalaikan kamu.',
            'icon' => 'fa-hourglass-half',
            'desc' =>
                'Fokus pada memberi solusi (Solution), bukan sekadar mengejar angka dan melalaikan kewajiban utama.',
        ],
        [
            'surah' => 'QS. Az-Zumar : 8',
            'ayat' => 'Dan apabila manusia ditimpa bencana, dia memohon kepada Tuhannya... kemudian dia pelupa.',
            'icon' => 'fa-brain',
            'desc' =>
                'Saat server error kita berdoa kuat, saat sukses kita lupa bersyukur. Jangan jadi kacang lupa kulitnya.',
        ],
        [
            'surah' => 'QS. Al-Hadid : 20',
            'ayat' => 'Kehidupan dunia itu tidak lain hanyalah kesenangan yang memperdaya.',
            'icon' => 'fa-globe',
            'desc' =>
                'Proyek besar, uang banyak, dan jabatan tinggi itu hanyalah ilusi (cache) sementara. Jangan sampai ia merusak database akheratmu.',
        ],
        [
            'surah' => 'QS. Ar-Ra\'d : 28',
            'ayat' => 'Ingatlah, hanya dengan mengingat Allah-lah hati menjadi tenteram.',
            'icon' => 'fa-heart-pulse',
            'desc' =>
                'Saat kepala mau pecah karena error yang tak kunjung *solved* atau *client* yang menekan, menepilah. Bukan Google atau StackOverflow yang menenangkan hati, tapi mengingat-Nya.',
        ],
        [
            'surah' => 'QS. Al-Baqarah : 286',
            'ayat' => 'Allah tidak membebani seseorang melainkan sesuai dengan kesanggupannya.',
            'icon' => 'fa-dumbbell',
            'desc' =>
                'Merasa beban kerjaan ini terlalu berat? Terlalu mumet? Percayalah, Tuhan tahu kamu adalah developer/manusia dengan kapasitas yang sanggup melewatinya.',
        ],
        [
            'surah' => 'QS. Al-Insyirah : 5-6',
            'ayat' =>
                'Maka sesungguhnya bersama kesulitan ada kemudahan. Sesungguhnya bersama kesulitan ada kemudahan.',
            'icon' => 'fa-door-open',
            'desc' =>
                'Ditegaskan dua kali. Setiap kerumitan logika sistem yang sedang kamu hadapi hari ini, pasti ada jalan keluarnya di depan mata. Teruslah melangkah.',
        ],
        [
            'surah' => 'QS. Al-Ankabut : 64',
            'ayat' => 'Dan tiadalah kehidupan dunia ini melainkan senda gurau dan main-main...',
            'icon' => 'fa-chess-knight',
            'desc' =>
                'Jangan terlalu stres jika hari ini rencanamu gagal atau aplikasimu *down*. Ini cuma dunia. Jangan masukkan ke dalam hati sampai merusak mentalmu.',
        ],
    ];
@endphp

<div>
    <div class="flex items-center gap-3 mb-6 mt-4">
        <i class="fa-solid fa-book-open text-amber-500 text-xl"></i>
        <h3 class="text-xl font-bold text-[#1E293B]">Sifat Asli Manusia</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($quranQuotes as $quote)
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 transition-all duration-300 hover:shadow-md border-b-4 border-b-transparent hover:border-b-amber-500 group">
                <div
                    class="w-12 h-12 rounded-lg bg-gray-50 flex items-center justify-center mb-4 group-hover:bg-amber-50 transition-colors">
                    <i
                        class="fa-solid {{ $quote['icon'] }} text-xl text-[#1E293B] group-hover:text-amber-500 transition-colors"></i>
                </div>
                <h4 class="font-bold text-sm text-amber-500 mb-2">{{ $quote['surah'] }}</h4>
                <blockquote class="text-[#1E293B] font-semibold text-lg mb-3 leading-snug">
                    "{{ $quote['ayat'] }}"
                </blockquote>
                <p class="text-gray-500 text-sm leading-relaxed">
                    {{ $quote['desc'] }}
                </p>
            </div>
        @endforeach
    </div>
</div>
