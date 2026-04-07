{{-- Backdrop untuk Mobile --}}
<div x-cloak x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 md:hidden"
    @click="sidebarOpen = false">
</div>

{{-- Sidebar Utama --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-72 shrink-0 bg-[#1E293B] text-white transition-transform duration-300 ease-in-out md:relative md:translate-x-0 -translate-x-full flex flex-col shadow-xl">

    {{-- Logo Header --}}
    <div class="flex items-center justify-center h-20 border-b border-gray-700/50 shrink-0">
        <a href="{{ route('admin.dashboard') }}"
            class="text-2xl font-bold text-white tracking-wider hover:scale-105 transition transform">
            Karyantara Solution<span class="text-amber-500">.</span>
        </a>
    </div>

    {{-- DYNAMIC NAVIGATION MENGGUNAKAN CONFIG --}}
    <nav class="flex-1 px-4 py-6 space-y-4 overflow-y-auto">

        @foreach (config('navigation.groups') as $index => $group)
            <div class="{{ $index > 0 ? 'pt-4 border-t border-gray-700/50 space-y-2' : 'space-y-2' }}">

                {{-- Tampilkan Heading Grup Jika Ada --}}
                @if ($group['heading'])
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        {{ $group['heading'] }}
                    </p>
                @endif

                {{-- Looping Item Menu dalam Grup --}}
                @foreach ($group['items'] as $item)
                    @can($item['permission'])
                        @php
                            // Cek apakah route sedang aktif (mendukung pemisah '|' untuk multi-route)
                            $isActive = false;
                            $matches = explode('|', $item['active_match']);
                            foreach ($matches as $match) {
                                if (request()->routeIs($match)) {
                                    $isActive = true;
                                    break;
                                }
                            }
                        @endphp

                        {{-- Handle Menu Spesial: Kalkulator AI (Efek Glowing) --}}
                        @if (isset($item['is_special']) && $item['is_special'])
                            <a href="{{ route($item['route']) }}"
                                class="electric-menu flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-300 {{ $isActive ? 'bg-amber-500 text-[#1E293B] font-bold shadow-[0_0_15px_rgba(245,158,11,0.6)]' : 'bg-[#1E293B]/50 text-amber-400 hover:text-white hover:bg-slate-800' }} group">
                                <i
                                    class="{{ $item['icon'] }} w-5 text-center text-lg relative z-10 group-hover:animate-ping duration-75"></i>
                                <span class="relative z-10 font-semibold tracking-wide">{{ $item['title'] }}</span>
                                <span
                                    class="ml-auto bg-amber-500 text-[#1E293B] text-[10px] font-extrabold px-2 py-0.5 rounded-full shadow-[0_0_8px_rgba(245,158,11,0.8)] animate-pulse relative z-10">
                                    <i class="fa-solid fa-bolt text-[#1E293B] mr-0.5"></i> AI
                                </span>
                            </a>

                            {{-- Handle Menu Normal --}}
                        @else
                            <a href="{{ route($item['route']) }}"
                                class="flex items-center justify-between px-4 py-3 rounded-lg transition-all duration-200 {{ $isActive ? 'bg-amber-500 text-[#1E293B] font-bold shadow-md' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:translate-x-1' }}">

                                <div class="flex items-center gap-3">
                                    <i class="{{ $item['icon'] }} w-5 text-center text-lg"></i>
                                    <span>{{ $item['title'] }}</span>
                                </div>

                                {{-- Handle Fitur Badge (Misal untuk Testimonial Pending) --}}
                                @if (isset($item['has_badge']) && $item['has_badge'])
                                    @php
                                        $pendingCount = \App\Models\Testimonial::where('is_approved', 0)->count();
                                    @endphp

                                    @if ($pendingCount > 0)
                                        <span
                                            class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full shadow-sm animate-pulse">
                                            {{ $pendingCount > 99 ? '99+' : $pendingCount }}
                                        </span>
                                    @endif
                                @endif

                            </a>
                        @endif
                    @endcan
                @endforeach
            </div>
        @endforeach

    </nav>
    {{-- END DYNAMIC NAVIGATION --}}

    {{-- Footer Sidebar (Profile & Link Publik) --}}
    <div class="mt-auto shrink-0">
        <div class="px-4 pb-4">
            <a href="{{ route('home') }}" target="_blank"
                class="flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-gray-800/50 border border-gray-700 text-gray-300 hover:bg-amber-500 hover:text-[#1E293B] hover:border-amber-500 transition-all duration-200 font-medium group">
                <i
                    class="fa-solid fa-arrow-up-right-from-square transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5"></i>
                <span>Lihat Publik</span>
            </a>
        </div>

        <div class="p-4 border-t border-gray-700/50 bg-[#151D2A]">
            <div class="flex items-center gap-3 px-2 py-2">
                <div
                    class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-[#1E293B] font-extrabold text-lg shadow-inner shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex flex-col overflow-hidden">
                    <span class="text-sm font-bold truncate">{{ Auth::user()->name }}</span>

                    {{-- Role Spatie Dinamis --}}
                    @php
                        $userRole = Auth::user()->roles->pluck('name')->first();
                        $displayRole = $userRole ? ucwords(str_replace('_', ' ', $userRole)) : 'User';
                    @endphp
                    <span class="text-xs text-amber-500">
                        <i class="fa-solid fa-shield-halved mr-1"></i> {{ $displayRole }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</aside>
