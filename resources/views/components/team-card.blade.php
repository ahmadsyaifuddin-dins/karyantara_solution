@props(['codename', 'role', 'icon' => 'fa-user-ninja'])

<div
    class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 group relative overflow-hidden flex flex-col items-center text-center">
    <div
        class="absolute -right-4 -top-4 text-gray-50 opacity-50 group-hover:opacity-100 transition-opacity duration-500">
        <i class="fa-solid {{ $icon }} text-8xl"></i>
    </div>

    <div
        class="relative z-10 w-20 h-20 bg-gradient-to-br from-gray-700 to-[#1E293B] rounded-full flex items-center justify-center shadow-md mb-4 border-2 border-dashed border-gray-300 group-hover:border-amber-500 transition-colors">
        <i class="fa-solid {{ $icon }} text-2xl text-gray-300 group-hover:text-amber-400 transition-colors"></i>
    </div>

    <div class="relative z-10">
        <h4 class="text-lg font-bold text-[#1E293B] mb-1 font-mono tracking-wider">{{ $codename }}</h4>
        <p class="text-amber-600 font-semibold text-xs uppercase tracking-widest mb-3">{{ $role }}</p>

        <div
            class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 text-gray-500 text-[10px] font-medium rounded-full uppercase">
            <i class="fa-solid fa-lock text-[9px]"></i> Identitas Disembunyikan
        </div>
    </div>
</div>
