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
                        class="bg-white rounded-2xl p-6 shadow-sm border {{ $stat->is_portfolio ? 'border-amber-200 bg-amber-50/10' : 'border-gray-100' }} flex flex-col relative overflow-hidden group hover:shadow-md transition-all duration-300 hover:-translate-y-1">

                        <div
                            class="absolute -right-6 -top-6 text-7xl pointer-events-none group-hover:scale-110 transition-transform {{ $stat->is_portfolio ? 'text-amber-500/5' : 'text-gray-100' }}">
                            <i class="fa-solid {{ $stat->is_portfolio ? 'fa-briefcase' : 'fa-file-lines' }}"></i>
                        </div>

                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-2">
                                <h3
                                    class="text-xs font-bold uppercase tracking-wider {{ $stat->is_portfolio ? 'text-amber-500' : 'text-gray-400' }}">
                                    {{ $stat->is_portfolio ? 'Karya Portofolio' : 'Halaman Umum' }}
                                </h3>
                            </div>

                            <p class="text-lg font-extrabold text-[#1E293B] mb-1 truncate"
                                title="{{ $stat->display_name }}">
                                {{ $stat->display_name }}
                            </p>

                            @if ($stat->owner_name)
                                <p
                                    class="text-[11px] font-bold text-gray-500 mb-4 bg-white px-2 py-1 rounded-md inline-block border border-gray-100 shadow-sm">
                                    <i class="fa-solid fa-code text-amber-500 mr-1"></i> Dev: {{ $stat->owner_name }}
                                </p>
                            @else
                                <div class="mb-4 h-6"></div>
                            @endif

                            <div class="flex items-end justify-between mt-auto">
                                <div>
                                    <span
                                        class="text-3xl font-black {{ $stat->is_portfolio ? 'text-amber-600' : 'text-[#1E293B]' }}">{{ number_format($stat->total_views, 0, ',', '.') }}</span>
                                    <span class="text-xs font-bold text-gray-400 ml-1 uppercase">Views</span>
                                </div>
                                <div class="text-[10px] text-gray-400 text-right leading-tight"
                                    title="Kunjungan Terakhir">
                                    <i class="fa-solid fa-clock mr-0.5"></i> Terakhir<br>
                                    <span
                                        class="font-medium text-gray-500">{{ \Carbon\Carbon::parse($stat->last_viewed)->locale('id')->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-10 rounded-2xl text-center border border-gray-100 shadow-sm">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-eye-slash text-4xl text-gray-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#1E293B] mb-2">Belum Ada Data</h3>
                        <p class="text-gray-500">Belum ada pengunjung yang terekam di sistem.</p>
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
                                    Identitas</th>
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
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ str_starts_with($log->page_name, 'portfolio_') ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                            <i
                                                class="fa-solid {{ str_starts_with($log->page_name, 'portfolio_') ? 'fa-briefcase' : 'fa-file' }} mr-1.5 mt-0.5"></i>
                                            {{ $log->display_name }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($log->visitor_type == 'Admin')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-800 border border-indigo-200">
                                                <i class="fa-solid fa-user-shield mr-1"></i> ADMIN
                                            </span>
                                            <div class="text-sm font-bold text-gray-900 mt-1">
                                                {{ $log->visitor_name ?? 'Admin System' }}</div>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                                <i class="fa-solid fa-user-astronaut mr-1"></i> GUEST
                                            </span>
                                            <div class="text-sm font-medium text-gray-500 mt-1">Publik / Klien</div>
                                        @endif
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

                                    <td class="px-6 py-4 whitespace-nowrap align-top">
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
                                                class="fa-brands {{ strtolower($log->browser) == 'chrome' ? 'fa-chrome text-green-500' : (strtolower($log->browser) == 'safari' ? 'fa-safari text-blue-500' : (strtolower($log->browser) == 'firefox' ? 'fa-firefox text-orange-500' : (strtolower($log->browser) == 'edge' ? 'fa-edge text-blue-600' : 'fa-internet-explorer text-gray-400'))) }} mr-1"></i>
                                            {{ $log->browser ?? '-' }}
                                        </div>

                                        @if ($log->raw_user_agent)
                                            <details class="group mt-2">
                                                <summary
                                                    class="text-[10px] text-blue-500 cursor-pointer list-none flex items-center font-medium hover:text-blue-700 transition-colors select-none">
                                                    <i class="fa-solid fa-circle-info mr-1"></i>
                                                    <span>Cek Raw Agent</span>
                                                    <i
                                                        class="fa-solid fa-chevron-down ml-1.5 text-[8px] transition-transform group-open:rotate-180"></i>
                                                </summary>

                                                <div
                                                    class="mt-2 p-2.5 bg-slate-50 border border-slate-200 rounded-md text-[9px] text-slate-600 font-mono whitespace-normal break-all leading-relaxed max-w-[250px] sm:max-w-xs shadow-inner">
                                                    {{ $log->raw_user_agent }}
                                                </div>
                                            </details>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
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
