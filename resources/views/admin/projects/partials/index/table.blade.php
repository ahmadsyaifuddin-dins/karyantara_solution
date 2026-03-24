<div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
    <x-admin.search-filter action="{{ route('admin.projects.index') }}"
        searchPlaceholder="Cari nama klien, judul skripsi, atau NPM..." :options="[
            'Pending' => 'Pending',
            'Progress' => 'Progress',
            'Revisi' => 'Revisi',
            'Selesai' => 'Selesai',
        ]" :paymentOptions="[
            'lunas' => 'Sudah Lunas',
            'belum_lunas' => 'Belum Lunas',
        ]" />

    <div class="overflow-x-auto mt-4">
        <table class="min-w-full divide-y divide-gray-200 table-fixed w-[1400px]">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="w-12 px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No
                    </th>
                    <th scope="col"
                        class="w-72 px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
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
                    <tr
                        class="transition-colors duration-200 border-b {{ $item->is_paid_off ? 'bg-emerald-100 hover:bg-emerald-200' : 'bg-white hover:bg-gray-50' }}">

                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $projects->firstItem() + $index }}
                        </td>

                        <td class="px-4 py-4">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                @if ($item->client_type == 'mahasiswa')
                                    <span
                                        class="px-2 py-0.5 text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200 rounded uppercase">Mahasiswa</span>
                                @else
                                    <span
                                        class="px-2 py-0.5 text-[10px] font-bold bg-gray-100 text-gray-700 border border-gray-200 rounded uppercase">Umum</span>
                                @endif

                                @if ($item->skripsi_package)
                                    @php
                                        // Array Mapping untuk 10 Jenis Paket agar rapi
                                        $pkg = $item->skripsi_package;
                                        $badges = [
                                            // SKRIPSI
                                            'keduanya' => [
                                                'class' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                'icon' => 'fa-layer-group',
                                                'text' => 'All-In',
                                                'title' => 'Skripsi: Aplikasi + Naskah',
                                            ],
                                            'aplikasi' => [
                                                'class' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                'icon' => 'fa-code',
                                                'text' => 'App',
                                                'title' => 'Skripsi: Hanya Aplikasi',
                                            ],
                                            'naskah' => [
                                                'class' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                'icon' => 'fa-file-word',
                                                'text' => 'Naskah',
                                                'title' => 'Skripsi: Hanya Naskah',
                                            ],

                                            // SEMPRO
                                            'sempro_keduanya' => [
                                                'class' => 'bg-teal-100 text-teal-700 border-teal-200',
                                                'icon' => 'fa-cubes-stacked',
                                                'text' => 'Sempro All-In',
                                                'title' => 'Sempro: Aplikasi + Naskah Bab 1-3',
                                            ],
                                            'sempro_naskah' => [
                                                'class' => 'bg-teal-100 text-teal-700 border-teal-200',
                                                'icon' => 'fa-file-lines',
                                                'text' => 'Sempro 1-3',
                                                'title' => 'Sempro: Naskah Bab 1-3',
                                            ],
                                            'sempro_bab3' => [
                                                'class' => 'bg-teal-100 text-teal-700 border-teal-200',
                                                'icon' => 'fa-solid fa-file-lines',
                                                'text' => 'Sempro Bab 3',
                                                'title' => 'Sempro: Khusus Bab 3',
                                            ],

                                            // SIDANG
                                            'sidang_keduanya' => [
                                                'class' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'icon' => 'fa-medal',
                                                'text' => 'Sidang All-In',
                                                'title' => 'Sidang: Revisi App + Bab 4-5',
                                            ],
                                            'sidang_aplikasi' => [
                                                'class' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'icon' => 'fa-laptop-code',
                                                'text' => 'Revisi App',
                                                'title' => 'Sidang: Revisi Aplikasi',
                                            ],
                                            'sidang_naskah' => [
                                                'class' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'icon' => 'fa-book-open',
                                                'text' => 'Bab 4-5',
                                                'title' => 'Sidang: Naskah Bab 4-5',
                                            ],
                                            'sidang_bab4' => [
                                                'class' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'icon' => 'fa-vial-circle-check',
                                                'text' => 'Bab 4 Saja',
                                                'title' => 'Sidang: Khusus Bab 4 / Blackbox',
                                            ],
                                        ];

                                        $currentBadge = $badges[$pkg] ?? null;
                                    @endphp

                                    @if ($currentBadge)
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold border rounded uppercase flex items-center {{ $currentBadge['class'] }}"
                                            title="{{ $currentBadge['title'] }}">
                                            <i class="fa-solid {{ $currentBadge['icon'] }} mr-1"></i>
                                            {{ $currentBadge['text'] }}
                                        </span>
                                    @endif
                                @endif

                                @if (!$item->is_shared)
                                    <span class="text-red-400 ml-1" title="Private Project"><i
                                            class="fa-solid fa-lock text-xs"></i></span>
                                @endif
                            </div>

                            <div class="font-bold text-[#1E293B] flex items-center gap-2 mt-1">
                                {{ $item->client_name }}

                                @if ($item->status != 'Selesai')
                                    @if ($index == 0 && $projects->currentPage() == 1)
                                        <span
                                            class="px-2 py-0.5 text-[9px] font-black bg-red-100 text-red-600 rounded flex items-center shadow-sm"
                                            title="Prioritas Utama">
                                            <i class="fa-solid fa-fire mr-1 animate-pulse"></i> PRIORITAS 1
                                        </span>
                                    @elseif($index <= 2 && $projects->currentPage() == 1)
                                        <span
                                            class="px-2 py-0.5 text-[9px] font-black bg-orange-100 text-orange-600 rounded flex items-center shadow-sm"
                                            title="Prioritas Tinggi">
                                            <i class="fa-solid fa-star mr-1"></i> TOP {{ $index + 1 }}
                                        </span>
                                    @endif
                                @endif
                            </div>

                            @if ($item->client_type == 'mahasiswa')
                                <div class="text-[11px] text-gray-500 mt-1">
                                    <i class="fa-solid fa-id-card mr-1 text-gray-400"></i>
                                    {{ $item->npm ?? '-' }}
                                    <span class="mx-1 text-gray-300">|</span>
                                    <i class="fa-solid fa-building-columns mr-1 text-gray-400"></i>
                                    {{ $item->class_name ?? '-' }}
                                </div>
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
                                $statusColors = [
                                    'Pending' => 'bg-gray-100 text-gray-800',
                                    'Progress' => 'bg-blue-100 text-blue-800',
                                    'Revisi' => 'bg-amber-100 text-amber-800 animate-pulse',
                                    'Selesai' => 'bg-emerald-100 text-emerald-800',
                                ];
                            @endphp
                            <span
                                class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border border-gray-100 shadow-sm {{ $statusColors[$item->status] }}">
                                {{ $item->status }}
                            </span>
                            @if ($item->revision_notes)
                                <div class="mt-2 text-[10px] text-amber-600 bg-amber-50 p-1.5 rounded border border-amber-100 line-clamp-2 text-left"
                                    title="{{ $item->revision_notes }}">
                                    <i class="fa-solid fa-triangle-exclamation mr-1"></i>{{ $item->revision_notes }}
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
                                        class="font-bold text-emerald-600 text-[10px] px-2 py-0.5 bg-emerald-100 rounded shadow-sm">
                                        <i class="fa-solid fa-check-double mr-1"></i>LUNAS
                                    </span>
                                @else
                                    <span class="font-bold text-red-500">Rp
                                        {{ number_format($item->remaining_amount, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            <div class="text-right mt-1">
                                <span class="text-[10px] text-gray-400 uppercase tracking-wider">
                                    <i
                                        class="fa-solid {{ $item->payment_method == 'cash' ? 'fa-money-bill' : 'fa-building-columns' }} mr-1"></i>
                                    Via {{ $item->payment_method }}
                                </span>
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
                                <form action="{{ route('admin.projects.destroy', $item->id) }}" method="POST"
                                    class="inline-block form-delete" data-name="{{ $item->client_name }}">
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
