<x-public-layout title="Testimonial Klien - Karyantara Solution">

    <div class="relative bg-slate-50 pt-20 pb-28 lg:pt-24 lg:pb-32 overflow-hidden min-h-screen">

        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-white to-transparent pointer-events-none">
        </div>
        <div
            class="absolute top-20 left-10 w-72 h-72 bg-amber-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob pointer-events-none">
        </div>
        <div
            class="absolute top-40 right-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="text-center mb-16">
                <span class="text-sm font-bold text-amber-500 tracking-wider uppercase mb-2 block">Ulasan Klien</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#1E293B]">Apa Kata Mereka?</h1>
                <div class="w-24 h-1.5 bg-gradient-to-r from-amber-400 to-amber-600 mx-auto mt-6 rounded-full mb-6">
                </div>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
                    Kepuasan klien adalah metrik utama kesuksesan kami. Berikut adalah pengalaman nyata mereka bekerja
                    sama dengan tim Karyantara Solution.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($testimonials as $item)
                    <div
                        class="bg-white p-8 rounded-2xl shadow-md border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col h-full relative group overflow-hidden">

                        <i
                            class="fa-solid fa-quote-right absolute -bottom-4 -right-4 text-8xl text-gray-50 group-hover:text-amber-50 transition-colors duration-300 transform -rotate-12 pointer-events-none"></i>

                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex text-amber-400 mb-6 text-sm">
                                @for ($i = 0; $i < $item->rating; $i++)
                                    <i class="fa-solid fa-star drop-shadow-sm"></i>
                                @endfor
                            </div>

                            <p class="text-gray-600 mb-8 italic flex-grow leading-relaxed font-medium">
                                "{{ $item->testimonial }}"
                            </p>

                            <div class="flex items-center pt-6 border-t border-gray-100">
                                @if ($item->profile_image)
                                    <img src="{{ asset('uploads/testimonials/' . $item->profile_image) }}"
                                        alt="{{ $item->client_name }}"
                                        class="w-14 h-14 rounded-full object-cover border-2 border-amber-100 shadow-sm p-0.5">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->client_name) }}&background=1E293B&color=fff"
                                        alt="Avatar"
                                        class="w-14 h-14 rounded-full object-cover border-2 border-amber-100 shadow-sm p-0.5">
                                @endif

                                <div class="ml-4">
                                    <h4 class="font-bold text-[#1E293B]">{{ $item->client_name }}</h4>
                                    <span
                                        class="text-gray-500 text-xs font-bold uppercase tracking-wider">{{ $item->client_title ?? 'Klien Karyantara' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-sm">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-regular fa-comment-dots text-4xl text-gray-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#1E293B] mb-2">Belum Ada Ulasan</h3>
                        <p class="text-gray-500">Testimonial dari klien kami akan segera ditampilkan di sini.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-public-layout>
