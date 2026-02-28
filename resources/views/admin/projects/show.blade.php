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

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center gap-4">
                    <div
                        class="w-16 h-16 rounded-full bg-[#1E293B] text-amber-500 flex items-center justify-center text-2xl font-black shadow-inner">
                        {{ strtoupper(substr($project->client_name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-[#1E293B]">{{ $project->client_name }}</h3>
                        <div class="flex items-center gap-3 mt-1 text-sm text-gray-500 font-medium">
                            <span class="flex items-center">
                                <i class="fa-solid fa-user-tag mr-1 text-gray-400"></i>
                                Klien {{ ucfirst($project->client_type) }}
                            </span>
                            <span class="text-gray-300">|</span>
                            <span class="flex items-center">
                                <i class="fa-solid fa-calendar-day mr-1 text-gray-400"></i>
                                Masuk: {{ $project->created_at->locale('id')->translatedFormat('d F Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-2">
                    @php
                        $badgeColors = [
                            'Pending' => 'bg-gray-100 text-gray-800 border-gray-200',
                            'Progress' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'Revisi' => 'bg-amber-100 text-amber-800 border-amber-200 animate-pulse',
                            'Selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                        ];
                    @endphp
                    <span
                        class="px-4 py-1.5 border inline-flex text-sm font-bold rounded-full {{ $badgeColors[$project->status] }} shadow-sm">
                        Status: {{ $project->status }}
                    </span>
                    <div class="text-xs text-gray-500 font-medium">
                        Admin Penanggung Jawab: <span
                            class="text-[#1E293B] font-bold">{{ $project->admin->name ?? 'Unknown' }}</span>
                        @if (!$project->is_shared)
                            <span class="ml-1 text-red-500" title="Private"><i class="fa-solid fa-lock"></i></span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 space-y-6">

                    <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">
                        <div
                            class="bg-emerald-50/50 px-5 py-4 border-b border-emerald-100 flex items-center justify-between">
                            <h4 class="font-bold text-emerald-800"><i class="fa-solid fa-rupiah-sign mr-2"></i> Rincian
                                Keuangan</h4>
                            @if ($project->is_paid_off)
                                <span
                                    class="bg-emerald-500 text-white text-[10px] px-2 py-0.5 rounded font-bold tracking-wider">LUNAS</span>
                            @else
                                <span
                                    class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded font-bold tracking-wider">BELUM
                                    LUNAS</span>
                            @endif
                        </div>
                        <div class="p-5 space-y-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Harga Fix
                                    (Pendapatan Bersih)</p>
                                <p class="text-lg font-black text-[#1E293B]">Rp
                                    {{ number_format($project->net_income, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Sudah Terbayar
                                </p>
                                <p class="text-lg font-black text-emerald-600">Rp
                                    {{ number_format($project->paid_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Sisa Pembayaran
                                </p>
                                <p class="text-xl font-black text-red-500">Rp
                                    {{ number_format($project->remaining_amount, 0, ',', '.') }}</p>
                            </div>
                            <div
                                class="bg-gray-50 p-3 rounded-lg border border-gray-100 text-xs font-medium text-gray-600 flex items-center">
                                <i
                                    class="fa-solid {{ $project->payment_method == 'cash' ? 'fa-money-bill text-green-500' : 'fa-building-columns text-blue-500' }} mr-2 text-lg"></i>
                                Metode Pembayaran: <span
                                    class="font-bold ml-1 uppercase">{{ $project->payment_method }}</span>
                            </div>
                        </div>
                    </div>

                    @if ($project->client_type === 'mahasiswa')
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="bg-gray-50 px-5 py-4 border-b border-gray-200">
                                <h4 class="font-bold text-[#1E293B]"><i
                                        class="fa-solid fa-graduation-cap text-amber-500 mr-2"></i> Info Akademik</h4>
                            </div>
                            <div class="p-5 space-y-3">
                                <div>
                                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">NPM
                                        / NIM</span>
                                    <span class="font-semibold text-gray-800">{{ $project->npm ?? '-' }}</span>
                                </div>
                                <div>
                                    <span
                                        class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kelas
                                        / Jurusan</span>
                                    <span class="font-semibold text-gray-800">{{ $project->class_name ?? '-' }}</span>
                                </div>
                                <div class="pt-2 border-t border-gray-50">
                                    <span
                                        class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Dosen
                                        Pembimbing</span>
                                    <ul class="text-sm font-medium text-gray-700 space-y-1">
                                        <li><i class="fa-solid fa-user-tie text-gray-400 mr-1 text-xs"></i> 1:
                                            {{ $project->dospem_1 ?? '-' }}</li>
                                        <li><i class="fa-solid fa-user-tie text-gray-400 mr-1 text-xs"></i> 2:
                                            {{ $project->dospem_2 ?? '-' }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden h-full">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h4 class="font-bold text-[#1E293B]"><i
                                    class="fa-solid fa-list-check text-blue-500 mr-2"></i> Ruang Lingkup Pekerjaan</h4>
                        </div>
                        <div class="p-6">

                            @if ($project->client_type === 'mahasiswa')
                                <div class="mb-6 pb-6 border-b border-gray-100">
                                    <span
                                        class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Judul
                                        Skripsi (Fix)</span>
                                    <h3 class="text-lg font-bold text-gray-800 leading-relaxed">
                                        {{ $project->skripsi_title ? '"' . $project->skripsi_title . '"' : 'Belum ada judul skripsi' }}
                                    </h3>
                                </div>
                            @endif

                            <div class="mb-6">
                                <span
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi
                                    Fitur / Aplikasi yang dibuat</span>
                                <div
                                    class="prose max-w-none text-gray-700 bg-slate-50 p-5 rounded-xl border border-gray-100 whitespace-pre-line leading-relaxed">
                                    {{ $project->project_description }}
                                </div>
                            </div>

                            @if ($project->revision_notes)
                                <div class="mt-8">
                                    <span
                                        class="flex items-center text-xs font-bold text-amber-600 uppercase tracking-wider mb-2">
                                        <i class="fa-solid fa-triangle-exclamation mr-2"></i> Catatan Revisi Aktif
                                    </span>
                                    <div
                                        class="bg-amber-50 p-5 rounded-xl border border-amber-200 text-amber-800 whitespace-pre-line leading-relaxed font-medium text-sm">
                                        {{ $project->revision_notes }}
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
