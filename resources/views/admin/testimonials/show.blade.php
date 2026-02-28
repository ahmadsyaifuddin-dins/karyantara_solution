<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
                {{ __('Detail Testimonial') }}
            </h2>
            <a href="{{ route('admin.testimonials.index') }}"
                class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50 transition text-sm font-semibold shadow-sm flex items-center">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100">
                <div class="flex flex-col md:flex-row">

                    <div
                        class="md:w-1/3 bg-gray-50 p-8 flex flex-col items-center text-center border-b md:border-b-0 md:border-r border-gray-200">
                        <div class="relative">
                            @if ($testimonial->profile_image)
                                <img src="{{ asset('uploads/testimonials/' . $testimonial->profile_image) }}"
                                    alt="{{ $testimonial->client_name }}"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->client_name) }}&background=1E293B&color=fff&size=128"
                                    alt="Default Avatar"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md">
                            @endif

                            <div
                                class="absolute -bottom-2 -right-2 bg-white rounded-full p-1.5 shadow-sm border border-gray-100">
                                <i class="fa-solid fa-quote-right text-amber-500 text-sm"></i>
                            </div>
                        </div>

                        <h3 class="mt-5 text-2xl font-extrabold text-[#1E293B]">{{ $testimonial->client_name }}</h3>
                        <p class="text-sm font-semibold text-amber-600 mt-1 uppercase tracking-wide">
                            {{ $testimonial->client_title ?? 'Klien' }}</p>

                        <div class="mt-4 flex text-amber-400 text-lg drop-shadow-sm">
                            @for ($i = 0; $i < $testimonial->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                            @for ($i = $testimonial->rating; $i < 5; $i++)
                                <i class="fa-regular fa-star text-gray-300"></i>
                            @endfor
                        </div>

                        <div class="mt-6 w-full pt-6 border-t border-gray-200">
                            @if ($testimonial->is_approved)
                                <span
                                    class="px-4 py-2 flex items-center justify-center text-sm font-bold rounded-xl bg-green-100 text-green-800 border border-green-200 w-full shadow-sm">
                                    <i class="fa-solid fa-check-circle mr-2"></i> Status: Dipublikasi
                                </span>
                            @else
                                <span
                                    class="px-4 py-2 flex items-center justify-center text-sm font-bold rounded-xl bg-amber-100 text-amber-800 border border-amber-200 w-full shadow-sm animate-pulse">
                                    <i class="fa-solid fa-clock mr-2"></i> Status: Pending
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="md:w-2/3 p-8">
                        <h4
                            class="text-lg font-bold text-[#1E293B] border-b border-gray-100 pb-3 mb-6 flex items-center">
                            <i class="fa-solid fa-circle-info text-gray-400 mr-2"></i> Informasi Lengkap
                        </h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email
                                    Kontak</span>
                                <p class="text-gray-800 font-medium text-sm">
                                    @if ($testimonial->email)
                                        <a href="mailto:{{ $testimonial->email }}"
                                            class="hover:text-amber-600 transition flex items-center">
                                            <i class="fa-regular fa-envelope mr-2 text-gray-400"></i>
                                            {{ $testimonial->email }}
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic"><i class="fa-solid fa-minus mr-2"></i>Tidak
                                            ada data</span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">IP
                                    Address</span>
                                <p class="text-gray-800 font-medium font-mono text-sm flex items-center">
                                    <i class="fa-solid fa-network-wired mr-2 text-gray-400"></i>
                                    {{ $testimonial->ip_address ?? 'Tidak terekam' }}
                                </p>
                            </div>

                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Waktu
                                    Dibuat</span>
                                <p class="text-gray-800 font-medium text-sm flex items-center">
                                    <i class="fa-regular fa-calendar-plus mr-2 text-gray-400"></i>
                                    {{ $testimonial->created_at ? $testimonial->created_at->translatedFormat('d F Y - H:i') : '-' }}
                                </p>
                            </div>

                            <div>
                                <span
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pembaruan
                                    Terakhir</span>
                                <p class="text-gray-800 font-medium text-sm flex items-center">
                                    <i class="fa-solid fa-clock-rotate-left mr-2 text-gray-400"></i>
                                    {{ $testimonial->updated_at ? $testimonial->updated_at->diffForHumans() : '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-amber-50/50 rounded-2xl p-6 border border-amber-100 relative">
                            <i
                                class="fa-solid fa-quote-left absolute -top-3 -left-2 text-4xl text-amber-200 bg-white rounded-full"></i>
                            <span class="block text-xs font-bold text-amber-600 uppercase tracking-wider mb-3 ml-2">Isi
                                Testimonial</span>
                            <p class="text-gray-700 leading-relaxed font-medium text-justify ml-2">
                                "{!! nl2br(e($testimonial->testimonial)) !!}"
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
