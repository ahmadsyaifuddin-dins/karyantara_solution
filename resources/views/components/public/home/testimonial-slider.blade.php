@props(['testimonials'])

@if ($testimonials->count() > 0)
    <div class="bg-[#0F172A] border-y border-slate-800/50 py-24 overflow-hidden relative z-10">

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
                animation: marquee 45s linear infinite;
            }

            .animate-marquee:hover {
                animation-play-state: paused;
            }
        </style>

        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[300px] bg-amber-500/5 blur-[120px] rounded-full pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 text-center relative z-10">
            <div class="inline-flex items-center gap-3 mb-4 justify-center">
                <div class="h-[2px] w-8 bg-amber-500"></div>
                <h2 class="text-sm font-bold text-amber-500 tracking-wider uppercase">
                    <i class="fa-solid fa-heart mr-2"></i> Dipercaya Oleh Klien
                </h2>
                <div class="h-[2px] w-8 bg-amber-500"></div>
            </div>

            <h3 class="text-4xl md:text-5xl font-archive font-normal text-white drop-shadow-md leading-tight">
                SUARA <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600">KLIEN
                    KAMI</span>
            </h3>
        </div>

        <div
            class="absolute left-0 top-0 bottom-0 w-24 md:w-64 bg-gradient-to-r from-[#0F172A] via-[#0F172A]/90 to-transparent z-20 pointer-events-none">
        </div>
        <div
            class="absolute right-0 top-0 bottom-0 w-24 md:w-64 bg-gradient-to-l from-[#0F172A] via-[#0F172A]/90 to-transparent z-20 pointer-events-none">
        </div>

        <div class="animate-marquee gap-6 md:gap-8 px-4 relative z-10">
            @foreach ([...$testimonials, ...$testimonials] as $item)
                <div
                    class="bg-[#1E293B]/60 backdrop-blur-md rounded-3xl p-8 border border-slate-700/50 hover:border-amber-500/50 hover:bg-[#1E293B]/90 hover:shadow-[0_15px_30px_rgba(245,158,11,0.1)] w-[320px] sm:w-[420px] flex-shrink-0 cursor-pointer transform hover:-translate-y-2 transition-all duration-500 relative group overflow-hidden">

                    <i
                        class="fa-solid fa-quote-right absolute -bottom-4 -right-4 text-8xl text-white/5 group-hover:text-amber-500/10 transition-colors duration-500 transform group-hover:scale-110 group-hover:-rotate-12"></i>

                    <div class="flex items-center mb-6 relative z-10">
                        <div class="relative">
                            @if ($item->profile_image)
                                <img src="{{ asset('uploads/testimonials/' . $item->profile_image) }}"
                                    alt="{{ $item->client_name }}"
                                    class="w-16 h-16 rounded-full object-cover border-[3px] border-slate-700 group-hover:border-amber-500 transition-colors duration-300 shadow-lg">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->client_name) }}&background=0F172A&color=F59E0B"
                                    alt="Avatar"
                                    class="w-16 h-16 rounded-full object-cover border-[3px] border-slate-700 group-hover:border-amber-500 transition-colors duration-300 shadow-lg">
                            @endif
                        </div>
                        <div class="ml-4">
                            <h4
                                class="font-extrabold text-white text-lg group-hover:text-amber-400 transition-colors duration-300">
                                {{ $item->client_name }}
                            </h4>
                            <span class="text-amber-500/80 text-xs font-bold uppercase tracking-wider block mt-1">
                                {{ $item->client_title ?? 'Klien Karyantara' }}
                            </span>
                        </div>
                    </div>

                    <div class="relative z-10">
                        <div
                            class="flex text-amber-500 text-[11px] mb-4 drop-shadow-[0_0_8px_rgba(245,158,11,0.5)] gap-1">
                            @for ($i = 0; $i < $item->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                            @for ($i = $item->rating; $i < 5; $i++)
                                <i class="fa-regular fa-star text-slate-600"></i>
                            @endfor
                        </div>

                        <p
                            class="text-slate-300 text-sm md:text-base font-light italic line-clamp-4 leading-relaxed group-hover:text-white transition-colors duration-300">
                            "{{ $item->testimonial }}"
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
