@props(['testimonials'])

@if ($testimonials->count() > 0)
    <div class="bg-white border-y border-gray-100 py-16 overflow-hidden relative">

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
            }

            .animate-marquee:hover {
                animation-play-state: paused;
            }
        </style>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10 text-center">
            <h3 class="text-2xl font-black text-[#1E293B] mb-2">Suara Klien Kami</h3>
            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest flex justify-center items-center gap-2">
                <span class="w-8 h-px bg-gray-300"></span>
                <i class="fa-solid fa-heart text-amber-500"></i> Dipercaya Oleh Klien
                <span class="w-8 h-px bg-gray-300"></span>
            </p>
        </div>

        <div
            class="absolute left-0 top-0 bottom-0 w-24 md:w-48 bg-gradient-to-r from-white via-white/80 to-transparent z-10 pointer-events-none">
        </div>
        <div
            class="absolute right-0 top-0 bottom-0 w-24 md:w-48 bg-gradient-to-l from-white via-white/80 to-transparent z-10 pointer-events-none">
        </div>

        <div class="animate-marquee gap-6 px-4">
            @foreach ([...$testimonials, ...$testimonials] as $item)
                <div
                    class="bg-slate-50 hover:bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl hover:shadow-amber-100/50 border-2 border-dashed border-gray-200 hover:border-amber-400 w-80 sm:w-96 flex-shrink-0 cursor-pointer transform hover:-translate-y-2 transition-all duration-300 relative group">

                    <i
                        class="fa-solid fa-quote-right absolute top-6 right-6 text-4xl text-gray-200 group-hover:text-amber-100 transition-colors duration-300"></i>

                    <div class="flex items-center mb-5 relative z-10">
                        <div class="relative">
                            @if ($item->profile_image)
                                <img src="{{ asset('uploads/testimonials/' . $item->profile_image) }}"
                                    alt="{{ $item->client_name }}"
                                    class="w-14 h-14 rounded-full object-cover border-[3px] border-white shadow-md group-hover:border-amber-100 transition-colors">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->client_name) }}&background=1E293B&color=fff"
                                    alt="Avatar"
                                    class="w-14 h-14 rounded-full object-cover border-[3px] border-white shadow-md group-hover:border-amber-100 transition-colors">
                            @endif
                        </div>
                        <div class="ml-4">
                            <h4 class="font-extrabold text-[#1E293B] group-hover:text-amber-600 transition-colors">
                                {{ $item->client_name }}</h4>
                            <span
                                class="text-gray-500 text-[10px] font-bold uppercase tracking-wider block mt-0.5">{{ $item->client_title ?? 'Klien Karyantara' }}</span>
                        </div>
                    </div>

                    <div class="relative z-10">
                        <div class="flex text-amber-400 text-[10px] mb-3 drop-shadow-sm gap-0.5">
                            @for ($i = 0; $i < $item->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                            @for ($i = $item->rating; $i < 5; $i++)
                                <i class="fa-regular fa-star text-amber-200"></i>
                            @endfor
                        </div>

                        <p class="text-gray-600 text-sm font-medium italic line-clamp-3 leading-relaxed">
                            "{{ $item->testimonial }}"
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
