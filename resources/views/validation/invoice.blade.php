<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Dokumen - Karyantara Solution</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 font-sans">

    <div class="bg-white rounded-3xl shadow-xl max-w-md w-full overflow-hidden border border-gray-100">

        @if ($scanType === 'client')
            <div class="bg-gradient-to-br from-indigo-800 to-[#0F172A] p-8 text-center relative overflow-hidden">
                <div
                    class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg backdrop-blur-sm border border-white/20">
                        <i class="fa-solid fa-file-signature text-4xl text-indigo-300 drop-shadow-md"></i>
                    </div>
                    <h2 class="text-white font-bold text-xl uppercase tracking-wider">Persetujuan Terikat</h2>
                    <p class="text-indigo-200 text-sm mt-1 font-medium">Verifikasi Komitmen Klien</p>
                </div>
            </div>
        @else
            @if (isset($isExecutive) && $isExecutive)
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-8 text-center relative overflow-hidden">
                    <div
                        class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg backdrop-blur-sm border border-white/30">
                            <i class="fa-solid fa-certificate text-4xl text-amber-50"></i>
                        </div>
                        <h2 class="text-white font-bold text-xl uppercase tracking-wider drop-shadow-sm">Dokumen Sah
                        </h2>
                        <p class="text-amber-100 text-xs mt-1 font-medium">Diterbitkan oleh Eksekutif:</p>
                        <div
                            class="mt-3 inline-block bg-white text-amber-600 px-4 py-1.5 rounded-full text-xs font-bold shadow-md">
                            <i class="fa-solid fa-star mr-1 text-amber-400"></i> {{ $executiveRole }}
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-[#1E293B] p-8 text-center relative overflow-hidden">
                    <div class="relative z-10">
                        <div
                            class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg border border-slate-700">
                            <i class="fa-solid fa-shield-check text-4xl text-emerald-400 drop-shadow-lg"></i>
                        </div>
                        <h2 class="text-white font-bold text-xl uppercase tracking-wider">Dokumen Valid</h2>
                        <p class="text-slate-300 text-sm mt-1">Diterbitkan oleh <span class="font-bold text-white">Tim
                                Operasional Karyantara</span></p>
                    </div>
                </div>
            @endif
        @endif

        <div class="p-6">
            <div class="space-y-5">
                <div
                    class="flex justify-between items-start {{ $scanType === 'client' ? 'bg-indigo-50 p-3 rounded-lg border border-indigo-100' : '' }}">
                    <div>
                        <p
                            class="text-xs {{ $scanType === 'client' ? 'text-indigo-500' : 'text-gray-500' }} font-bold uppercase tracking-wider">
                            Nama Klien</p>
                        <p class="font-bold text-[#1E293B] text-lg">{{ $project->client_name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">ID Dokumen</p>
                        <span
                            class="bg-gray-100 text-gray-600 text-xs font-mono px-2 py-1 rounded border border-gray-200">
                            INV-{{ str_pad($project->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Tipe Klien</p>
                        <span
                            class="inline-flex items-center mt-1 px-2.5 py-1 text-[10px] font-bold bg-slate-100 text-slate-700 rounded-md uppercase border border-slate-200">
                            <i class="fa-solid fa-user-tag mr-1.5 text-slate-400"></i>
                            {{ $project->client_type }}
                            {{ $project->client_type == 'mahasiswa' && $project->npm ? ' (' . $project->npm . ')' : '' }}
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

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Detail Pekerjaan / Tuntutan</p>
                    <p
                        class="text-sm text-gray-700 mt-1.5 leading-relaxed bg-gray-50 p-3 rounded-lg border border-gray-100">
                        {{ $project->skripsi_title ?? $project->project_description }}
                    </p>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Status Keuangan</p>
                        @if ($project->is_paid_off)
                            <p class="font-black text-emerald-500 mt-1 flex items-center text-lg">
                                <i class="fa-solid fa-circle-check mr-1.5"></i> LUNAS
                            </p>
                        @else
                            <p class="font-black text-amber-500 mt-1 flex items-center text-lg animate-pulse">
                                <i class="fa-solid fa-clock mr-1.5"></i> BELUM LUNAS
                            </p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Nilai</p>
                        <p class="font-bold text-[#1E293B] mt-1 text-lg">Rp
                            {{ number_format($project->net_income, 0, ',', '.') }}</p>
                    </div>
                </div>

                @if ($scanType === 'client')
                    <div class="mt-4 bg-red-50 p-4 rounded-xl border border-red-200">
                        <p
                            class="text-xs text-red-700 font-black uppercase tracking-wider mb-2 border-b border-red-200 pb-2">
                            <i class="fa-solid fa-triangle-exclamation mr-1 text-red-500"></i> PERHATIAN UNTUK KLIEN
                        </p>
                        <p class="text-[11px] text-red-800 leading-relaxed text-justify mt-1.5 font-medium">
                            Dengan pemindaian ini, pihak klien atas nama <strong
                                class="uppercase">{{ $project->client_name }}</strong> dinyatakan telah menyetujui,
                            terikat, dan wajib mematuhi seluruh beban pembayaran serta persyaratan layanan dari
                            Karyantara Solution.
                        </p>
                    </div>
                @else
                    <div class="mt-4 bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <p class="text-xs text-slate-600 font-bold uppercase tracking-wider mb-1">
                            <i class="fa-solid fa-scale-balanced mr-1"></i> Keabsahan Dokumen
                        </p>
                        <p class="text-[11px] text-slate-500 leading-relaxed text-justify mt-1.5">
                            Dokumen ini adalah bukti kesepakatan digital yang sah dan terekam di pusat pangkalan data
                            Karyantara Solution. Dilarang keras memalsukan atau mengubah isi dari dokumen fisik yang
                            telah dicetak.
                        </p>
                    </div>
                @endif

            </div>

            <div class="mt-8 text-center text-[10px] text-gray-400">
                <p>Waktu Pemindaian: {{ \Carbon\Carbon::now()->timezone('Asia/Makassar')->format('d M Y, H:i') }} WITA
                </p>
                <p class="mt-1 font-semibold">&copy; 2026-{{ date('Y') }} Karyantara Solution</p>
            </div>
        </div>
    </div>

</body>

</html>
