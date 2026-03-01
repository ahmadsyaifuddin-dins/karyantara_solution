<x-public-layout title="Portofolio - Karyantara Solution">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-[#1E293B]">Portofolio Kami</h1>
            <div class="w-24 h-1 bg-amber-500 mx-auto mt-4 rounded-full mb-6"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">Beberapa karya terbaik yang telah kami selesaikan untuk membantu
                klien mencapai tujuan bisnis mereka.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($portfolios as $item)
                <a href="{{ route('portfolio.show', $item->id) }}"
                    class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition flex flex-col group cursor-pointer block">

                    <div class="h-48 bg-gray-200 flex items-center justify-center overflow-hidden relative">
                        <img src="{{ asset('uploads/portfolios/' . $item->thumbnail) }}" alt="{{ $item->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">

                        <div
                            class="absolute inset-0 bg-[#1E293B]/60 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span
                                class="bg-amber-500 text-[#1E293B] px-4 py-2 rounded-md font-bold text-sm transform translate-y-4 group-hover:translate-y-0 transition duration-300">Lihat
                                Detail</span>
                        </div>

                        @if ($item->images->count() > 1)
                            <div
                                class="absolute top-3 right-3 bg-black/50 text-white text-xs font-bold px-2 py-1 rounded backdrop-blur-sm">
                                <i class="fa-regular fa-images mr-1"></i> {{ $item->images->count() }}
                            </div>
                        @endif
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <span class="text-xs font-semibold text-amber-600 tracking-wider uppercase mb-2 block">
                            {{ $item->category }}
                        </span>
                        <h3 class="text-xl font-bold text-[#1E293B] group-hover:text-amber-600 transition mb-2">
                            {{ $item->title }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ $item->description }}
                        </p>
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            @if ($item->client_name)
                                <p class="text-xs text-gray-500 mb-1"><i class="fa-solid fa-user-tie mr-1"></i>
                                    {{ $item->client_name }}</p>
                            @else
                                <p class="text-xs text-gray-500 mb-1"><i class="fa-solid fa-building mr-1"></i> Internal
                                    / Pribadi</p>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
            @endforelse
        </div>
    </div>
</x-public-layout>
