<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 print:hidden">
            <h2 class="font-bold text-2xl text-[#1E293B] leading-tight">
                Detail Notulensi & Rapat
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.meetings.index') }}"
                    class="px-4 py-2 bg-white border-2 border-[#1E293B] text-[#1E293B] hover:bg-gray-50 font-semibold rounded-lg transition-all text-sm">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </a>
                <a href="{{ route('admin.meetings.edit', $meeting->id) }}"
                    class="px-4 py-2 bg-[#1E293B] hover:bg-slate-800 text-white font-semibold rounded-lg shadow-sm transition-all text-sm">
                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                </a>
                <a href="{{ route('admin.meetings.print', $meeting->id) }}" target="_blank"
                    class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg shadow-sm transition-all text-sm flex items-center">
                    <i class="fa-solid fa-print mr-1"></i> Cetak MoM
                </a>
            </div>
        </div>
    </x-slot>

    <div
        class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-10 max-w-5xl mx-auto print:shadow-none print:border-none print:p-0 print:max-w-full">

        <div class="hidden print:flex items-center justify-between border-b-2 border-[#1E293B] pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-[#1E293B] tracking-wider">Karyantara Solution<span
                        class="text-amber-500">.</span></h1>
                <p class="text-sm text-gray-500">Minutes of Meeting (MoM) Document</p>
            </div>
            <div class="text-right text-sm text-gray-600">
                <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
                <p>Oleh: {{ Auth::user()->name }}</p>
            </div>
        </div>

        <div class="mb-8 border-b border-gray-100 pb-6 print:border-none">
            <div class="flex flex-wrap items-center gap-3 mb-2">
                <span
                    class="px-3 py-1 bg-[#1E293B] text-white rounded-full text-xs font-semibold tracking-wide uppercase">
                    {{ $meeting->type }}
                </span>

                @php
                    $statusColors = [
                        'Scheduled' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'Ongoing' => 'bg-amber-100 text-amber-800 border-amber-200',
                        'Completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                        'Canceled' => 'bg-red-100 text-red-800 border-red-200',
                    ];
                    $colorClass = $statusColors[$meeting->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $colorClass }}">
                    Status: {{ $meeting->status }}
                </span>
            </div>
            <h1 class="text-3xl font-extrabold text-[#1E293B]">{{ $meeting->title }}</h1>
        </div>

        <div
            class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 bg-slate-50 p-5 rounded-lg border border-gray-100 print:bg-transparent print:border-y print:border-x-0 print:rounded-none">
            <div class="space-y-3">
                <div class="flex items-start">
                    <i class="fa-regular fa-calendar text-amber-500 mt-1 w-6"></i>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Tanggal</p>
                        <p class="font-medium text-[#1E293B]">{{ $meeting->start_time->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fa-regular fa-clock text-amber-500 mt-1 w-6"></i>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Waktu</p>
                        <p class="font-medium text-[#1E293B]">
                            {{ $meeting->start_time->format('H:i') }} - {{ $meeting->end_time->format('H:i') }} WITA
                        </p>
                    </div>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-start">
                    <i class="fa-solid fa-location-dot text-amber-500 mt-1 w-6"></i>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Lokasi / Media</p>
                        <p class="font-medium text-[#1E293B]">{{ $meeting->location }}</p>
                        @if ($meeting->maps_link)
                            <a href="{{ $meeting->maps_link }}" target="_blank"
                                class="text-amber-600 hover:text-amber-700 text-sm flex items-center gap-1 mt-1 print:hidden">
                                <i class="fa-solid fa-map-location-dot"></i> Buka Peta
                            </a>
                        @endif
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fa-solid fa-user-pen text-amber-500 mt-1 w-6"></i>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Dibuat Oleh</p>
                        <p class="font-medium text-[#1E293B]">{{ $meeting->creator->name ?? 'Sistem' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-lg font-bold text-[#1E293B] border-b-2 border-amber-500 inline-block pb-1 mb-4">Ringkasan
                Agenda</h3>
            <div class="prose max-w-none text-gray-700 whitespace-pre-line bg-white">
                {{ $meeting->agenda_summary ?: 'Belum ada ringkasan agenda.' }}
            </div>
        </div>

        <div class="mb-10">
            <h3 class="text-lg font-bold text-[#1E293B] border-b-2 border-amber-500 inline-block pb-1 mb-4">Notulensi /
                Hasil Pembahasan</h3>
            <div
                class="prose max-w-none text-gray-700 whitespace-pre-line p-5 bg-gray-50 rounded-lg border border-gray-200 print:bg-transparent print:border-gray-300 print:p-0">
                @if ($meeting->minutes_of_meeting)
                    {!! nl2br(e($meeting->minutes_of_meeting)) !!}
                @else
                    <span class="text-gray-400 italic">Notulensi belum ditulis. Silakan edit agenda ini untuk
                        menambahkan hasil rapat.</span>
                @endif
            </div>
        </div>

        <div>
            <h3 class="text-lg font-bold text-[#1E293B] border-b-2 border-amber-500 inline-block pb-1 mb-4">Action Items
                (Tindak Lanjut)</h3>

            @if (is_array($meeting->action_items) && count($meeting->action_items) > 0)
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-left">
                        <thead class="bg-slate-50 print:bg-gray-100">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-bold text-[#1E293B] uppercase tracking-wider w-16 text-center">
                                    No</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-bold text-[#1E293B] uppercase tracking-wider">Tugas /
                                    Tindakan</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-bold text-[#1E293B] uppercase tracking-wider w-48">PIC
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-bold text-[#1E293B] uppercase tracking-wider w-48">
                                    Tenggat Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($meeting->action_items as $index => $item)
                                @if (!empty($item['task']))
                                    <tr class="hover:bg-gray-50 print:hover:bg-transparent">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center font-medium">
                                            {{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm text-[#1E293B] font-medium">{{ $item['task'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <i class="fa-regular fa-circle-user mr-1 text-gray-400 print:hidden"></i>
                                            {{ $item['pic'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-600 font-semibold">
                                            {{ \Carbon\Carbon::parse($item['deadline'])->format('d M Y') }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center bg-gray-50 rounded-lg border border-dashed border-gray-300 print:hidden">
                    <i class="fa-solid fa-list-check text-4xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500 text-sm">Tidak ada action items yang dicatat untuk pertemuan ini.</p>
                </div>
                <p class="hidden print:block text-gray-500 italic text-sm">- Tidak ada tindak lanjut khusus -</p>
            @endif
        </div>

        <div class="hidden print:grid grid-cols-2 gap-8 mt-20 text-center">
            <div>
                <p class="mb-20 text-[#1E293B]">Dibuat Oleh,</p>
                <p class="font-bold text-[#1E293B] underline">
                    {{ $meeting->creator->name ?? '...................................' }}</p>
                <p class="text-sm text-gray-500">Karyantara Solution</p>
            </div>
            <div>
                <p class="mb-20 text-[#1E293B]">Mengetahui,</p>
                <p class="font-bold text-[#1E293B] underline">...................................</p>
                <p class="text-sm text-gray-500">Klien / Pihak Terkait</p>
            </div>
        </div>

    </div>
</x-app-layout>
