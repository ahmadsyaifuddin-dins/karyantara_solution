<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-xl sm:text-2xl text-[#1E293B] leading-tight">
                {{ __('Agenda & Hasil Rapat') }}
            </h2>
            <a href="{{ route('admin.meetings.create') }}"
                class="w-full sm:w-auto text-center bg-amber-500 hover:bg-amber-600 text-white px-4 py-2.5 rounded-lg font-semibold transition-all shadow-sm">
                <i class="fa-solid fa-plus mr-1"></i> Jadwalkan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-1 max-w-full mx-auto">

        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                <p class="text-sm text-green-700 font-medium"><i class="fa-solid fa-circle-check mr-2"></i>
                    {{ session('success') }}</p>
            </div>
        @endif

        @if (session('warning'))
            <div class="mb-6 bg-amber-50 border-l-4 border-amber-500 p-4 rounded-md shadow-sm">
                <p class="text-sm text-amber-700 font-medium"><i class="fa-solid fa-triangle-exclamation mr-2"></i>
                    {{ session('warning') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="h-12 w-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                    <i class="fa-solid fa-wallet fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider leading-tight">Total
                        (Seluruhnya)</p>
                    <p class="text-lg font-extrabold text-[#1E293B]">Rp
                        {{ number_format($stats['total_all'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="h-12 w-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-calendar-check fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider leading-tight">Tahun
                        {{ now()->year }}</p>
                    <p class="text-lg font-extrabold text-[#1E293B]">Rp
                        {{ number_format($stats['total_year'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 border-l-4 border-l-amber-500">
                <div class="h-12 w-12 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600">
                    <i class="fa-solid fa-chart-line fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-amber-800 uppercase tracking-wider leading-tight">Bulan Ini</p>
                    <p class="text-lg font-extrabold text-[#1E293B]">Rp
                        {{ number_format($stats['total_month'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="h-12 w-12 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-receipt fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider leading-tight">Hari Ini</p>
                    <p class="text-lg font-extrabold text-[#1E293B]">Rp
                        {{ number_format($stats['total_today'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-slate-50 text-[#1E293B] border-b border-gray-200">
                            <th class="p-4 font-semibold text-sm whitespace-nowrap w-48">Tanggal & Waktu</th>
                            <th class="p-4 font-semibold text-sm min-w-[250px]">Judul Rapat</th>
                            <th class="p-4 font-semibold text-sm whitespace-nowrap">Tipe</th>
                            <th class="p-4 font-semibold text-sm whitespace-nowrap">Biaya Konsumsi</th>
                            <th class="p-4 font-semibold text-sm whitespace-nowrap">Status</th>
                            <th class="p-4 font-semibold text-sm text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($meetings as $meeting)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 text-sm whitespace-nowrap">
                                    <div class="font-medium text-[#1E293B]">{{ $meeting->start_time->format('d M Y') }}
                                    </div>
                                    <div class="text-gray-500">{{ $meeting->start_time->format('H:i') }} -
                                        {{ $meeting->end_time->format('H:i') }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-[#1E293B]">{{ $meeting->title }}</div>
                                    <div class="text-xs text-gray-500 flex items-center mt-1">
                                        <i class="fa-solid fa-location-dot mr-1"></i>
                                        {{ Str::limit($meeting->location, 30) }}
                                    </div>
                                </td>
                                <td class="p-4 text-sm whitespace-nowrap">
                                    <span
                                        class="px-2.5 py-1 bg-gray-100 text-[#1E293B] rounded-md text-xs font-semibold border border-gray-200">
                                        {{ $meeting->type }}
                                    </span>
                                </td>

                                <td class="p-4 text-sm whitespace-nowrap">
                                    @if ($meeting->consumption_cost > 0)
                                        <div class="font-bold text-[#1E293B]">Rp
                                            {{ number_format($meeting->consumption_cost, 0, ',', '.') }}</div>

                                        <div class="text-[10px] font-medium mt-0.5 flex items-center gap-1">
                                            @if ($meeting->payment_method === 'Company Budget')
                                                <span class="text-purple-600"><i
                                                        class="fa-solid fa-building-columns"></i> Kas Kantor</span>
                                            @elseif($meeting->payment_method === 'Personal')
                                                <span class="text-blue-600"><i class="fa-solid fa-user-tag"></i>
                                                    Pribadi</span>
                                            @else
                                                <span class="text-gray-500"><i
                                                        class="fa-solid fa-hand-holding-dollar"></i> Split Bill</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic text-xs">- Tanpa Biaya -</span>
                                    @endif
                                </td>

                                <td class="p-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'Scheduled' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'Ongoing' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'Completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            'Canceled' => 'bg-red-100 text-red-700 border-red-200',
                                        ];
                                        $colorClass =
                                            $statusColors[$meeting->status] ??
                                            'bg-gray-100 text-gray-700 border-gray-200';
                                    @endphp
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-semibold border {{ $colorClass }}">
                                        {{ $meeting->status }}
                                    </span>
                                </td>
                                <td class="p-4 flex items-center justify-center gap-2 whitespace-nowrap">
                                    <a href="{{ route('admin.meetings.show', $meeting->id) }}"
                                        class="p-2 text-[#1E293B] hover:bg-slate-100 rounded-md transition border border-transparent hover:border-slate-200"
                                        title="Lihat Detail & Notulensi">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.meetings.edit', $meeting->id) }}"
                                        class="p-2 text-amber-600 hover:bg-amber-50 rounded-md transition border border-transparent hover:border-amber-200"
                                        title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.meetings.destroy', $meeting->id) }}" method="POST"
                                        class="inline form-delete" data-name="{{ $meeting->title }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-500 hover:bg-red-50 rounded-md transition border border-transparent hover:border-red-200"
                                            title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fa-regular fa-calendar-xmark text-4xl mb-3 text-gray-300"></i>
                                        <p>Belum ada jadwal rapat yang dibuat.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($meetings->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $meetings->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
