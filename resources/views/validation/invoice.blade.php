<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Invoice - Karyantara Solution</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 font-sans">

    <div class="bg-white rounded-3xl shadow-xl max-w-md w-full overflow-hidden border border-gray-100">
        <div class="bg-emerald-500 p-6 text-center">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg">
                <i class="fa-solid fa-check-to-slot text-4xl text-emerald-500"></i>
            </div>
            <h2 class="text-white font-bold text-xl uppercase tracking-wider">Dokumen Valid</h2>
            <p class="text-emerald-100 text-sm mt-1">Diterbitkan oleh <span class="font-bold text-white">Karyantara
                    Solution</span></p>
        </div>

        <div class="p-6">
            <div class="space-y-5">

                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Nama Klien</p>
                    <p class="font-bold text-[#1E293B] text-lg">{{ $project->client_name }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Tipe Klien</p>
                        <span
                            class="inline-flex items-center mt-1 px-2.5 py-1 text-[10px] font-bold bg-slate-100 text-slate-700 rounded-md uppercase border border-slate-200">
                            <i class="fa-solid fa-user-tag mr-1.5 text-slate-400"></i> {{ $project->client_type }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Status Proyek</p>
                        <span
                            class="inline-block mt-1 px-2.5 py-1 text-[10px] font-bold rounded-md uppercase border
                            {{ $project->status == 'Selesai' ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : ($project->status == 'Progress' ? 'bg-blue-100 text-blue-700 border-blue-200' : 'bg-amber-100 text-amber-700 border-amber-200') }}">
                            {{ $project->status }}
                        </span>
                    </div>
                </div>

                @if ($project->skripsi_package)
                    @php
                        $isSempro = str_starts_with($project->skripsi_package, 'sempro_');
                        $isSidang = str_starts_with($project->skripsi_package, 'sidang_');

                        if ($isSempro) {
                            $badgeClass = 'bg-teal-50 text-teal-700 border border-teal-200';
                            $iconClass = 'fa-file-lines text-teal-500';
                        } elseif ($isSidang) {
                            $badgeClass = 'bg-purple-50 text-purple-700 border border-purple-200';
                            $iconClass = 'fa-medal text-purple-500';
                        } else {
                            $badgeClass = 'bg-amber-50 text-amber-700 border border-amber-200';
                            $iconClass = 'fa-graduation-cap text-amber-500';
                        }
                    @endphp
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Paket Pengerjaan</p>
                        <span
                            class="inline-flex items-center mt-1 px-3 py-1.5 text-[10px] font-bold {{ $badgeClass }} rounded-md uppercase shadow-sm">
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
                    </div>
                @endif

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-3">Tim Karyantara</p>

                    <div class="flex flex-col gap-3">
                        <div class="flex items-center bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                            <div
                                class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center mr-3 shrink-0">
                                <i class="fa-solid fa-headset text-slate-500 text-sm"></i>
                            </div>
                            <div>
                                <p
                                    class="text-[10px] text-slate-500 font-bold uppercase tracking-wider leading-none mb-1">
                                    Admin Pengelola</p>
                                <p class="font-bold text-[#1E293B] text-sm">
                                    {{ $project->admin->name ?? 'Tim Karyantara' }}</p>
                            </div>
                        </div>

                        @if ($project->programmer_id)
                            <div class="flex items-center bg-blue-50 p-2.5 rounded-lg border border-blue-100">
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-200 flex items-center justify-center mr-3 shrink-0">
                                    <i class="fa-solid fa-code text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <p
                                        class="text-[10px] text-blue-600 font-bold uppercase tracking-wider leading-none mb-1">
                                        Developer Aplikasi</p>
                                    <p class="font-bold text-blue-800 text-sm">
                                        {{ $project->programmer->name ?? 'Unknown' }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($project->writer_id)
                            <div class="flex items-center bg-amber-50 p-2.5 rounded-lg border border-amber-100">
                                <div
                                    class="w-8 h-8 rounded-full bg-amber-200 flex items-center justify-center mr-3 shrink-0">
                                    <i class="fa-solid fa-file-word text-amber-600 text-sm"></i>
                                </div>
                                <div>
                                    <p
                                        class="text-[10px] text-amber-600 font-bold uppercase tracking-wider leading-none mb-1">
                                        Penyusun Naskah</p>
                                    <p class="font-bold text-amber-800 text-sm">
                                        {{ $project->writer->name ?? 'Unknown' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Detail Pekerjaan</p>
                    <p
                        class="text-sm text-gray-700 mt-1.5 leading-relaxed bg-gray-50 p-3 rounded-lg border border-gray-100">
                        {{ $project->skripsi_title ?? $project->project_description }}
                    </p>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Status Keuangan</p>
                        @if ($project->is_paid_off)
                            <p class="font-black text-emerald-500 mt-1 flex items-center">
                                <i class="fa-solid fa-circle-check mr-1.5"></i> LUNAS
                            </p>
                        @else
                            <p class="font-black text-amber-500 mt-1 flex items-center">
                                <i class="fa-solid fa-clock mr-1.5"></i> BELUM LUNAS
                            </p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Nilai</p>
                        <p class="font-bold text-gray-800 mt-1">Rp
                            {{ number_format($project->net_income, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center text-[10px] text-gray-400">
                <p>Waktu Pemindaian: {{ \Carbon\Carbon::now()->timezone('Asia/Makassar')->format('d M Y, H:i') }} WITA
                </p>
                <p class="mt-1 font-semibold">&copy; {{ date('Y') }} Karyantara Solution</p>
            </div>
        </div>
    </div>

</body>

</html>
