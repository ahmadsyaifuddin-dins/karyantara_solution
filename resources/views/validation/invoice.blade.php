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
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Nama Klien</p>
                    <p class="font-bold text-gray-800 text-lg">{{ $project->client_name }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Tipe Klien</p>
                        <span
                            class="inline-block mt-1 px-2.5 py-1 text-[10px] font-bold bg-blue-100 text-blue-700 rounded-md uppercase">
                            {{ $project->client_type }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Status Proyek</p>
                        <span
                            class="inline-block mt-1 px-2.5 py-1 text-[10px] font-bold rounded-md uppercase
                            {{ $project->status == 'Selesai' ? 'bg-emerald-100 text-emerald-700' : ($project->status == 'Progress' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ $project->status }}
                        </span>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Penanggung Jawab / Developer
                        (PIC)</p>
                    <p class="font-bold text-gray-800 mt-1 flex items-center">
                        <i class="fa-solid fa-user-tie text-blue-500 mr-2"></i>
                        {{ $project->admin->name ?? 'Tim Karyantara Solution' }}
                        <span class="text-[10px] font-normal text-gray-400 ml-2">(ADM-{{ $project->admin_id }})</span>
                    </p>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Detail Pekerjaan</p>
                    <p class="text-sm text-gray-700 mt-1 leading-relaxed">
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

            <div class="mt-8 text-center text-xs text-gray-400">
                <p>Waktu Pemindaian: {{ \Carbon\Carbon::now()->timezone('Asia/Makassar')->format('d M Y, H:i') }} WITA
                </p>
                <p class="mt-1 font-semibold">&copy; {{ date('Y') }} Karyantara Solution</p>
            </div>
        </div>
    </div>

</body>

</html>
