<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
                <i class="fa-solid fa-file-invoice-dollar mr-2"></i> {{ __('Daftar Klien & Proyek') }}
            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.projects.export.pdf') }}" target="_blank"
                    class="bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition inline-flex items-center">
                    <i class="fa-solid fa-file-pdf mr-1"></i> Export PDF
                </a>

                <a href="{{ route('admin.projects.export.excel') }}"
                    class="bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition inline-flex items-center">
                    <i class="fa-solid fa-file-excel mr-1"></i> Export Excel
                </a>

                <a href="{{ route('admin.projects.create') }}"
                    class="bg-[#1E293B] text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm font-bold shadow-sm inline-flex items-center">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Data
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-amber-50 border-l-4 border-amber-500 p-5 rounded-r-xl shadow-sm">
                <h3 class="font-bold text-amber-800 mb-2"><i class="fa-solid fa-bullhorn mr-2"></i>Disclaimer & Rules
                    Pengerjaan:</h3>
                <ul class="list-disc pl-5 text-sm text-amber-700 space-y-1">
                    <li>Pengerjaan selesai per Skripsi <b>target maks 7 hari</b>, tidak bisa selesai 1 hari full (bukan
                        Proyek Roro Jonggrang).</li>
                    <li>Harga Skripsi paling rendah <b>Rp 1.200.000</b> (sudah termasuk potongan fee perantara/bersih).
                        Harga bisa naik tergantung tingkat kerumitan aplikasi.</li>
                    <li><i class="fa-solid fa-file-contract mr-1"></i> <b>Dokumen Kesepakatan (MoU):</b> Untuk proyek
                        besar (> Rp 2 Juta), sangat disarankan membuat invoice/dokumen kesepakatan PDF.</li>
                </ul>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                    <p class="text-sm text-green-700 font-medium"><i
                            class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Pendapatan Bersih</p>
                        <h4 class="text-2xl font-black text-[#1E293B] mt-1">Rp
                            {{ number_format($totalNetIncome, 0, ',', '.') }}</h4>
                    </div>
                    <div
                        class="w-12 h-12 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Sudah Terbayar</p>
                        <h4 class="text-2xl font-black text-emerald-600 mt-1">Rp
                            {{ number_format($totalPaid, 0, ',', '.') }}</h4>
                    </div>
                    <div
                        class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Sisa Pembayaran</p>
                        <h4 class="text-2xl font-black text-red-500 mt-1">Rp
                            {{ number_format($totalRemaining, 0, ',', '.') }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <x-admin.search-filter action="{{ route('admin.projects.index') }}"
                    searchPlaceholder="Cari nama klien, judul skripsi, atau NPM..." :options="[
                        'Pending' => 'Pending',
                        'Progress' => 'Progress',
                        'Revisi' => 'Revisi',
                        'Selesai' => 'Selesai',
                    ]" />

                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed w-[1400px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="w-12 px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th scope="col"
                                    class="w-64 px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Klien & Akademik</th>
                                <th scope="col"
                                    class="w-72 px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Pekerjaan & Skripsi</th>
                                <th scope="col"
                                    class="w-32 px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="w-56 px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Finansial</th>
                                <th scope="col"
                                    class="w-32 px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($projects as $index => $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $projects->firstItem() + $index }}
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-2 mb-1">
                                            @if ($item->client_type == 'mahasiswa')
                                                <span
                                                    class="px-2 py-0.5 text-[10px] font-bold bg-blue-100 text-blue-700 rounded uppercase">Mahasiswa</span>
                                            @else
                                                <span
                                                    class="px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-700 rounded uppercase">Umum</span>
                                            @endif

                                            @if (!$item->is_shared)
                                                <span class="text-gray-400" title="Private Project"><i
                                                        class="fa-solid fa-lock text-xs"></i></span>
                                            @endif
                                        </div>
                                        <div class="font-bold text-[#1E293B]">{{ $item->client_name }}</div>
                                        @if ($item->client_type == 'mahasiswa')
                                            <div class="text-xs text-gray-500 mt-1"><i
                                                    class="fa-solid fa-id-card mr-1"></i> NPM: {{ $item->npm ?? '-' }}
                                            </div>
                                            <div class="text-xs text-gray-500"><i
                                                    class="fa-solid fa-building-columns mr-1"></i> KLS:
                                                {{ $item->class_name ?? '-' }}</div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-4">
                                        @if ($item->client_type == 'mahasiswa' && $item->skripsi_title)
                                            <div class="text-sm font-semibold text-gray-800 line-clamp-2 mb-1 border-b border-gray-100 pb-1"
                                                title="{{ $item->skripsi_title }}">
                                                "{{ $item->skripsi_title }}"
                                            </div>
                                        @endif
                                        <div class="text-sm text-gray-600 line-clamp-2 mb-2"
                                            title="{{ $item->project_description }}">
                                            {{ $item->project_description }}
                                        </div>
                                        @if ($item->client_type == 'mahasiswa')
                                            <div class="text-[11px] text-gray-400 leading-tight">
                                                <b>DP 1:</b> {{ $item->dospem_1 ?? '-' }} <br>
                                                <b>DP 2:</b> {{ $item->dospem_2 ?? '-' }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        @php
                                            $badgeColors = [
                                                'Pending' => 'bg-gray-100 text-gray-800',
                                                'Progress' => 'bg-blue-100 text-blue-800',
                                                'Revisi' => 'bg-amber-100 text-amber-800 animate-pulse',
                                                'Selesai' => 'bg-emerald-100 text-emerald-800',
                                            ];
                                        @endphp
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $badgeColors[$item->status] }}">
                                            {{ $item->status }}
                                        </span>
                                        @if ($item->revision_notes)
                                            <div class="mt-2 text-[10px] text-amber-600 bg-amber-50 p-1.5 rounded border border-amber-100 line-clamp-2 text-left"
                                                title="{{ $item->revision_notes }}">
                                                <i
                                                    class="fa-solid fa-triangle-exclamation mr-1"></i>{{ $item->revision_notes }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="text-gray-500">Net/Harga:</span>
                                            <span class="font-bold text-[#1E293B]">Rp
                                                {{ number_format($item->net_income, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="text-gray-500">Terbayar:</span>
                                            <span class="font-bold text-emerald-600">Rp
                                                {{ number_format($item->paid_amount, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm pt-1 border-t border-gray-100 mt-1">
                                            <span class="text-gray-500 font-bold">Sisa:</span>
                                            @if ($item->is_paid_off)
                                                <span
                                                    class="font-bold text-green-500 text-xs px-2 py-0.5 bg-green-50 rounded">LUNAS</span>
                                            @else
                                                <span class="font-bold text-red-500">Rp
                                                    {{ number_format($item->remaining_amount, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                        <div class="text-right mt-1">
                                            <span class="text-[10px] text-gray-400 uppercase tracking-wider"><i
                                                    class="fa-solid {{ $item->payment_method == 'cash' ? 'fa-money-bill' : 'fa-building-columns' }} mr-1"></i>
                                                Via {{ $item->payment_method }}</span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.projects.show', $item->id) }}"
                                                class="text-teal-600 hover:text-teal-900 bg-teal-50 hover:bg-teal-100 p-2 rounded transition"
                                                title="Lihat Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.projects.edit', $item->id) }}"
                                                class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded transition"
                                                title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('admin.projects.destroy', $item->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded transition"
                                                    title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-regular fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                            <p>Belum ada data klien / proyek.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($projects->hasPages())
                    <div class="mt-6 border-t border-gray-100 pt-4">
                        {{ $projects->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
