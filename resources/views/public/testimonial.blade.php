<x-public-layout title="Testimonial Klien - Karyantara Solution">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-[#1E293B]">Apa Kata Klien Kami</h1>
            <div class="w-24 h-1 bg-amber-500 mx-auto mt-4 rounded-full mb-6"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">Kepuasan klien adalah prioritas utama kami. Berikut adalah
                pengalaman mereka bekerja sama dengan Karyantara Solution.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($testimonials as $item)
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 relative">
                    <i class="fa-solid fa-quote-right absolute top-6 right-6 text-4xl text-gray-100"></i>

                    <div class="flex text-amber-400 mb-4 text-sm">
                        @for ($i = 0; $i < $item->rating; $i++)
                            <i class="fa-solid fa-star"></i>
                        @endfor
                    </div>

                    <p class="text-gray-600 mb-6 italic relative z-10">"{{ $item->testimonial }}"</p>

                    <div class="flex items-center mt-auto">
                        @if ($item->profile_image)
                            <img src="{{ asset('uploads/testimonials/' . $item->profile_image) }}"
                                alt="{{ $item->client_name }}"
                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-100">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($item->client_name) }}&background=1E293B&color=fff"
                                alt="Avatar" class="w-12 h-12 rounded-full object-cover border-2 border-gray-100">
                        @endif

                        <div class="ml-4">
                            <h4 class="font-bold text-[#1E293B] text-sm">{{ $item->client_name }}</h4>
                            <span class="text-gray-500 text-xs">{{ $item->client_title ?? 'Klien Karyantara' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fa-regular fa-comment-dots text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada testimonial untuk saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-public-layout>
