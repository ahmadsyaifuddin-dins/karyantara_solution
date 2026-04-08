<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-[#1E293B] leading-tight flex items-center gap-2">
                <i class="fa-solid fa-clipboard-list text-amber-500"></i>
                {{ __('Kanban Board Revisi') }}
            </h2>

            <div class="flex items-center gap-3">
                <button @click="isFocusMode = !isFocusMode"
                    class="bg-white border-2 border-gray-200 text-gray-600 hover:text-[#1E293B] hover:border-[#1E293B] px-4 py-2 rounded-xl text-sm font-bold transition-all duration-300 shadow-sm flex items-center gap-2 focus:outline-none"
                    :title="isFocusMode ? 'Kembali ke Mode Normal' : 'Fokus Layar Penuh'">

                    <i class="fa-solid" :class="isFocusMode ? 'fa-compress text-amber-500' : 'fa-expand'"></i>
                    <span x-text="isFocusMode ? 'Kembali' : 'Layar Penuh'" class="hidden sm:inline"></span>
                </button>

                <a href="{{ route('admin.revisions.create') }}"
                    class="bg-[#1E293B] text-amber-500 hover:text-[#1E293B] px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-amber-500 transition-all duration-300 shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Tiket
                </a>
            </div>
        </div>
    </x-slot>

    <div x-data="{ ticketModalOpen: false, activeTicket: {} }" @open-ticket-modal.window="activeTicket = $event.detail; ticketModalOpen = true;">

        <div class="flex gap-6 overflow-x-auto pb-6 h-[78vh] items-start custom-scrollbar">

            @php
                $columns = [
                    'backlog' => [
                        'title' => 'Antrean (Backlog)',
                        'bg' => 'bg-slate-100',
                        'border' => 'border-slate-300',
                        'text' => 'text-slate-700',
                        'icon' => 'fa-inbox',
                    ],
                    'in_progress' => [
                        'title' => 'Sedang Dikerjakan',
                        'bg' => 'bg-amber-50',
                        'border' => 'border-amber-300',
                        'text' => 'text-amber-700',
                        'icon' => 'fa-person-digging',
                    ],
                    'waiting' => [
                        'title' => 'Menunggu Feedback',
                        'bg' => 'bg-blue-50',
                        'border' => 'border-blue-300',
                        'text' => 'text-blue-700',
                        'icon' => 'fa-hourglass-half',
                    ],
                    'done' => [
                        'title' => 'Selesai',
                        'bg' => 'bg-emerald-50',
                        'border' => 'border-emerald-300',
                        'text' => 'text-emerald-700',
                        'icon' => 'fa-circle-check',
                    ],
                ];
            @endphp

            @foreach ($columns as $status => $col)
                <div
                    class="min-w-[320px] w-[320px] bg-gray-50/80 backdrop-blur-sm border border-gray-200 rounded-2xl flex flex-col max-h-full shadow-sm">

                    <div
                        class="p-4 border-b border-gray-200 flex justify-between items-center {{ $col['bg'] }} rounded-t-2xl">
                        <h3
                            class="font-extrabold text-sm {{ $col['text'] }} uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid {{ $col['icon'] }} text-base"></i> {{ $col['title'] }}
                        </h3>
                        <span
                            class="bg-white text-[#1E293B] text-xs font-black px-2.5 py-1 rounded-lg shadow-sm border border-gray-100">
                            {{ $board[$status]->count() }}
                        </span>
                    </div>

                    <div class="p-3 flex-1 overflow-y-auto space-y-3 sortable-list min-h-[200px]"
                        data-status="{{ $status }}">
                        @foreach ($board[$status] as $ticket)
                            @php
                                // Menentukan aksen warna kiri (border-l) berdasarkan tipe revisi
                                $typeBorder =
                                    $ticket->type == 'app'
                                        ? 'border-l-blue-500'
                                        : ($ticket->type == 'naskah'
                                            ? 'border-l-purple-500'
                                            : 'border-l-amber-500');
                                $typeBg =
                                    $ticket->type == 'app'
                                        ? 'bg-blue-50 text-blue-700'
                                        : ($ticket->type == 'naskah'
                                            ? 'bg-purple-50 text-purple-700'
                                            : 'bg-amber-50 text-amber-700');
                                $typeIcon =
                                    $ticket->type == 'app'
                                        ? 'fa-code'
                                        : ($ticket->type == 'naskah'
                                            ? 'fa-file-word'
                                            : 'fa-layer-group');
                            @endphp

                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 border-l-4 {{ $typeBorder }} cursor-grab hover:-translate-y-1 hover:shadow-md transition-all duration-200 group"
                                data-id="{{ $ticket->id }}">

                                <div class="flex justify-between items-start mb-2.5">
                                    <span
                                        class="text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide flex items-center gap-1.5 {{ $typeBg }}">
                                        <i class="fa-solid {{ $typeIcon }}"></i> {{ ucfirst($ticket->type) }}
                                    </span>
                                </div>

                                <h4
                                    class="font-bold text-sm text-[#1E293B] mb-1.5 leading-tight group-hover:text-amber-600 transition-colors">
                                    {{ $ticket->title }}</h4>
                                <p class="text-xs text-gray-500 mb-4 truncate font-medium flex items-center gap-1.5">
                                    <i class="fa-regular fa-circle-user text-gray-400"></i>
                                    {{ $ticket->project->client_name ?? 'Client Unknown' }}
                                </p>

                                <div class="flex justify-between items-center border-t border-gray-100 pt-3 mt-1">
                                    <span
                                        class="text-[11px] font-bold text-gray-400">#{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <button
                                        @click="$dispatch('open-ticket-modal', {{ json_encode($ticket->load('project')) }})"
                                        class="text-[11px] text-[#1E293B] hover:text-amber-600 font-bold px-2 py-1 rounded transition-colors flex items-center gap-1">
                                        Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>

        @include('admin.revisions.partials.modal')

    </div>

    @include('admin.revisions.partials.script')

</x-app-layout>
