<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight flex items-center">
                <i class="fa-solid fa-chart-line text-amber-500 mr-3"></i> {{ __('Monitoring Pengunjung (Unique IP)') }}
            </h2>
            <div class="bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mr-3 border-r pr-3">Total Seluruh
                    Tayangan:</span>
                <span
                    class="text-lg font-extrabold text-[#1E293B]">{{ number_format($totalUniqueVisitors, 0, ',', '.') }}
                    <span class="text-sm font-medium text-gray-400">Views</span></span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($pageStats as $stat)
                    <div
                        class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col relative overflow-hidden group hover:shadow-md transition-shadow">
                        <div
                            class="absolute -right-6 -top-6 text-gray-50 text-7xl pointer-events-none group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>

                        <div class="relative z-10">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Halaman</h3>
                            <p class="text-xl font-extrabold text-[#1E293B] mb-4 capitalize">/{{ $stat->page_name }}</p>

                            <div class="flex items-end justify-between mt-auto">
                                <div>
                                    <span
                                        class="text-3xl font-black text-amber-500">{{ number_format($stat->total_views, 0, ',', '.') }}</span>
                                    <span class="text-sm font-medium text-gray-500 ml-1">Views</span>
                                </div>
                                <div class="text-xs text-gray-400 text-right" title="Kunjungan Terakhir">
                                    <i class="fa-solid fa-clock mr-1"></i><br>
                                    {{ \Carbon\Carbon::parse($stat->last_viewed)->locale('id')->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-8 rounded-xl text-center text-gray-500 border border-gray-100">
                        Belum ada data pengunjung yang terekam.
                    </div>
                @endforelse
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-[#1E293B]"><i class="fa-solid fa-list-ul text-gray-400 mr-2"></i>
                        Log Aktivitas Pengunjung Terbaru</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Waktu Kunjungan</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Halaman</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    IP & Network</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Device & Browser</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($recentLogs as $log)
                                <tr class="hover:bg-amber-50/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="font-medium text-[#1E293B]">
                                            {{ $log->created_at->locale('id')->translatedFormat('d F Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }} WITA
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            /{{ $log->page_name }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-mono text-[#1E293B] font-bold">
                                            <i class="fa-solid fa-network-wired text-amber-500 mr-1 text-xs"></i>
                                            {{ $log->ip_address }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 truncate max-w-[200px]"
                                            title="{{ $log->isp }}">
                                            <i class="fa-solid fa-tower-cell mr-1"></i> {{ $log->isp ?? '-' }}
                                        </div>
                                        <div class="text-xs text-gray-400 mt-0.5 truncate max-w-[200px]">
                                            <i class="fa-solid fa-location-dot mr-1 text-red-400"></i>
                                            {{ $log->location ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-[#1E293B] font-medium">
                                            @if ($log->device_type == 'Mobile')
                                                <i class="fa-solid fa-mobile-screen-button text-gray-500 mr-2"></i>
                                            @else
                                                <i class="fa-solid fa-desktop text-gray-500 mr-2"></i>
                                            @endif
                                            {{ $log->os ?? 'Unknown' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            <i
                                                class="fa-brands 
                                {{ strtolower($log->browser) == 'chrome'
                                    ? 'fa-chrome text-green-500'
                                    : (strtolower($log->browser) == 'safari'
                                        ? 'fa-safari text-blue-500'
                                        : (strtolower($log->browser) == 'firefox'
                                            ? 'fa-firefox text-orange-500'
                                            : (strtolower($log->browser) == 'edge'
                                                ? 'fa-edge text-blue-600'
                                                : 'fa-internet-explorer text-gray-400'))) }} mr-1">
                                            </i>
                                            {{ $log->browser ?? '-' }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                        Tidak ada data log aktivitas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($recentLogs->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $recentLogs->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
