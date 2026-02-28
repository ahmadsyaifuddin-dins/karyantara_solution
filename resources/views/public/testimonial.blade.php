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

            @if (session('success'))
                <div
                    class="max-w-3xl mx-auto mb-10 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-start">
                    <i class="fa-solid fa-circle-check text-green-500 mt-0.5 mr-3 text-lg"></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="max-w-3xl mx-auto mb-10 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-start">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 mt-0.5 mr-3 text-lg"></i>
                    <div>
                        <p class="text-red-800 font-bold mb-1">Gagal mengirim ulasan:</p>
                        <ul class="text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-24">
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
                        <p class="text-gray-500">Jadilah yang pertama membagikan pengalaman bekerja sama dengan kami!
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden"
                id="form-ulasan">
                <div class="bg-[#1E293B] p-8 text-center relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500 rounded-full opacity-20 blur-2xl">
                    </div>
                    <h2 class="text-3xl font-extrabold text-white mb-2 relative z-10">Bagikan Pengalaman Anda</h2>
                    <p class="text-gray-300 relative z-10">Masukan Anda sangat berharga bagi perkembangan Karyantara
                        Solution.</p>
                </div>

                <div class="p-8 md:p-10">
                    <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="opacity-0 absolute -z-50 h-0 w-0 overflow-hidden" aria-hidden="true">
                            <label for="company_website">Tinggalkan kosong jika Anda manusia:</label>
                            <input type="text" name="company_website" id="company_website" tabindex="-1"
                                autocomplete="off">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-[#1E293B] mb-2">Nama Lengkap <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="client_name" value="{{ old('client_name') }}" required
                                    placeholder="Contoh: John Doe"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#1E293B] mb-2">Email Valid <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    placeholder="john@example.com"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                                <p class="text-xs text-gray-500 mt-1"><i
                                        class="fa-solid fa-lock text-gray-400 mr-1"></i>Email tidak akan dipublikasikan.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-[#1E293B] mb-2">Jabatan / Instansi <span
                                        class="text-gray-400 font-normal">(Opsional)</span></label>
                                <input type="text" name="client_title" value="{{ old('client_title') }}"
                                    placeholder="Contoh: CEO PT. Maju Jaya"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#1E293B] mb-2">Foto Profil <span
                                        class="text-gray-400 font-normal">(Opsional)</span></label>
                                <input type="file" name="profile_image" accept="image/*"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                            </div>
                        </div>

                        <div class="mb-6" x-data="{ rating: {{ old('rating', 5) }}, hoverRating: 0 }">
                            <label class="block text-sm font-semibold text-[#1E293B] mb-2">Rating Anda <span
                                    class="text-red-500">*</span></label>
                            <div class="flex space-x-2 text-2xl cursor-pointer">
                                <template x-for="i in 5" :key="i">
                                    <i class="fa-solid fa-star transition-colors duration-200" @click="rating = i"
                                        @mouseenter="hoverRating = i" @mouseleave="hoverRating = 0"
                                        :class="(hoverRating >= i || (!hoverRating && rating >= i)) ?
                                        'text-amber-400 drop-shadow-sm' : 'text-gray-300'">
                                    </i>
                                </template>
                            </div>
                            <input type="hidden" name="rating" x-model="rating" required>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-[#1E293B] mb-2">Ulasan Anda <span
                                    class="text-red-500">*</span></label>
                            <textarea name="testimonial" required rows="4"
                                placeholder="Ceritakan pengalaman luar biasa Anda bersama kami..."
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors resize-none">{{ old('testimonial') }}</textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit"
                                class="w-full md:w-auto px-8 py-4 bg-[#1E293B] text-white font-bold rounded-xl hover:bg-gray-800 focus:ring-4 focus:ring-amber-500/50 transition transform hover:-translate-y-1 shadow-lg flex items-center justify-center mx-auto group">
                                <i
                                    class="fa-solid fa-paper-plane mr-2 group-hover:text-amber-500 transition-colors"></i>
                                Kirim Ulasan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-public-layout>
