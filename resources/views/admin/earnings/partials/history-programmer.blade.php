<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col max-h-[600px]">
    <div class="px-6 py-5 border-b border-blue-100 bg-blue-50/30 flex items-center justify-between sticky top-0 z-10">
        <h3 class="font-bold text-[#1E293B]"><i class="fa-solid fa-code text-blue-500 mr-2"></i> Histori Developer
            Aplikasi</h3>
        <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-md font-bold">
            {{ $appProjects->count() + $umumProjects->count() }} Proyek
        </span>
    </div>

    <div class="divide-y divide-gray-100 overflow-y-auto flex-1">

        @foreach ($appProjects as $project)
            <div
                class="p-5 hover:bg-gray-50 transition-colors {{ !$project->is_programmer_paid ? 'bg-red-50/10' : '' }}">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span
                            class="inline-block bg-blue-100 text-blue-700 text-[9px] px-2 py-0.5 rounded font-bold uppercase tracking-wider mb-1">Skripsi</span>
                        <h4 class="font-bold text-[#1E293B] text-sm">{{ $project->client_name }}</h4>
                    </div>
                    <span class="font-black text-blue-600">Rp
                        {{ number_format($project->app_price, 0, ',', '.') }}</span>
                </div>
                <p class="text-xs text-gray-500 line-clamp-1 mb-2">
                    {{ $project->skripsi_title ?? $project->project_description }}
                </p>

                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-[11px] font-medium flex items-center gap-2">
                        @php
                            $statusColors = [
                                'Pending' => 'bg-gray-100 text-gray-800 border-gray-200',
                                'Progress' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'Revisi' => 'bg-amber-100 text-amber-800 border-amber-200 animate-pulse',
                                'Selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            ];
                            $colorClass =
                                $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                        @endphp
                        <span class="px-2 py-0.5 rounded border shadow-sm {{ $colorClass }}">
                            {{ $project->status }}
                        </span>

                        @if ($project->is_programmer_paid)
                            <span class="text-emerald-600 bg-emerald-50 px-2 py-1 rounded"><i
                                    class="fa-solid fa-check-double mr-1"></i> Cair</span>
                        @else
                            <span class="text-red-500 bg-red-50 px-2 py-1 rounded"><i
                                    class="fa-solid fa-clock mr-1"></i> Belum Cair</span>
                        @endif
                    </div>

                    <form action="{{ route('admin.earnings.toggle-paid', $project->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="type" value="programmer">
                        <button type="submit"
                            class="text-[10px] px-3 py-1.5 rounded font-bold shadow-sm transition-all focus:ring-2 focus:outline-none 
                            {{ $project->is_programmer_paid ? 'bg-white border border-gray-200 text-gray-500 hover:bg-gray-100' : 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-300' }}">
                            {{ $project->is_programmer_paid ? 'Batalkan' : 'Tandai Cair' }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        @foreach ($umumProjects as $project)
            @php
                // Ekstrak data spesifik user dari JSON
                $team = is_string($project->custom_team)
                    ? json_decode($project->custom_team, true)
                    : $project->custom_team;
                $myFee = 0;
                $isPaid = false;
                $myRole = 'Developer';

                if (is_array($team)) {
                    foreach ($team as $member) {
                        if (isset($member['user_id']) && $member['user_id'] == auth()->id()) {
                            $myFee = $member['fee'] ?? 0;
                            $isPaid = $member['is_paid'] ?? false; // Ambil status is_paid dari JSON
                            $myRole = $member['role'] ?? 'Developer';
                            break;
                        }
                    }
                }
            @endphp

            <div class="p-5 hover:bg-gray-50 transition-colors {{ !$isPaid ? 'bg-amber-50/20' : '' }}">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span
                            class="inline-block bg-[#1E293B] text-amber-400 border border-slate-600 text-[9px] px-2 py-0.5 rounded font-bold uppercase tracking-wider mb-1">Corporate</span>
                        <h4 class="font-bold text-[#1E293B] text-sm">{{ $project->client_name }}</h4>
                    </div>
                    <span class="font-black text-amber-600">Rp {{ number_format($myFee, 0, ',', '.') }}</span>
                </div>
                <p class="text-xs text-gray-500 line-clamp-1 mb-2">
                    <span class="font-semibold text-slate-700">Role: {{ $myRole }}</span> -
                    {{ $project->project_description }}
                </p>

                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-[11px] font-medium flex items-center gap-2">
                        @php
                            $colorClass =
                                $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                        @endphp
                        <span class="px-2 py-0.5 rounded border shadow-sm {{ $colorClass }}">
                            {{ $project->status }}
                        </span>

                        @if ($isPaid)
                            <span class="text-emerald-600 bg-emerald-50 px-2 py-1 rounded"><i
                                    class="fa-solid fa-check-double mr-1"></i> Cair</span>
                        @else
                            <span class="text-red-500 bg-red-50 px-2 py-1 rounded"><i
                                    class="fa-solid fa-clock mr-1"></i> Belum Cair</span>
                        @endif
                    </div>

                    <form action="{{ route('admin.earnings.toggle-paid', $project->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="type" value="umum"> <button type="submit"
                            class="text-[10px] px-3 py-1.5 rounded font-bold shadow-sm transition-all focus:ring-2 focus:outline-none 
                            {{ $isPaid ? 'bg-white border border-gray-200 text-gray-500 hover:bg-gray-100' : 'bg-[#1E293B] text-amber-400 hover:bg-slate-800 focus:ring-slate-500' }}">
                            {{ $isPaid ? 'Batalkan' : 'Tandai Cair' }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        @if ($appProjects->isEmpty() && $umumProjects->isEmpty())
            <div class="p-8 text-center text-gray-400">
                <i class="fa-solid fa-ghost text-3xl mb-3"></i>
                <p class="text-sm">Belum ada histori proyek.</p>
            </div>
        @endif
    </div>
</div>
