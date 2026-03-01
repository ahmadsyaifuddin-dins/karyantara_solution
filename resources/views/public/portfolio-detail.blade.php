<x-public-layout :title="$portfolio->title . ' - Portofolio Karyantara Solution'">

    <div class="bg-[#1E293B] py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span
                class="inline-block py-1 px-3 rounded-full bg-amber-500/20 text-amber-400 text-sm font-semibold tracking-wider uppercase mb-4">
                {{ $portfolio->category }}
            </span>
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">{{ $portfolio->title }}</h1>

            <div class="flex flex-wrap items-center justify-center gap-4 md:gap-8 text-gray-300 text-sm mt-8">
                @if ($portfolio->developer)
                    <div
                        class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full border border-white/10 shadow-sm">
                        <i class="fa-solid fa-code text-amber-500"></i>
                        <span>Developer: <strong class="text-white">{{ $portfolio->developer->name }}</strong></span>
                    </div>
                @endif

                @if ($portfolio->client_name)
                    <div
                        class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full border border-white/10 shadow-sm">
                        <i class="fa-solid fa-user-tie text-amber-500"></i>
                        <span>Klien: <strong class="text-white">{{ $portfolio->client_name }}</strong></span>
                    </div>
                @endif

                <div
                    class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full border border-white/10 shadow-sm">
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

    @if ($otherProjects->count() > 0)
        <div class="bg-gray-50 py-20 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-extrabold text-[#1E293B]">Lihat Karya Lainnya</h3>
                    <div class="w-16 h-1.5 bg-amber-500 mx-auto mt-4 rounded-full"></div>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($otherProjects as $item)
                        <a href="{{ route('portfolio.show', $item->id) }}"
                            class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300 group block">
                            <div class="h-48 bg-gray-200 overflow-hidden relative">
                                <img src="{{ asset('uploads/portfolios/' . $item->thumbnail) }}"
                                    alt="{{ $item->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-6">
                                <span
                                    class="text-xs font-bold text-amber-600 tracking-wider uppercase mb-2 block">{{ $item->category }}</span>
                                <h4 class="font-bold text-[#1E293B] text-lg">{{ $item->title }}</h4>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</x-public-layout>
