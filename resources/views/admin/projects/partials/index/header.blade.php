@php
    // Ambil data timer langsung tanpa harus mengubah ProjectController
    $timerSettings = \App\Models\Setting::whereIn('key', ['timer_is_active', 'timer_title', 'timer_datetime'])->pluck(
        'value',
        'key',
    );
    $timerActive = $timerSettings['timer_is_active'] ?? '0';
    $timerTitle = $timerSettings['timer_title'] ?? 'Pengingat Batas Waktu';
    $timerDatetime = $timerSettings['timer_datetime'] ?? null;
@endphp

<div class="space-y-4">
    @if ($timerActive === '1' && $timerDatetime)
        <div x-data="countdownTimer('{{ $timerDatetime }}')" x-show="!isExpired" x-transition.duration.500ms
            class="bg-[#1E293B] rounded-2xl shadow-lg border border-slate-700 overflow-hidden relative w-full">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-amber-500 rounded-full opacity-10 blur-2xl">
            </div>

            <div class="px-5 py-4 flex flex-col md:flex-row items-center justify-between gap-5">
                <div class="flex items-center gap-4 z-10">
                    <div class="bg-amber-500/20 p-3 rounded-xl border border-amber-500/30">
                        <i class="fa-solid fa-bell text-amber-500 text-2xl animate-[ring_2s_ease-in-out_infinite]"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-lg md:text-xl">{{ $timerTitle }}</h4>
                        <p class="text-slate-400 text-sm">Pastikan progres mahasiswa aman sebelum batas waktu ini.</p>
                    </div>
                </div>

                <div class="flex gap-2 text-center z-10">
                    <div class="bg-slate-800/80 border border-slate-600 rounded-xl px-3 py-2 min-w-[65px] shadow-inner">
                        <span class="text-amber-500 font-extrabold text-2xl" x-text="days">00</span>
                        <p class="text-slate-400 text-[10px] uppercase font-semibold tracking-wider">Hari</p>
                    </div>
                    <div class="text-slate-500 font-bold text-xl py-2">:</div>
                    <div class="bg-slate-800/80 border border-slate-600 rounded-xl px-3 py-2 min-w-[65px] shadow-inner">
                        <span class="text-amber-500 font-extrabold text-2xl" x-text="hours">00</span>
                        <p class="text-slate-400 text-[10px] uppercase font-semibold tracking-wider">Jam</p>
                    </div>
                    <div class="text-slate-500 font-bold text-xl py-2">:</div>
                    <div class="bg-slate-800/80 border border-slate-600 rounded-xl px-3 py-2 min-w-[65px] shadow-inner">
                        <span class="text-amber-500 font-extrabold text-2xl" x-text="minutes">00</span>
                        <p class="text-slate-400 text-[10px] uppercase font-semibold tracking-wider">Menit</p>
                    </div>
                    <div class="text-slate-500 font-bold text-xl py-2">:</div>
                    <div class="bg-slate-800/80 border border-slate-600 rounded-xl px-3 py-2 min-w-[65px] shadow-inner">
                        <span class="text-red-400 font-extrabold text-2xl" x-text="seconds">00</span>
                        <p class="text-slate-400 text-[10px] uppercase font-semibold tracking-wider">Detik</p>
                    </div>
                </div>
            </div>
            <style>
                @keyframes ring {
                    0% {
                        transform: rotate(0);
                    }

                    10% {
                        transform: rotate(15deg);
                    }

                    20% {
                        transform: rotate(-10deg);
                    }

                    30% {
                        transform: rotate(5deg);
                    }

                    40% {
                        transform: rotate(-5deg);
                    }

                    50%,
                    100% {
                        transform: rotate(0);
                    }
                }
            </style>
        </div>
    @endif
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">
        <h2 class="font-semibold text-xl text-[#1E293B] leading-tight whitespace-nowrap">
            <i class="fa-solid fa-file-invoice-dollar mr-2"></i> {{ __('Daftar Klien & Proyek') }}
        </h2>

        <div class="flex flex-wrap items-center gap-2 lg:gap-3 w-full xl:w-auto justify-start xl:justify-end">

            <div class="flex bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div x-data="{
                    copyLink() {
                        navigator.clipboard.writeText('{{ route('rules.mahasiswa') }}');
                        window.Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Link Panduan disalin!', showConfirmButton: false, timer: 2000, customClass: { popup: 'border border-emerald-100 shadow-xl rounded-xl' } });
                    }
                }">
                    <button @click="copyLink()" type="button"
                        class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-amber-600 hover:bg-amber-50 border-r border-gray-200 transition-colors"
                        title="Copy Link MoU">
                        <i class="fa-solid fa-link"></i>
                    </button>
                </div>
                <div x-data="googleSheetSync('{{ route('admin.projects.sync-sheet') }}')">
                    <button @click="syncData" type="button"
                        class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-amber-600 hover:bg-amber-50 transition-colors"
                        title="Sync Spreadsheet">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </button>
                </div>
            </div>

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-sm font-semibold rounded-lg text-gray-600 hover:bg-gray-50 shadow-sm transition focus:outline-none">
                        <i class="fa-solid fa-download mr-2"></i> Export Data <i
                            class="fa-solid fa-chevron-down ml-2 text-xs"></i>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link href="{{ route('admin.projects.export.pdf') }}" target="_blank"
                        class="hover:text-red-600 font-medium">
                        <i class="fa-solid fa-file-pdf mr-2 text-red-500"></i> Export PDF
                    </x-dropdown-link>
                    <x-dropdown-link href="{{ route('admin.projects.export.excel') }}"
                        class="hover:text-emerald-600 font-medium">
                        <i class="fa-solid fa-file-excel mr-2 text-emerald-500"></i> Export Excel
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>

            <a href="{{ route('admin.projects.priority') }}"
                class="bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition inline-flex items-center">
                <i class="fa-solid fa-list-check mr-2"></i> Prioritas
            </a>

            <a href="{{ route('admin.projects.create') }}"
                class="bg-[#1E293B] text-white px-5 py-2 rounded-lg hover:bg-slate-800 transition-colors text-sm font-bold shadow-sm inline-flex items-center ring-1 ring-[#1E293B]">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Data
            </a>

        </div>
    </div>
</div>
