<x-public-layout :title="$portfolio->title . ' - Portofolio Karyantara Solution'">

    <div class="bg-[#1E293B] py-16 lg:py-24 relative overflow-hidden">
        <div
            class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-blue-500 rounded-full blur-[120px] opacity-20 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span
                class="inline-block py-1 px-3 rounded-full bg-amber-500/20 text-amber-400 text-sm font-black tracking-wider uppercase mb-5 border border-amber-500/30">
                {{ $portfolio->category }}
            </span>

            <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white mb-8 leading-tight max-w-4xl mx-auto">
                {{ $portfolio->title }}</h1>

            <div class="flex flex-wrap items-center justify-center gap-6 mt-8">
                <span
                    class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-white/5 text-gray-300 border border-white/10 backdrop-blur-sm">
                    <i class="fa-solid fa-eye text-blue-400 mr-2"></i> {{ $viewCount }} Tayangan
                </span>

                @php $isLiked = session()->has('liked_portfolio_'.$portfolio->id); @endphp

                <button id="likeBtn" onclick="likePortfolio({{ $portfolio->id }})"
                    class="inline-flex items-center px-6 py-2 rounded-xl text-sm font-bold border backdrop-blur-sm transition-all duration-300 active:scale-90 shadow-lg {{ $isLiked ? 'bg-pink-500/20 border-pink-500/50 text-pink-400 cursor-default' : 'bg-white/5 border-white/10 text-white hover:bg-pink-500 hover:border-pink-500 hover:shadow-pink-500/40 group' }}"
                    {{ $isLiked ? 'disabled' : '' }}>
                    <i id="likeIcon"
                        class="fa-solid fa-heart mr-2 text-lg {{ $isLiked ? 'text-pink-500 animate-pulse' : 'text-gray-400 group-hover:text-white group-hover:scale-125 transition-transform' }}"></i>
                    <span id="likeText">{{ $isLiked ? 'Disukai' : 'Sukai Proyek' }}</span>
                    <span class="ml-2 pl-2 border-l border-current opacity-80"
                        id="likeCounter">{{ $likeCount }}</span>
                </button>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-4 md:gap-8 text-gray-300 text-sm mt-10">
                @if ($portfolio->developer)
                    <div class="flex items-center gap-2 bg-black/20 px-4 py-2 rounded-full">
                        <i class="fa-solid fa-code text-amber-500"></i>
                        <span>Developer: <strong class="text-white">{{ $portfolio->developer->name }}</strong></span>
                    </div>
                @endif
                @if ($portfolio->client_name)
                    <div class="flex items-center gap-2 bg-black/20 px-4 py-2 rounded-full">
                        <i class="fa-solid fa-user-tie text-amber-500"></i>
                        <span>Klien: <strong class="text-white">{{ $portfolio->client_name }}</strong></span>
                    </div>
                @endif
                <div class="flex items-center gap-2 bg-black/20 px-4 py-2 rounded-full">
                    <i class="fa-regular fa-calendar-check text-amber-500"></i>
                    <span>Selesai: <strong
                            class="text-white">{{ $portfolio->created_at->locale('id')->translatedFormat('F Y') }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 -mt-16 relative z-10">
        <div class="bg-white p-2 md:p-4 rounded-3xl shadow-xl mb-12 border border-gray-100 relative group">
            <img src="{{ asset('uploads/portfolios/' . $portfolio->thumbnail) }}" alt="{{ $portfolio->title }}"
                class="w-full h-auto max-h-[600px] object-cover rounded-2xl">
        </div>

        <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100 mb-12">
            <h2 class="text-2xl font-bold text-[#1E293B] mb-6 border-b border-gray-100 pb-4 flex items-center gap-3">
                <i class="fa-solid fa-circle-info text-amber-500"></i> Tentang Proyek
            </h2>
            <div class="prose max-w-none text-gray-600 leading-relaxed whitespace-pre-line text-lg font-medium">
                {!! nl2br(e($portfolio->description)) !!}
            </div>
            @if ($portfolio->project_url)
                <div class="mt-10 pt-8 border-t border-gray-100 text-center">
                    <a href="{{ $portfolio->project_url }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-3 bg-amber-500 text-[#1E293B] px-8 py-4 rounded-xl font-black hover:bg-amber-400 hover:-translate-y-1 transition shadow-lg shadow-amber-200">
                        <i class="fa-solid fa-globe text-xl"></i> Kunjungi Proyek Live
                    </a>
                </div>
            @endif
        </div>

        @if ($portfolio->images->count() > 1)
            <div class="mb-16">
                <h3 class="text-xl font-bold text-[#1E293B] mb-6 flex items-center gap-2">
                    <i class="fa-regular fa-images text-amber-500"></i> Galeri Proyek
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($portfolio->images->where('is_thumbnail', 0) as $img)
                        <div
                            class="bg-white p-2 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all hover:-translate-y-1 group">
                            <a href="{{ asset('uploads/portfolios/' . $img->image) }}" target="_blank"
                                class="block overflow-hidden rounded-xl">
                                <img src="{{ asset('uploads/portfolios/' . $img->image) }}"
                                    class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-10 text-center">
            <a href="{{ route('portfolio') }}"
                class="inline-flex items-center gap-2 text-gray-500 hover:text-[#1E293B] hover:bg-gray-100 px-6 py-3 rounded-full transition font-bold">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Portofolio
            </a>
        </div>
    </div>

    <script>
        function likePortfolio(id) {
            const btn = document.getElementById('likeBtn');
            const icon = document.getElementById('likeIcon');
            const counter = document.getElementById('likeCounter');
            const text = document.getElementById('likeText');

            // Mencegah spam klik berturut-turut
            if (btn.disabled) return;
            btn.disabled = true;

            fetch(`/portfolio/${id}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI Tombol
                        counter.innerText = data.likes;
                        text.innerText = 'Disukai';

                        // Ubah style tombol jadi Pink
                        btn.classList.remove('bg-white/5', 'border-white/10', 'text-white', 'hover:bg-pink-500');
                        btn.classList.add('bg-pink-500/20', 'border-pink-500/50', 'text-pink-400', 'cursor-default');

                        icon.classList.remove('text-gray-400');
                        icon.classList.add('text-pink-500', 'animate-pulse');
                    } else {
                        alert(data.message); // Pesan jika sudah dilike
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btn.disabled = false; // Kembalikan jika error jaringan
                });
        }
    </script>
</x-public-layout>
