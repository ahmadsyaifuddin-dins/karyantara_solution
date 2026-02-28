<x-public-layout :title="$portfolio->title . ' - Portofolio Karyantara Solution'">

    <div class="bg-[#1E293B] py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span
                class="inline-block py-1 px-3 rounded-full bg-amber-500/20 text-amber-400 text-sm font-semibold tracking-wider uppercase mb-4">
                {{ $portfolio->category }}
            </span>
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">{{ $portfolio->title }}</h1>

            <div class="flex items-center justify-center gap-6 text-gray-300 text-sm mt-8">
                @if ($portfolio->client_name)
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-user-tie text-amber-500"></i>
                        <span>Klien: <strong class="text-white">{{ $portfolio->client_name }}</strong></span>
                    </div>
                @endif
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-calendar text-amber-500"></i>
                    <span>Selesai: <strong
                            class="text-white">{{ $portfolio->created_at->format('M Y') }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 -mt-16 relative z-10">
        <div class="bg-white p-2 rounded-2xl shadow-xl mb-12 border border-gray-100">
            <img src="{{ asset('uploads/portfolios/' . $portfolio->image) }}" alt="{{ $portfolio->title }}"
                class="w-full h-auto max-h-[500px] object-cover rounded-xl">
        </div>

        <div class="bg-white p-8 md:p-10 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold text-[#1E293B] mb-6 border-b border-gray-100 pb-4">Tentang Proyek</h2>

            <div class="prose max-w-none text-gray-600 leading-relaxed whitespace-pre-line mb-8">
                {{ $portfolio->description }}
            </div>

            @if ($portfolio->project_url)
                <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                    <a href="{{ $portfolio->project_url }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 bg-amber-500 text-[#1E293B] px-8 py-3 rounded-lg font-bold hover:bg-amber-400 transition shadow-md">
                        <i class="fa-solid fa-globe"></i> Kunjungi Proyek Live
                    </a>
                </div>
            @endif
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('portfolio') }}"
                class="inline-flex items-center gap-2 text-gray-500 hover:text-[#1E293B] transition font-medium">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Portofolio
            </a>
        </div>
    </div>

    @if ($otherProjects->count() > 0)
        <div class="bg-gray-50 py-16 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-2xl font-bold text-[#1E293B] mb-8 text-center">Proyek Lainnya</h3>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($otherProjects as $item)
                        <a href="{{ route('portfolio.show', $item->id) }}"
                            class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition group block">
                            <div class="h-48 bg-gray-200 overflow-hidden">
                                <img src="{{ asset('uploads/portfolios/' . $item->image) }}" alt="{{ $item->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </div>
                            <div class="p-6">
                                <span
                                    class="text-xs font-semibold text-amber-600 tracking-wider uppercase mb-1 block">{{ $item->category }}</span>
                                <h4 class="font-bold text-[#1E293B]">{{ $item->title }}</h4>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</x-public-layout>
