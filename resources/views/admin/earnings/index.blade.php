<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#1E293B] leading-tight">
            <i class="fa-solid fa-sack-dollar text-emerald-500 mr-2"></i> Dompet & Pendapatan Saya
        </h2>
        <p class="text-sm text-gray-500 mt-1">Rincian proyek dan bagi hasil yang dialokasikan untuk Anda.</p>

        <div
            class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4 mt-6">
            <div class="flex items-center gap-2 text-gray-500">
                <i class="fa-solid fa-calendar-days text-blue-500 text-lg"></i>
                <span class="font-bold text-sm uppercase tracking-wider">Filter Rekap Pendapatan</span>
            </div>

            @php
                $bulanIndo = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                ];
            @endphp

            <form method="GET" action="{{ route('admin.earnings.index') }}"
                class="flex items-center gap-3 w-full md:w-auto">
                <select name="month"
                    class="bg-gray-50 border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="all" {{ $selectedMonth == 'all' ? 'selected' : '' }}>Semua Bulan</option>
                    @foreach ($bulanIndo as $num => $name)
                        @php $val = str_pad($num, 2, '0', STR_PAD_LEFT); @endphp
                        <option value="{{ $val }}" {{ $selectedMonth == $val ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>

                <select name="year"
                    class="bg-gray-50 border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="all" {{ $selectedYear == 'all' ? 'selected' : '' }}>Semua Tahun</option>
                    @foreach ($years as $y)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                            {{ $y }}</option>
                    @endforeach
                </select>

                <button type="submit"
                    class="bg-[#1E293B] text-white px-4 py-2.5 rounded-lg hover:bg-gray-800 transition font-bold shadow-sm">
                    Tampilkan
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                    <p class="text-sm text-green-700 font-medium"><i
                            class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
                </div>
            @endif

            <div
                class="bg-gradient-to-r from-[#1E293B] to-slate-800 rounded-3xl p-8 shadow-xl text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
                <i class="fa-solid fa-coins absolute -right-10 -bottom-10 text-9xl text-white/5"></i>

                <div>
                    <p class="text-sm font-bold text-slate-300 uppercase tracking-widest mb-2">Total Pendapatan
                        Keseluruhan</p>
                    <h2 class="text-4xl md:text-5xl font-black tracking-tight">Rp
                        {{ number_format($totalEarnings, 0, ',', '.') }}</h2>
                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <span
                            class="inline-flex items-center gap-2 bg-white/10 px-3 py-1.5 rounded-full text-xs font-medium border border-white/10 backdrop-blur-sm">
                            <i class="fa-solid fa-briefcase text-amber-400"></i> {{ $totalProjects }} Proyek
                        </span>

                        @if ($totalUnpaidEarnings > 0)
                            <span
                                class="inline-flex items-center gap-2 bg-red-500/20 px-3 py-1.5 rounded-full text-xs font-bold text-red-200 border border-red-500/30 backdrop-blur-sm shadow-sm"
                                title="Total fee yang belum ditransfer ke Anda">
                                <i class="fa-solid fa-triangle-exclamation text-red-400"></i> Belum Cair: Rp
                                {{ number_format($totalUnpaidEarnings, 0, ',', '.') }}
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-2 bg-emerald-500/20 px-3 py-1.5 rounded-full text-xs font-bold text-emerald-200 border border-emerald-500/30 backdrop-blur-sm shadow-sm">
                                <i class="fa-solid fa-check-double text-emerald-400"></i> Semua Fee Sudah Cair
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex gap-4 w-full md:w-auto z-10">
                    <div
                        class="bg-blue-500/20 border border-blue-400/30 rounded-2xl p-4 flex-1 text-center backdrop-blur-sm relative">
                        @if ($unpaidAppEarnings > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-red-500 text-white text-[9px] font-black px-2 py-0.5 rounded-full shadow border border-white animate-pulse">!</span>
                        @endif
                        <p class="text-[10px] text-blue-200 uppercase font-bold tracking-wider mb-1">Dari Aplikasi</p>
                        <p class="font-bold text-lg text-blue-100">Rp
                            {{ number_format($totalAppEarnings, 0, ',', '.') }}</p>
                    </div>
                    <div
                        class="bg-amber-500/20 border border-amber-400/30 rounded-2xl p-4 flex-1 text-center backdrop-blur-sm relative">
                        @if ($unpaidWriterEarnings > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-red-500 text-white text-[9px] font-black px-2 py-0.5 rounded-full shadow border border-white animate-pulse">!</span>
                        @endif
                        <p class="text-[10px] text-amber-200 uppercase font-bold tracking-wider mb-1">Dari Naskah</p>
                        <p class="font-bold text-lg text-amber-100">Rp
                            {{ number_format($totalWriterEarnings, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div
                    class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col max-h-[600px]">
                    <div class="px-6 py-5 border-b border-blue-100 bg-blue-50/30 flex items-center justify-between">
                        <h3 class="font-bold text-[#1E293B]"><i class="fa-solid fa-code text-blue-500 mr-2"></i> Histori
                            Developer Aplikasi</h3>
                        <span
                            class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-md font-bold">{{ $appProjects->count() }}
                            Proyek</span>
                    </div>

                    <div class="divide-y divide-gray-100 overflow-y-auto flex-1">
                        @forelse($appProjects as $project)
                            <div
                                class="p-5 hover:bg-gray-50 transition-colors {{ !$project->is_programmer_paid ? 'bg-red-50/10' : '' }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-[#1E293B] text-sm">{{ $project->client_name }}</h4>
                                    <span class="font-black text-blue-600">Rp
                                        {{ number_format($project->app_price, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-xs text-gray-500 line-clamp-1 mb-2">
                                    {{ $project->skripsi_title ?? $project->project_description }}
                                </p>

                                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                                    <div class="text-[11px] font-medium">
                                        @if ($project->is_programmer_paid)
                                            <span class="text-emerald-600 bg-emerald-50 px-2 py-1 rounded"><i
                                                    class="fa-solid fa-check-double mr-1"></i> Fee Sudah Cair</span>
                                        @else
                                            <span class="text-red-500 bg-red-50 px-2 py-1 rounded"><i
                                                    class="fa-solid fa-clock mr-1"></i> Fee Belum Cair</span>
                                        @endif
                                    </div>
                                    <form action="{{ route('admin.earnings.toggle-paid', $project->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="type" value="programmer">
                                        <button type="submit"
                                            class="text-[10px] px-3 py-1.5 rounded font-bold shadow-sm transition-all focus:ring-2 focus:outline-none 
                                            {{ $project->is_programmer_paid ? 'bg-white border border-gray-200 text-gray-500 hover:bg-gray-100' : 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-300' }}">
                                            {{ $project->is_programmer_paid ? 'Batalkan' : 'Tandai Cair' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-400">
                                <i class="fa-solid fa-ghost text-3xl mb-3"></i>
                                <p class="text-sm">Belum ada proyek aplikasi.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col max-h-[600px]">
                    <div class="px-6 py-5 border-b border-amber-100 bg-amber-50/30 flex items-center justify-between">
                        <h3 class="font-bold text-[#1E293B]"><i class="fa-solid fa-file-word text-amber-500 mr-2"></i>
                            Histori Penyusun Naskah</h3>
                        <span
                            class="bg-amber-100 text-amber-700 text-xs px-2 py-1 rounded-md font-bold">{{ $writerProjects->count() }}
                            Proyek</span>
                    </div>

                    <div class="divide-y divide-gray-100 overflow-y-auto flex-1">
                        @forelse($writerProjects as $project)
                            <div
                                class="p-5 hover:bg-gray-50 transition-colors {{ !$project->is_writer_paid ? 'bg-red-50/10' : '' }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-[#1E293B] text-sm">{{ $project->client_name }}</h4>
                                    <span class="font-black text-amber-600">Rp
                                        {{ number_format($project->writer_price, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-xs text-gray-500 line-clamp-1 mb-2">
                                    {{ $project->skripsi_title ?? $project->project_description }}
                                </p>

                                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                                    <div class="text-[11px] font-medium">
                                        @if ($project->is_writer_paid)
                                            <span class="text-emerald-600 bg-emerald-50 px-2 py-1 rounded"><i
                                                    class="fa-solid fa-check-double mr-1"></i> Fee Sudah Cair</span>
                                        @else
                                            <span class="text-red-500 bg-red-50 px-2 py-1 rounded"><i
                                                    class="fa-solid fa-clock mr-1"></i> Fee Belum Cair</span>
                                        @endif
                                    </div>
                                    <form action="{{ route('admin.earnings.toggle-paid', $project->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="type" value="writer">
                                        <button type="submit"
                                            class="text-[10px] px-3 py-1.5 rounded font-bold shadow-sm transition-all focus:ring-2 focus:outline-none 
                                            {{ $project->is_writer_paid ? 'bg-white border border-gray-200 text-gray-500 hover:bg-gray-100' : 'bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-300' }}">
                                            {{ $project->is_writer_paid ? 'Batalkan' : 'Tandai Cair' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-400">
                                <i class="fa-solid fa-ghost text-3xl mb-3"></i>
                                <p class="text-sm">Belum ada proyek naskah.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
