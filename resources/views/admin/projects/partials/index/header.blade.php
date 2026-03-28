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
        <div x-data="countdownTimer('{{ $timerDatetime }}')" x-show="!isExpired" style="display: none;" x-init="$el.style.display = 'block'"
            {{-- Mencegah card berkedip saat halaman di-refresh --}}
            :class="{
                'bg-red-700 border-red-900 animate-[panic_0.3s_ease-in-out_infinite] shadow-[0_0_25px_rgba(220,38,38,0.5)]': isCritical &&
                    !isExploding,
                'bg-[#1E293B] border-slate-700 shadow-lg': !isCritical && !isExploding,
                'animate-[disintegrate_1.5s_ease-in_forwards] border-transparent pointer-events-none': isExploding
            }"
            class="rounded-2xl border overflow-hidden relative w-full transition-colors duration-500 z-30">

            <template x-if="isExploding">
                <div class="absolute inset-0 z-50 overflow-hidden rounded-2xl pointer-events-none">
                    <div
                        class="absolute inset-0 m-auto w-10 h-10 bg-white rounded-full animate-[explode-core_1.5s_forwards] shadow-[0_0_50px_20px_#fff]">
                    </div>
                    <div
                        class="absolute inset-0 m-auto w-20 h-20 bg-amber-500 rounded-full animate-[explode-fire_1.2s_forwards_0.1s] opacity-0 shadow-[0_0_80px_30px_#f59e0b]">
                    </div>
                    <div
                        class="absolute inset-0 m-auto w-32 h-32 bg-red-600 rounded-full animate-[explode-fire_1s_forwards_0.2s] opacity-0 shadow-[0_0_100px_40px_#dc2626]">
                    </div>

                    <div
                        class="absolute top-1/2 left-1/2 w-2 h-2 bg-slate-900 rounded-full animate-[particle-out_1s_forwards_0.3s] opacity-0">
                    </div>
                    <div
                        class="absolute top-1/2 left-1/2 w-3 h-3 bg-slate-800 rounded-full animate-[particle-out_1.2s_forwards_0.35s] opacity-0">
                    </div>
                    <div
                        class="absolute top-1/2 left-1/2 w-2 h-2 bg-slate-950 rounded-full animate-[particle-out_0.8s_forwards_0.4s] opacity-0">
                    </div>
                </div>
            </template>
            <div x-show="!isExploding"
                class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full opacity-20 blur-2xl"
                :class="isCritical ? 'bg-black' : 'bg-amber-500'"></div>

            <div class="px-5 py-4 flex flex-col md:flex-row items-center justify-between gap-5 relative z-10 transition-opacity duration-300"
                :class="isExploding ? 'opacity-0' : 'opacity-100'">

                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl border transition-colors duration-500"
                        :class="isCritical ? 'bg-red-900/50 border-red-400/50' : 'bg-amber-500/20 border-amber-500/30'">
                        <i class="fa-solid fa-bell text-2xl transition-colors duration-500"
                            :class="isCritical ? 'text-white animate-ping' :
                                'text-amber-500 animate-[ring_2s_ease-in-out_infinite]'"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-lg md:text-xl">{{ $timerTitle }}</h4>
                        <p class="text-sm transition-colors duration-500"
                            :class="isCritical ? 'text-red-200 font-bold' : 'text-slate-400'">
                            <span x-show="isCritical"><i class="fa-solid fa-triangle-exclamation mr-1"></i> WAKTU HAMPIR
                                HABIS! SEGERA CEK PROGRES!</span>
                            <span x-show="!isCritical">Pastikan progres mahasiswa aman sebelum batas waktu ini.</span>
                        </p>
                    </div>
                </div>

                {{-- Bagian Angka Timer --}}
                <div class="flex gap-2 text-center relative">
                    @php $units = [['days', 'Hari', 'text-amber-500'], ['hours', 'Jam', 'text-amber-500'], ['minutes', 'Menit', 'text-amber-500'], ['seconds', 'Detik', 'text-red-400']]; @endphp
                    @foreach ($units as $index => $unit)
                        <div class="border rounded-xl px-3 py-2 min-w-[65px] shadow-inner transition-colors duration-500"
                            :class="isCritical ? 'bg-red-950/80 border-red-500' : 'bg-slate-800/80 border-slate-600'">
                            <span class="font-extrabold text-2xl transition-colors duration-500"
                                :class="isCritical ? 'text-white' : '{{ $unit[2] }}'"
                                x-text="{{ $unit[0] }}">00</span>
                            <p class="text-[10px] uppercase font-semibold tracking-wider transition-colors duration-500"
                                :class="isCritical ? 'text-red-300' : 'text-slate-400'">{{ $unit[1] }}</p>
                        </div>
                        @if (!$loop->last)
                            <div class="font-bold text-xl py-2 transition-colors duration-500"
                                :class="isCritical ? 'text-red-400' : 'text-slate-500'">:</div>
                        @endif
                    @endforeach
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

                @keyframes panic {
                    0% {
                        transform: translate(1px, 1px) rotate(0deg);
                    }

                    25% {
                        transform: translate(-2px, -1px) rotate(-1deg);
                    }

                    50% {
                        transform: translate(1px, 2px) rotate(1deg);
                    }

                    75% {
                        transform: translate(-1px, -2px) rotate(0deg);
                    }

                    100% {
                        transform: translate(2px, 1px) rotate(-1deg);
                    }
                }

                @keyframes disintegrate {
                    0% {
                        transform: scale(1) rotate(0deg);
                        opacity: 1;
                        filter: blur(0px);
                    }

                    20% {
                        transform: scale(1.05) rotate(1deg);
                        opacity: 1;
                        filter: blur(1px);
                    }

                    40% {
                        transform: scale(0.9) rotate(-2deg);
                        opacity: 0.8;
                        filter: blur(2px);
                    }

                    100% {
                        transform: scale(0) rotate(10deg);
                        opacity: 0;
                        filter: blur(20px);
                    }
                }

                @keyframes explode-core {
                    0% {
                        transform: scale(0);
                        opacity: 0;
                    }

                    10% {
                        transform: scale(1);
                        opacity: 1;
                    }

                    30% {
                        transform: scale(20);
                        opacity: 1;
                    }

                    100% {
                        transform: scale(40);
                        opacity: 0;
                    }
                }

                @keyframes explode-fire {
                    0% {
                        transform: scale(0);
                        opacity: 0;
                    }

                    10% {
                        transform: scale(1);
                        opacity: 1;
                    }

                    80% {
                        transform: scale(15);
                        opacity: 0.8;
                    }

                    100% {
                        transform: scale(20);
                        opacity: 0;
                    }
                }

                @keyframes particle-out {
                    0% {
                        transform: translate(0, 0);
                        opacity: 0;
                    }

                    10% {
                        opacity: 1;
                    }

                    100% {
                        transform: translate(calc(var(--tw-translate-x) + (500px * (rand() - 0.5))), calc(var(--tw-translate-y) + (500px * (rand() - 0.5))));
                        opacity: 0;
                    }
                }

                [animate*=particle-out]:nth-child(4) {
                    --tw-translate-x: 100px;
                    --tw-translate-y: -150px;
                }

                [animate*=particle-out]:nth-child(5) {
                    --tw-translate-x: -120px;
                    --tw-translate-y: 100px;
                }

                [animate*=particle-out]:nth-child(6) {
                    --tw-translate-x: 150px;
                    --tw-translate-y: 50px;
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
