<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#1E293B] leading-tight">
            Selamat Datang, {{ Auth::user()->name }}! 👋
        </h2>
        <p class="text-sm text-gray-500 mt-1">Berikut adalah ringkasan performa Karyantara Solution hari ini.</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div
                    class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4 hover:-translate-y-1 transition-transform">
                    <div
                        class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 text-2xl shrink-0">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pendapatan</p>
                        <h3 class="text-xl font-black text-[#1E293B] mt-1">Rp
                            {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4 hover:-translate-y-1 transition-transform">
                    <div
                        class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 text-2xl shrink-0">
                        <i class="fa-solid fa-laptop-code"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Proyek Berjalan</p>
                        <h3 class="text-2xl font-black text-[#1E293B] mt-1">{{ $activeProjects }} <span
                                class="text-sm text-gray-400 font-medium">Proyek</span></h3>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4 hover:-translate-y-1 transition-transform">
                    <div
                        class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 text-2xl shrink-0">
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Review Pending</p>
                        <h3 class="text-2xl font-black text-[#1E293B] mt-1">{{ $pendingTestimonials }} <span
                                class="text-sm text-gray-400 font-medium">Ulasan</span></h3>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4 hover:-translate-y-1 transition-transform">
                    <div
                        class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-500 text-2xl shrink-0">
                        <i class="fa-solid fa-chart-simple"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Tayangan</p>
                        <h3 class="text-2xl font-black text-[#1E293B] mt-1">
                            {{ number_format($totalVisitors, 0, ',', '.') }} <span
                                class="text-sm text-gray-400 font-medium">Views</span></h3>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div
                    class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="font-bold text-[#1E293B]"><i
                                class="fa-solid fa-clock-rotate-left text-amber-500 mr-2"></i> Proyek Terbaru</h3>
                        <a href="{{ route('admin.projects.index') }}"
                            class="text-sm font-bold text-blue-600 hover:text-blue-800">Lihat Semua &rarr;</a>
                    </div>

                    <div class="overflow-x-auto flex-1">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-white">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Klien</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Harga/Net</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($recentProjects as $project)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-[#1E293B]">{{ $project->client_name }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5 truncate max-w-[250px]">
                                                {{ $project->project_description }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $badgeColors = [
                                                    'Pending' => 'bg-gray-100 text-gray-800',
                                                    'Progress' => 'bg-blue-100 text-blue-800',
                                                    'Revisi' => 'bg-amber-100 text-amber-800',
                                                    'Selesai' => 'bg-emerald-100 text-emerald-800',
                                                ];
                                            @endphp
                                            <span
                                                class="px-3 py-1 text-[11px] font-bold rounded-full {{ $badgeColors[$project->status] ?? 'bg-gray-100' }}">
                                                {{ $project->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="font-bold text-[#1E293B]">Rp
                                                {{ number_format($project->net_income, 0, ',', '.') }}</div>
                                            @if ($project->is_paid_off)
                                                <span class="text-[10px] font-bold text-green-500"><i
                                                        class="fa-solid fa-check-double mr-1"></i>Lunas</span>
                                            @else
                                                <span class="text-[10px] font-bold text-red-500">Sisa: Rp
                                                    {{ number_format($project->remaining_amount, 0, ',', '.') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada
                                            proyek ditambahkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div
                    class="lg:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-[#1E293B]"><i
                                class="fa-solid fa-users-viewfinder text-blue-500 mr-2"></i> Aktivitas Admin</h3>
                    </div>

                    <div class="p-6 space-y-5">
                        @foreach ($onlineAdmins as $admin)
                            @php
                                // Cek apakah sesi terakhir ada dan apakah masih aktif (dalam 15 menit terakhir)
                                $isOnline = false;
                                $lastSeenText = 'Belum pernah login';

                                if ($admin->last_seen) {
                                    $lastActivity = \Carbon\Carbon::createFromTimestamp($admin->last_seen);
                                    $isOnline = $lastActivity->diffInMinutes(now()) <= 15; // Online jika aktif < 15 menit lalu
                                    $lastSeenText = $isOnline
                                        ? 'Sedang Online'
                                        : $lastActivity->locale('id')->diffForHumans();
                                }
                            @endphp

                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=random&color=fff"
                                        alt="Avatar" class="w-10 h-10 rounded-full shadow-sm">

                                    <span
                                        class="absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-white {{ $isOnline ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                                </div>

                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-[#1E293B] leading-tight">
                                        {{ $admin->name }}
                                        @if (Auth::id() == $admin->id)
                                            <span
                                                class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded ml-1">Anda</span>
                                        @endif
                                    </h4>
                                    <p
                                        class="text-xs {{ $isOnline ? 'text-green-600 font-medium' : 'text-gray-400' }} mt-0.5">
                                        {{ $lastSeenText }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
