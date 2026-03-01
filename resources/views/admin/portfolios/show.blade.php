<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">Detail Karya Portofolio</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.portfolios.index') }}"
                    class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-xl text-sm font-bold shadow-sm hover:bg-gray-50 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
                </a>
                <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}"
                    class="bg-amber-500 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-sm hover:bg-amber-600 transition">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 space-y-4">
                    <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100">
                        <span class="block text-xs font-black text-amber-500 uppercase tracking-widest mb-3">Gambar
                            Utama</span>
                        <div
                            class="w-full h-64 rounded-2xl overflow-hidden border border-gray-100 bg-gray-50 flex items-center justify-center relative">
                            @if ($portfolio->thumbnail)
                                <img src="{{ asset('uploads/portfolios/' . $portfolio->thumbnail) }}"
                                    class="w-full h-full object-cover shadow-inner">
                            @else
                                <i class="fa-solid fa-image text-4xl text-gray-300"></i>
                            @endif
                            <div
                                class="absolute top-3 left-3 bg-amber-500 text-white text-[10px] font-bold px-3 py-1 rounded-lg shadow-md">
                                THUMBNAIL</div>
                        </div>
                    </div>

                    @if ($portfolio->images->count() > 1)
                        <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100">
                            <span class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Galeri
                                Lainnya</span>
                            <div class="grid grid-cols-3 gap-3">
                                @foreach ($portfolio->images->where('is_thumbnail', 0) as $img)
                                    <div
                                        class="w-full h-20 rounded-xl overflow-hidden border border-gray-200 cursor-pointer hover:border-amber-500 transition-all hover:scale-105">
                                        <img src="{{ asset('uploads/portfolios/' . $img->image) }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 h-full">
                        <div class="mb-6 pb-6 border-b border-gray-100">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-800 uppercase tracking-widest mb-4">
                                {{ $portfolio->category }}
                            </span>
                            <h3 class="text-3xl font-black text-[#1E293B]">{{ $portfolio->title }}</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                    <i class="fa-solid fa-code mr-1 text-amber-500"></i> Developer
                                </span>
                                @if ($portfolio->developer)
                                    <p class="text-[#1E293B] font-bold text-sm">{{ $portfolio->developer->name }}</p>
                                @else
                                    <p class="text-gray-400 font-medium italic text-sm">Tidak ada data</p>
                                @endif
                            </div>

                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                    <i class="fa-solid fa-user-tie mr-1 text-amber-500"></i> Nama Klien
                                </span>
                                <p class="text-[#1E293B] font-bold text-sm">
                                    {{ $portfolio->client_name ?? 'Pribadi / Internal' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                    <i class="fa-solid fa-link mr-1 text-amber-500"></i> Link Proyek
                                </span>
                                @if ($portfolio->project_url)
                                    <a href="{{ $portfolio->project_url }}" target="_blank"
                                        class="text-blue-600 font-bold text-sm hover:underline inline-flex items-center mt-1">
                                        Kunjungi Tautan <i
                                            class="fa-solid fa-arrow-up-right-from-square ml-1.5 text-[10px]"></i>
                                    </a>
                                @else
                                    <p class="text-gray-400 font-medium italic text-sm mt-1">Tidak ada tautan</p>
                                @endif
                            </div>
                        </div>

                        <div>
                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3"><i
                                    class="fa-solid fa-align-left mr-1 text-amber-500"></i> Deskripsi Proyek</span>
                            <div
                                class="prose prose-sm max-w-none text-gray-600 bg-gray-50 p-6 rounded-2xl border border-gray-100 leading-relaxed font-medium">
                                {!! nl2br(e($portfolio->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
