@props(['testimonials'])

@if ($testimonials->count() > 0)
    <div class="bg-white border-b border-gray-100 py-10 overflow-hidden relative">

        <style>
            @keyframes marquee {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-50%);
                }
            }

            .animate-marquee {
                display: flex;
                width: max-content;
                animation: marquee 35s linear infinite;
                /* Kecepatan jalan: 35 detik */
            }

            /* Berhenti berjalan kalau disorot mouse */
            .animate-marquee:hover {
                animation-play-state: paused;
            }
        </style>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 text-center">
            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest"><i
                    class="fa-solid fa-heart text-amber-500 mr-2"></i> Dipercaya Oleh Klien Hebat</p>
        </div>

        <div
            class="absolute left-0 top-0 bottom-0 w-16 md:w-32 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none">
        </div>
        <div
            class="absolute right-0 top-0 bottom-0 w-16 md:w-32 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none">
        </div>

        <div class="animate-marquee gap-6 px-4">
            @foreach ([...$testimonials, ...$testimonials] as $item)
                <div
                    class="bg-slate-50 rounded-2xl p-6 shadow-sm border border-gray-100 w-80 sm:w-96 flex-shrink-0 cursor-pointer hover:shadow-md hover:-translate-y-1 transition-all">
                    <div class="flex items-center mb-4">
                        @if ($item->profile_image)
                            <img src="{{ asset('uploads/testimonials/' . $item->profile_image) }}"
                                alt="{{ $item->client_name }}"
                                class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($item->client_name) }}&background=1E293B&color=fff"
                                alt="Avatar"
                                class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                        @endif
                        <div class="ml-3">
                            <h4 class="font-bold text-[#1E293B] text-sm">{{ $item->client_name }}</h4>
                            <span
                                class="text-gray-500 text-xs font-medium uppercase tracking-wider">{{ $item->client_title ?? 'Klien Karyantara' }}</span>
                        </div>
                    </div>

                    <div class="flex text-amber-400 text-xs mb-3 drop-shadow-sm">
                        @for ($i = 0; $i < $item->rating; $i++)
                            <i class="fa-solid fa-star"></i>
                        @endfor
                    </div>

                    <p class="text-gray-600 text-sm italic line-clamp-3 leading-relaxed">"{{ $item->testimonial }}"</p>
                </div>
            @endforeach
        </div>
    </div>
@endif
