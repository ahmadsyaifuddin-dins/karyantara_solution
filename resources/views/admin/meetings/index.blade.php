<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-[#1E293B] leading-tight">
                {{ __('Agenda & Hasil Rapat') }}
            </h2>
            <a href="{{ route('admin.meetings.create') }}"
                class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg font-semibold transition-all shadow-sm">
                <i class="fa-solid fa-plus mr-1"></i> Jadwalkan Baru
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[#1E293B] border-b border-gray-200">
                        <th class="p-4 font-semibold text-sm">Tanggal & Waktu</th>
                        <th class="p-4 font-semibold text-sm">Judul Rapat</th>
                        <th class="p-4 font-semibold text-sm">Tipe</th>
                        <th class="p-4 font-semibold text-sm">Status</th>
                        <th class="p-4 font-semibold text-sm text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($meetings as $meeting)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-sm">
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
                            <td class="p-4 text-sm">
                                <span
                                    class="px-2 py-1 bg-gray-100 text-[#1E293B] rounded-md text-xs font-medium border border-gray-200">
                                    {{ $meeting->type }}
                                </span>
                            </td>
                            <td class="p-4">
                                @php
                                    $statusColors = [
                                        'Scheduled' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'Ongoing' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'Completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'Canceled' => 'bg-red-100 text-red-700 border-red-200',
                                    ];
                                    $colorClass =
                                        $statusColors[$meeting->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold border {{ $colorClass }}">
                                    {{ $meeting->status }}
                                </span>
                            </td>
                            <td class="p-4 flex items-center justify-center gap-2">
                                <a href="{{ route('admin.meetings.show', $meeting->id) }}"
                                    class="p-2 text-[#1E293B] hover:bg-slate-100 rounded-md transition"
                                    title="Lihat Detail & Notulensi">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.meetings.edit', $meeting->id) }}"
                                    class="p-2 text-amber-600 hover:bg-amber-50 rounded-md transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.meetings.destroy', $meeting->id) }}" method="POST"
                                    class="inline form-delete" data-name="{{ $meeting->title }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-red-500 hover:bg-red-50 rounded-md transition" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
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
</x-app-layout>
