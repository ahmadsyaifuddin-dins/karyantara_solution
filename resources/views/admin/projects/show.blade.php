<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight flex items-center">
                <i class="fa-solid fa-file-lines text-amber-500 mr-3"></i>
                {{ __('Detail Proyek / Klien') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.projects.invoice', $project->id) }}" target="_blank"
                    class="bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition flex items-center">
                    <i class="fa-solid fa-print mr-2"></i> Cetak Invoice / MoU
                </a>

                <a href="{{ route('admin.projects.edit', $project->id) }}"
                    class="bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition flex items-center">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Data
                </a>
                <a href="{{ route('admin.projects.index') }}"
                    class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition text-sm font-bold shadow-sm flex items-center">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-1">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @include('admin.projects.partials.show.header-card')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                @include('admin.projects.partials.show.finance-card')

                @include('admin.projects.partials.show.scope-card')

            </div>

        </div>
    </div>

    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="font-bold text-[#1E293B] flex items-center">
                <i class="fa-solid fa-clock-rotate-left text-amber-500 mr-2"></i> Riwayat & Tiket Revisi
            </h3>
            <span
                class="px-3 py-1 bg-white border border-gray-300 rounded-full text-xs font-bold text-gray-600 shadow-sm">
                Kuota Terpakai: <span
                    class="{{ $project->used_revision >= $project->max_revision ? 'text-red-600' : 'text-emerald-600' }}">{{ $project->used_revision }}/{{ $project->max_revision }}</span>
            </span>
        </div>

        <div class="p-6">
            @if ($project->revisionTickets && $project->revisionTickets->count() > 0)
                <div class="space-y-4">
                    @foreach ($project->revisionTickets as $ticket)
                        <div
                            class="flex items-start gap-4 p-4 rounded-lg border {{ $ticket->status == 'done' ? 'bg-emerald-50 border-emerald-100' : 'bg-white border-gray-200' }}">
                            <div class="mt-1">
                                @if ($ticket->status == 'done')
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                                @elseif($ticket->status == 'in_progress')
                                    <i class="fa-solid fa-person-digging text-amber-500 text-xl"></i>
                                @elseif($ticket->status == 'waiting')
                                    <i class="fa-solid fa-hourglass-half text-blue-500 text-xl"></i>
                                @elseif ($ticket->status == 'backlog')
                                    <i class="fa-solid fa-inbox text-slate-500 text-xl"></i>
                                @else
                                    <i class="fa-regular fa-circle text-gray-300 text-xl"></i>
                                @endif
                            </div>

                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="font-bold text-sm text-[#1E293B]">{{ $ticket->title }}</h4>
                                    <span class="text-[10px] uppercase font-bold text-gray-500 tracking-wider">
                                        {{ str_replace('_', ' ', $ticket->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 mb-2 whitespace-pre-line">
                                    {{ $ticket->description ?? 'Tanpa deskripsi rinci.' }}</p>
                                <div class="text-[10px] font-semibold text-gray-400">
                                    Dibuat pada: {{ $ticket->created_at->format('d M Y, H:i') }} | Tipe: <span
                                        class="uppercase text-amber-600">{{ $ticket->type }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div
                        class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-mug-hot text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-500 font-medium">Belum ada tiket revisi untuk proyek ini.<br>Semoga
                        lancar jaya!</p>
                </div>
            @endif
        </div>
    </div>
    </div>
</x-app-layout>
