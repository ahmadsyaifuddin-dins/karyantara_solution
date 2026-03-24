<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MoM - {{ $meeting->title }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Kurangi margin atas dan bawah untuk memaksimalkan ruang */
        @page {
            size: A4 portrait;
            margin: 10mm 15mm;
        }

        body {
            background-color: white;
            color: #1E293B;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            /* Perkecil ukuran font dasar sedikit */
            font-size: 0.9rem;
        }

        @media print {
            a[href]:after {
                content: none !important;
            }

            .no-print {
                display: none !important;
            }

            /* Cegah pemotongan di tengah baris tabel */
            tr {
                page-break-inside: avoid;
            }

            /* Cegah tanda tangan terpotong di tengah-tengah dirinya sendiri */
            .signature-block {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-white" onload="window.print()">

    <div class="max-w-4xl mx-auto py-4 px-4 sm:px-0">

        <div class="flex items-center justify-between border-b-2 border-[#1E293B] pb-3 mb-6">
            <div>
                <h1 class="text-xl font-bold text-[#1E293B] tracking-wider">Karyantara Solution<span
                        class="text-amber-500">.</span></h1>
                <p class="text-xs text-gray-500 font-medium mt-1">Minutes of Meeting (MoM) Document</p>
            </div>
            <div class="text-right text-xs text-gray-500">
                <p>Dicetak pada: <span class="font-medium text-[#1E293B]">{{ now()->format('d M Y H:i') }}</span></p>
                <p>Oleh: <span class="font-medium text-[#1E293B]">{{ Auth::user()->name }}</span></p>
            </div>
        </div>

        <div class="mb-6">
            <div class="flex items-center gap-2 mb-2">
                <span
                    class="px-2 py-1 bg-[#1E293B] text-white rounded-md text-[10px] font-bold tracking-wide uppercase">
                    {{ $meeting->type }}
                </span>
                <span
                    class="px-2 py-1 bg-gray-100 text-[#1E293B] border border-gray-300 rounded-md text-[10px] font-bold uppercase">
                    Status: {{ $meeting->status }}
                </span>
            </div>
            <h2 class="text-2xl font-extrabold text-[#1E293B]">{{ $meeting->title }}</h2>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6 border-y border-gray-200 py-4">
            <div class="space-y-3">
                <div>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1">Tanggal</p>
                    <p class="font-semibold text-[#1E293B] text-sm">
                        {{ $meeting->start_time->translatedFormat('l, d F Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1">Waktu</p>
                    <p class="font-semibold text-[#1E293B] text-sm">
                        {{ $meeting->start_time->format('H:i') }} - {{ $meeting->end_time->format('H:i') }} WITA
                    </p>
                </div>
            </div>
            <div class="space-y-3">
                <div>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1">Lokasi / Media</p>
                    <p class="font-semibold text-[#1E293B] text-sm">{{ $meeting->location }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1">Inisiator (Dibuat
                        Oleh)</p>
                    <p class="font-semibold text-[#1E293B] text-sm">{{ $meeting->creator->name ?? 'Sistem' }}</p>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h3
                class="text-base font-bold text-[#1E293B] border-l-4 border-amber-500 pl-2 mb-2 uppercase tracking-wider">
                Ringkasan Agenda</h3>
            <div class="text-gray-700 text-sm leading-relaxed pl-3">
                {{ $meeting->agenda_summary ?: '-' }}
            </div>
        </div>

        <div class="mb-6">
            <h3
                class="text-base font-bold text-[#1E293B] border-l-4 border-amber-500 pl-2 mb-2 uppercase tracking-wider">
                Hasil Pembahasan / Keputusan</h3>
            <div class="text-gray-700 text-sm leading-relaxed pl-3 whitespace-pre-line">
                @if ($meeting->minutes_of_meeting)
                    {!! nl2br(e($meeting->minutes_of_meeting)) !!}
                @else
                    <span class="text-gray-400 italic">Tidak ada catatan hasil pembahasan.</span>
                @endif
            </div>
        </div>

        <div class="mb-8">
            <h3
                class="text-base font-bold text-[#1E293B] border-l-4 border-amber-500 pl-2 mb-2 uppercase tracking-wider">
                Tindak Lanjut (Action Items)</h3>

            @if (is_array($meeting->action_items) && count($meeting->action_items) > 0)
                <table class="w-full text-left border-collapse mt-2">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="py-2 px-3 text-[11px] font-bold text-[#1E293B] uppercase w-10 text-center">No
                            </th>
                            <th class="py-2 px-3 text-[11px] font-bold text-[#1E293B] uppercase">Tugas / Tindakan</th>
                            <th class="py-2 px-3 text-[11px] font-bold text-[#1E293B] uppercase w-40">Penanggung Jawab
                            </th>
                            <th class="py-2 px-3 text-[11px] font-bold text-[#1E293B] uppercase w-32">Tenggat Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($meeting->action_items as $index => $item)
                            @if (!empty($item['task']))
                                <tr class="border-b border-gray-200">
                                    <td class="py-2 px-3 text-sm text-center text-gray-600 font-medium">
                                        {{ $loop->iteration }}</td>
                                    <td class="py-2 px-3 text-sm text-[#1E293B] font-semibold">{{ $item['task'] }}</td>
                                    <td class="py-2 px-3 text-sm text-[#1E293B]">{{ $item['pic'] }}</td>
                                    <td class="py-2 px-3 text-sm font-bold text-amber-600">
                                        {{ \Carbon\Carbon::parse($item['deadline'])->format('d M Y') }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 italic text-sm pl-3">Tidak ada tindak lanjut khusus dari rapat ini.</p>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-8 mt-10 text-center signature-block">
            <div>
                <p class="mb-16 text-sm text-gray-600 font-medium">Dibuat Oleh,</p>
                <p class="font-bold text-[#1E293B] text-sm underline">
                    {{ $meeting->creator->name ?? '(...................................)' }}</p>
                <p class="text-[10px] text-gray-500 mt-1">Karyantara Solution</p>
            </div>
            <div>
                <p class="mb-16 text-sm text-gray-600 font-medium">Mengetahui,</p>
                <p class="font-bold text-[#1E293B] text-sm underline">(...................................)</p>
                <p class="text-[10px] text-gray-500 mt-1">Klien / Pihak Terkait</p>
            </div>
        </div>

    </div>

    <div class="fixed bottom-6 right-6 no-print">
        <button onclick="window.print()"
            class="bg-[#1E293B] hover:bg-slate-800 text-white px-6 py-3 rounded-full shadow-lg font-bold flex items-center gap-2 transition-transform hover:scale-105">
            <i class="fa-solid fa-print"></i> Cetak Ulang
        </button>
    </div>

</body>

</html>
