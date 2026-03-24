<div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
    <h3 class="font-bold text-[#1E293B]">
        <i class="fa-solid fa-fire text-amber-500 mr-2"></i> Proyek Prioritas
    </h3>
    <a href="{{ route('admin.projects.index') ?? '#' }}" class="text-sm font-bold text-blue-600 hover:text-blue-800">Lihat Semua &rarr;</a>
</div>

<div class="overflow-x-auto flex-1">
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-white">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider w-16">No</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Klien</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Harga/Net</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($priorityProjects ?? [] as $index => $project)
                <tr class="hover:bg-gray-50 transition-colors">
                    
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-500 text-xs font-bold">
                            {{ $project->sort_order ?? ($index + 1) }}
                        </span>
                    </td>

                    <td class="px-6 py-4">
                        <div class="font-bold text-[#1E293B]">{{ $project->client_name }}</div>
                        <div class="text-xs text-gray-500 mt-0.5 truncate max-w-[250px]">{{ $project->project_description }}</div>
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
                        <span class="px-3 py-1 text-[11px] font-bold rounded-full {{ $badgeColors[$project->status] ?? 'bg-gray-100' }}">
                            {{ $project->status }}
                        </span>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="font-bold text-[#1E293B]">Rp {{ number_format($project->net_income, 0, ',', '.') }}</div>
                        @if ($project->is_paid_off)
                            <span class="text-[10px] font-bold text-emerald-500"><i class="fa-solid fa-check-double mr-1"></i>Lunas</span>
                        @else
                            <span class="text-[10px] font-bold text-red-500">Sisa: Rp {{ number_format($project->remaining_amount, 0, ',', '.') }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada proyek aktif.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>