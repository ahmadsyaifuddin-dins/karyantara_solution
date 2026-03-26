<div
    class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div class="flex items-center gap-4">
        <div
            class="w-16 h-16 rounded-full bg-[#1E293B] text-amber-500 flex items-center justify-center text-2xl font-black shadow-inner shrink-0">
            {{ strtoupper(substr($project->client_name, 0, 1)) }}
        </div>
        <div>
            <div class="flex flex-wrap items-center gap-3">
                <h3 class="text-2xl font-extrabold text-[#1E293B]">{{ $project->client_name }}</h3>

                @if ($project->skripsi_package)
                    @php
                        $isSempro = str_starts_with($project->skripsi_package, 'sempro_');
                        $isSidang = str_starts_with($project->skripsi_package, 'sidang_');

                        if ($isSempro) {
                            $badgeClass = 'bg-teal-100 text-teal-700 border border-teal-200';
                            $iconClass = 'fa-file-lines text-teal-500';
                        } elseif ($isSidang) {
                            $badgeClass = 'bg-purple-100 text-purple-700 border border-purple-200';
                            $iconClass = 'fa-medal text-purple-500';
                        } else {
                            $badgeClass = 'bg-amber-100 text-amber-700 border border-amber-200';
                            $iconClass = 'fa-graduation-cap text-amber-500';
                        }
                    @endphp
                    <span
                        class="{{ $badgeClass }} text-[10px] px-2.5 py-1 rounded-md font-bold uppercase tracking-wider flex items-center shadow-sm">
                        <i class="fa-solid {{ $iconClass }} mr-1.5"></i>
                        @if ($project->skripsi_package == 'keduanya')
                            Skripsi All-In (App + Naskah)
                        @elseif($project->skripsi_package == 'aplikasi')
                            Skripsi (Aplikasi Saja)
                        @elseif($project->skripsi_package == 'naskah')
                            Skripsi (Naskah Saja)
                        @elseif($project->skripsi_package == 'sempro_keduanya')
                            Sempro All-In (App + Bab 1-3)
                        @elseif($project->skripsi_package == 'sempro_naskah')
                            Sempro (Naskah Bab 1-3)
                        @elseif($project->skripsi_package == 'sempro_bab3')
                            Sempro (Naskah Khusus Bab 3)
                        @elseif($project->skripsi_package == 'sidang_aplikasi')
                            Sidang (Revisi Aplikasi)
                        @elseif($project->skripsi_package == 'sidang_naskah')
                            Sidang (Naskah Bab 4-5)
                        @elseif($project->skripsi_package == 'sidang_bab4')
                            Sidang (Naskah Khusus Bab 4)
                        @elseif($project->skripsi_package == 'sidang_keduanya')
                            Sidang All-In (Revisi App + Bab 4-5)
                        @endif
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-3 mt-1 text-sm text-gray-500 font-medium">
                <span class="flex items-center">
                    <i class="fa-solid fa-user-tag mr-1 text-gray-400"></i>
                    Klien {{ ucfirst($project->client_type) }}
                </span>
                <span class="text-gray-300">|</span>
                <span class="flex items-center">
                    <i class="fa-solid fa-calendar-day mr-1 text-gray-400"></i>
                    Masuk: {{ $project->created_at->locale('id')->translatedFormat('d F Y') }}
                </span>
            </div>
        </div>
    </div>

    <div
        class="flex flex-col items-end gap-3 w-full md:w-auto mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-gray-100">
        @php
            $badgeColors = [
                'Pending' => 'bg-gray-100 text-gray-800 border-gray-200',
                'Progress' => 'bg-blue-100 text-blue-800 border-blue-200',
                'Revisi' => 'bg-amber-100 text-amber-800 border-amber-200 animate-pulse',
                'Selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            ];
        @endphp
        <span
            class="px-4 py-1.5 border inline-flex text-sm font-bold rounded-full {{ $badgeColors[$project->status] }} shadow-sm">
            Status: {{ $project->status }}
        </span>

        <div class="flex flex-col items-end gap-2 text-xs w-full">
            <div class="flex items-center gap-2 text-gray-500 font-medium">
                <span>Admin Pengelola:</span>
                <span
                    class="text-[#1E293B] font-bold bg-slate-100 border border-slate-200 px-2 py-0.5 rounded flex items-center">
                    <i class="fa-solid fa-headset mr-1.5 text-blue-500"></i>
                    {{ $project->admin->name ?? 'Unknown' }}
                </span>
            </div>

            @if ($project->programmer_id)
                <div class="flex items-center gap-2 text-blue-600/80 font-medium mt-1">
                    <span>Pembuat Aplikasi:</span>
                    <span
                        class="text-blue-700 font-bold bg-blue-50 border border-blue-200 px-2 py-0.5 rounded flex items-center shadow-sm">
                        <i class="fa-solid fa-code mr-1.5 text-blue-500"></i>
                        {{ $project->programmer->name ?? 'Unknown' }}
                    </span>
                </div>
            @endif

            @if ($project->writer_id)
                <div class="flex items-center gap-2 text-amber-600/80 font-medium mt-0.5">
                    <span>Penulis Naskah:</span>
                    <span
                        class="text-amber-700 font-bold bg-amber-50 border border-amber-200 px-2 py-0.5 rounded flex items-center shadow-sm">
                        <i class="fa-solid fa-file-word mr-1.5 text-amber-500"></i>
                        {{ $project->writer->name ?? 'Unknown' }}
                    </span>
                </div>
            @endif

            @if ($project->client_type === 'umum' && !empty($project->custom_team))
                <div class="mt-2 pt-2 border-t border-gray-100 w-full flex flex-col items-end gap-1.5">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Tim Kustom
                        Terlibat:</span>
                    @foreach ($project->custom_team as $member)
                        @php $teamUser = \App\Models\User::find($member['user_id']); @endphp
                        @if ($teamUser)
                            <div class="flex items-center gap-2 text-indigo-600/80 font-medium">
                                <span class="text-xs">{{ $member['role'] }}:</span>
                                <span
                                    class="text-indigo-700 font-bold bg-indigo-50 border border-indigo-200 px-2 py-0.5 rounded flex items-center shadow-sm">
                                    <i class="fa-solid fa-user-gear mr-1.5 text-indigo-500"></i>
                                    {{ $teamUser->name }}
                                </span>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
