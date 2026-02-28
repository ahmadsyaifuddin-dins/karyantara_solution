<footer class="bg-[#1E293B] text-white py-12 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-2xl font-bold mb-4">Karyantara Solution</h3>
                <p class="text-gray-400 text-sm">Mitra terbaik Anda dalam mewujudkan solusi digital yang inovatif,
                    modern, dan profesional.</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4 text-amber-400">Tautan Cepat</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="{{ route('portfolio') }}" class="hover:text-white transition">Portofolio</a></li>
                    <li><a href="{{ route('testimonial') }}" class="hover:text-white transition">Testimonial Klien</a>
                    </li>
                    <li><a href="{{ route('terms') }}" class="hover:text-white transition">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4 text-amber-400">Kontak</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><i class="fa-solid fa-envelope mr-2"></i> karyantarasolution@gmail.com</li>
                    <li><i class="fa-solid fa-phone mr-2"></i> +62 812 3456 7890</li>
                    <li><i class="fa-solid fa-location-dot mr-2"></i> Banjarmasin, Indonesia</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
            &copy; 2026-{{ date('Y') }} Karyantara Solution. All rights reserved.
        </div>
    </div>
</footer>
