<x-public-layout title="Portofolio - Karyantara Solution">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">

        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-[#1E293B]">Portofolio Kami</h1>
            <div class="w-24 h-1 bg-amber-500 mx-auto mt-4 rounded-full mb-6"></div>
            <p class="text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Beberapa karya terbaik yang telah kami selesaikan untuk membantu klien mencapai tujuan bisnis mereka.
                Jelajahi karya terbaik yang sedang menjadi tren dan paling banyak disukai oleh klien kami.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($portfolios as $index => $item)
                <a href="{{ route('portfolio.show', $item->id) }}"
                    class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col group cursor-pointer relative block">

                    @if ($index < 3 && ($item->views_count > 0 || $item->likes_count > 0))
                        <div
                            class="absolute top-4 left-4 z-20 bg-gradient-to-r from-red-500 to-pink-500 text-white text-[10px] font-black px-3 py-1.5 rounded-full shadow-lg uppercase tracking-wider animate-pulse border border-pink-400/50">
                            🔥 Top #{{ $index + 1 }} Tren
                        </div>
                    @endif

                    @if ($item->images->count() > 1)
                        <div
                            class="absolute top-4 right-4 z-20 bg-black/40 backdrop-blur-md text-white text-[11px] font-bold px-2.5 py-1.5 rounded-lg border border-white/20 shadow-sm flex items-center gap-1.5 group-hover:bg-amber-500 group-hover:border-amber-400 group-hover:text-[#1E293B] transition-colors duration-300">
                            <i class="fa-regular fa-images"></i> {{ $item->images->count() }}
                        </div>
                    @endif

                    <div class="h-60 bg-gray-200 flex items-center justify-center overflow-hidden relative">
                        <img src="{{ asset('uploads/portfolios/' . $item->thumbnail) }}" alt="{{ $item->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700">

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-[#1E293B]/95 via-[#1E293B]/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300">
                        </div>

                        <div
                            class="absolute bottom-5 left-5 right-5 flex justify-between items-end opacity-0 group-hover:opacity-100 transition duration-300 translate-y-4 group-hover:translate-y-0 z-10">

                            <div class="flex flex-col gap-2">
                                <span
                                    class="bg-black/40 backdrop-blur-md px-2.5 py-1.5 rounded-lg border border-white/10 text-white text-xs font-bold flex items-center w-fit shadow-sm">
                                    <i class="fa-solid fa-eye text-blue-400 mr-2"></i>
                                    {{ number_format($item->views_count, 0, ',', '.') }}
                                </span>
                                <span
                                    class="bg-black/40 backdrop-blur-md px-2.5 py-1.5 rounded-lg border border-white/10 text-white text-xs font-bold flex items-center w-fit shadow-sm">
                                    <i class="fa-solid fa-heart text-pink-500 mr-2"></i> <span
                                        id="like-count-{{ $item->id }}">{{ number_format($item->likes_count, 0, ',', '.') }}</span>
                                </span>
                            </div>

                            <span
                                class="bg-amber-500 text-[#1E293B] px-4 py-2.5 rounded-xl font-black text-xs shadow-lg shadow-amber-500/30 hover:bg-amber-400 transition-colors">
                                Lihat Proyek <i class="fa-solid fa-arrow-right ml-1"></i>
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <span class="text-[10px] font-black text-amber-500 tracking-widest uppercase mb-2 block">
                            {{ $item->category }}
                        </span>

                        <h3
                            class="text-xl font-bold text-[#1E293B] group-hover:text-amber-600 transition-colors mb-2 leading-tight">
                            {{ $item->title }}
                        </h3>

                        <p class="text-gray-500 text-sm mb-4 line-clamp-3 leading-relaxed">
                            {{ $item->description }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                @if ($item->client_name)
                                    <p class="text-[11px] font-bold text-gray-500 truncate"
                                        title="{{ $item->client_name }}">
                                        <i class="fa-solid fa-user-tie mr-1.5 text-blue-400"></i>
                                        {{ $item->client_name }}
                                    </p>
                                @else
                                    <p class="text-[11px] font-bold text-gray-500 truncate">
                                        <i class="fa-solid fa-building mr-1.5 text-blue-400"></i> Internal / Pribadi
                                    </p>
                                @endif
                            </div>

                            @if ($item->developer)
                                <div
                                    class="flex-shrink-0 text-right bg-slate-50 px-2.5 py-1 rounded-md border border-slate-100">
                                    <p class="text-[10px] font-bold text-[#1E293B] uppercase tracking-wider">
                                        <i class="fa-solid fa-code text-amber-500 mr-1"></i>
                                        {{ $item->developer->name }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div
                    class="col-span-full py-20 bg-gray-50 rounded-3xl border border-gray-100 border-dashed text-center">
                    <i class="fa-solid fa-folder-open text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-bold text-[#1E293B]">Belum Ada Portofolio</h3>
                    <p class="text-gray-500 mt-1">Karya-karya terbaik kami akan segera hadir di sini.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-public-layout>
