@props([
    'variant' => 'dark',
    'bgIcon',
    'avatar',
    'name',
    'role',
    'igLink',
    'igHandle',
    'githubLink', // Tambahan Prop Github Link
    'githubHandle', // Tambahan Prop Github Handle
    'quote',
    'focus',
])

@php
    // Logika Pintar: Mengatur palet warna berdasarkan varian yang dipilih
    if ($variant === 'amber') {
        $cardBg = 'bg-gradient-to-br from-amber-400 to-amber-600';
        $bgIconColor = 'text-[#1E293B] opacity-10 group-hover:opacity-20';
        $bgIconPosition = 'bottom-0';
        $avatarBorder = 'border-[#1E293B] bg-amber-200';
        $nameColor = 'text-[#1E293B]';
        $roleColor = 'text-amber-900';

        // Warna Tombol Sosmed
        $socialBtnClasses = 'text-[#1E293B] hover:text-black hover:bg-white/40 bg-white/20';
        $igIconColor = 'text-pink-700';
        $githubIconColor = 'text-[#1E293B]'; // Warna icon github gelap

        $quoteColor = 'text-amber-900 border-[#1E293B]';
        $focusHeading = 'text-amber-900/70';
        $focusBadge = 'text-[#1E293B] font-bold bg-white/30 border-[#1E293B]/20';
        $techHeading = 'text-amber-900/70';
    } else {
        // Default: Tema Dark
        $cardBg = 'bg-[#1E293B]';
        $bgIconColor = 'text-white opacity-5 group-hover:opacity-10';
        $bgIconPosition = 'top-0';
        $avatarBorder = 'border-amber-500 bg-gray-800';
        $nameColor = 'text-white';
        $roleColor = 'text-amber-500';

        // Warna Tombol Sosmed
        $socialBtnClasses = 'text-gray-300 hover:text-white bg-white/10 hover:bg-white/20';
        $igIconColor = 'text-pink-500';
        $githubIconColor = 'text-white'; // Warna icon github terang

        $quoteColor = 'text-gray-300 border-amber-500';
        $focusHeading = 'text-gray-400';
        $focusBadge = 'text-white font-medium bg-white/10 border-white/20';
        $techHeading = 'text-gray-400';
    }
@endphp

<div
    class="{{ $cardBg }} rounded-3xl p-8 shadow-xl relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300">
    <div class="absolute {{ $bgIconPosition }} right-0 p-8 {{ $bgIconColor }} transition-opacity">
        <i class="fa-solid {{ $bgIcon }} text-9xl"></i>
    </div>

    <div class="relative z-10">
        <div class="flex flex-col sm:flex-row gap-6 items-center sm:items-start mb-6">
            <div class="w-28 h-28 rounded-2xl overflow-hidden border-4 {{ $avatarBorder }} shadow-lg flex-shrink-0">
                <img src="{{ $avatar }}" alt="{{ $name }}" class="w-full h-full object-cover">
            </div>
            <div class="text-center sm:text-left mt-2">
                <h3 class="text-2xl font-black {{ $nameColor }}">{{ $name }}</h3>
                <p class="{{ $roleColor }} font-bold tracking-wide text-sm mb-3">{{ $role }}</p>

                <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                    <a href="{{ $igLink }}" target="_blank"
                        class="inline-flex items-center transition-colors text-xs px-3 py-1.5 rounded-full font-medium {{ $socialBtnClasses }}">
                        <i class="fa-brands fa-instagram mr-1.5 {{ $igIconColor }} text-sm"></i> {{ $igHandle }}
                    </a>
                    <a href="{{ $githubLink }}" target="_blank"
                        class="inline-flex items-center transition-colors text-xs px-3 py-1.5 rounded-full font-medium {{ $socialBtnClasses }}">
                        <i class="fa-brands fa-github mr-1.5 {{ $githubIconColor }} text-sm"></i> {{ $githubHandle }}
                    </a>
                </div>
            </div>
        </div>

        <blockquote class="italic mb-6 border-l-4 pl-4 py-1 {{ $quoteColor }}">
            "{{ $quote }}"
        </blockquote>

        <div class="space-y-4">
            <div>
                <span class="text-xs uppercase tracking-wider font-bold block mb-2 {{ $focusHeading }}">Fokus
                    Utama</span>
                <span class="text-sm px-3 py-1 rounded border {{ $focusBadge }}">{{ $focus }}</span>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider font-bold block mb-2 {{ $techHeading }}">Tech
                    Stack</span>
                <div class="flex flex-wrap gap-2">
                    {{ $techStack }}
                </div>
            </div>
        </div>
    </div>
</div>
