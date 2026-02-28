<div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 lg:hidden"
    @click="sidebarOpen = false" style="display: none;">
</div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-[#1E293B] text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto flex flex-col shadow-xl">

    <div class="flex items-center justify-center h-20 border-b border-gray-700/50">
        <a href="{{ route('admin.dashboard') }}"
            class="text-2xl font-bold text-white tracking-wider hover:scale-105 transition transform">
            Karyantara<span class="text-amber-500">.</span>
        </a>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-[#1E293B] font-bold shadow-md' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:translate-x-1' }}">
            <i class="fa-solid fa-gauge-high w-5 text-center text-lg"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.admins.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.admins.*') ? 'bg-amber-500 text-[#1E293B] font-bold shadow-md' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:translate-x-1' }}">
            <i class="fa-solid fa-users-gear w-5 text-center text-lg"></i>
            <span>Kelola Admin</span>
        </a>

        <a href="{{ route('admin.testimonials.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.testimonials.*') ? 'bg-amber-500 text-[#1E293B] font-bold shadow-md' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:translate-x-1' }}">
            <i class="fa-solid fa-comments w-5 text-center text-lg"></i>
            <span>Testimonial</span>
        </a>

        <div class="pt-4 mt-4 border-t border-gray-700/50">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Manajemen Konten</p>
            <a href="{{ route('admin.portfolios.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.portfolios.*') ? 'bg-amber-500 text-[#1E293B] font-bold shadow-md' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:translate-x-1' }}">
                <i class="fa-solid fa-briefcase w-5 text-center text-lg"></i>
                <span>Portofolio</span>
            </a>
        </div>

        <div class="pt-4 mt-4 border-t border-gray-700/50">
            <a href="{{ route('home') }}" target="_blank"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 text-gray-300 hover:bg-amber-500 hover:text-[#1E293B] hover:font-bold hover:translate-x-1 group">
                <i
                    class="fa-solid fa-arrow-up-right-from-square w-5 text-center text-lg transition-transform group-hover:scale-110"></i>
                <span>Lihat Publik</span>
            </a>
        </div>

    </nav>

    <div class="p-4 border-t border-gray-700/50 bg-[#151D2A]">
        <div class="flex items-center gap-3 px-2 py-2">
            <div
                class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-[#1E293B] font-extrabold text-lg shadow-inner">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="flex flex-col overflow-hidden">
                <span class="text-sm font-bold truncate">{{ Auth::user()->name }}</span>
                <span class="text-xs text-amber-500"><i class="fa-solid fa-shield-halved mr-1"></i> Administrator</span>
            </div>
        </div>
    </div>
</aside>
