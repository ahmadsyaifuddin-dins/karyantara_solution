<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">Detail Testimonial</h2>
            <a href="{{ route('admin.testimonials.index') }}"
                class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-50 transition text-sm font-bold shadow-sm flex items-center">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 flex flex-col md:flex-row">

                <div
                    class="md:w-1/3 bg-gray-50/50 p-8 flex flex-col items-center text-center border-b md:border-b-0 md:border-r border-gray-200">
                    <div class="relative group">
                        <img src="{{ $testimonial->profile_image ? asset('uploads/testimonials/' . $testimonial->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($testimonial->client_name) . '&background=1E293B&color=fff&size=128' }}"
                            class="w-32 h-32 rounded-3xl object-cover border-4 border-white shadow-lg transition group-hover:rotate-3">
                        <div class="absolute -bottom-2 -right-2 bg-amber-500 rounded-lg p-2 shadow-lg text-white">
                            <i class="fa-solid fa-star text-xs"></i>
                        </div>
                    </div>

                    <h3 class="mt-6 text-2xl font-black text-[#1E293B]">{{ $testimonial->client_name }}</h3>
                    <p class="text-sm font-bold text-amber-600 uppercase tracking-widest mt-1">
                        {{ $testimonial->client_title ?? 'Klien' }}</p>

                    <div class="mt-8 w-full space-y-3">
                        <a href="https://wa.me/{{ $testimonial->phone_number }}" target="_blank"
                            class="flex items-center justify-center gap-2 w-full py-3.5 bg-green-500 text-white rounded-2xl font-black shadow-lg shadow-green-100 hover:bg-green-600 hover:-translate-y-1 transition-all">
                            <i class="fa-brands fa-whatsapp text-xl"></i> HUBUNGI VIA WA
                        </a>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Terdaftar:
                            +{{ $testimonial->phone_number }}</p>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-200 w-full text-left">
                        <span class="text-[10px] font-black text-gray-400 uppercase mb-2 block">Rating Pengguna</span>
                        <div class="flex text-amber-400 text-2xl drop-shadow-sm">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="{{ $i < $testimonial->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="md:w-2/3 p-8 md:p-12">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-10">
                        <div>
                            <span
                                class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Email
                                Kontak</span>
                            <p class="text-[#1E293B] font-bold flex items-center">
                                <i class="fa-regular fa-envelope mr-2 text-amber-500"></i>
                                {{ $testimonial->email ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">IP
                                Address</span>
                            <p class="text-[#1E293B] font-mono font-bold flex items-center">
                                <i class="fa-solid fa-network-wired mr-2 text-amber-500"></i>
                                {{ $testimonial->ip_address ?? '::1' }}
                            </p>
                        </div>
                        <div>
                            <span
                                class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Dikirim
                                Pada</span>
                            <p class="text-[#1E293B] font-bold flex items-center">
                                <i class="fa-regular fa-calendar-check mr-2 text-amber-500"></i>
                                {{ $testimonial->created_at->locale('id')->translatedFormat('j F Y, H:i') }} WITA
                            </p>
                            <span
                                class="text-[10px] text-amber-600 font-bold uppercase ml-6">{{ $testimonial->created_at->locale('id')->diffForHumans() }}</span>
                        </div>
                        <div>
                            <span
                                class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status
                                Publikasi</span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black {{ $testimonial->is_approved ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                <i
                                    class="fa-solid {{ $testimonial->is_approved ? 'fa-check-circle' : 'fa-clock' }} mr-1.5"></i>
                                {{ $testimonial->is_approved ? 'PUBLISHED' : 'PENDING REVIEW' }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-10">
                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Metadata
                            Perangkat (User Agent)</span>
                        <div
                            class="bg-gray-50 border border-gray-100 rounded-2xl p-4 text-[11px] font-mono text-gray-500 leading-relaxed break-all">
                            {{ $testimonial->user_agent ?? 'Tidak ada data user agent yang terekam.' }}
                        </div>
                    </div>

                    <div class="relative bg-[#1E293B] rounded-3xl p-8 text-white shadow-2xl">
                        <i class="fa-solid fa-quote-left absolute top-6 left-6 text-white/10 text-6xl"></i>
                        <p class="relative z-10 text-lg md:text-xl font-medium italic leading-relaxed text-gray-200">
                            "{!! nl2br(e($testimonial->testimonial)) !!}"
                        </p>
                    </div>

                    <div class="mt-10 flex justify-end gap-3">
                        <form action="{{ route('admin.testimonials.toggle-status', $testimonial->id) }}"
                            method="POST">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all {{ $testimonial->is_approved ? 'bg-amber-50 text-amber-600 border border-amber-200 hover:bg-amber-100' : 'bg-green-50 text-green-600 border border-green-200 hover:bg-green-100' }}">
                                {{ $testimonial->is_approved ? 'Sembunyikan' : 'Setujui Sekarang' }}
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
