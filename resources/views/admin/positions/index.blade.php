<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight flex items-center gap-2">
                <i class="fa-solid fa-id-badge text-amber-500"></i>
                Daftar Jabatan Organisasi
            </h2>
            <a href="{{ route('admin.positions.create') }}"
                class="bg-[#1E293B] text-white px-4 py-2 rounded-md hover:bg-slate-800 transition text-sm font-semibold shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Jabatan
            </a>
        </div>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div
                    class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm flex items-start gap-3">
                    <i class="fa-solid fa-circle-check text-green-500 mt-0.5"></i>
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-[#1E293B] uppercase tracking-wider">
                                    Jabatan & Preview Badge
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-[#1E293B] uppercase tracking-wider">
                                    Divisi (Department)
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-[#1E293B] uppercase tracking-wider">
                                    Atasan Langsung
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-[#1E293B] uppercase tracking-wider">
                                    Total Karyawan
                                </th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-bold text-[#1E293B] uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($positions as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors duration-200">

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="text-sm font-bold text-gray-900">{{ $item->name }}</span>

                                            @php
                                                $bgClass = $item->color_bg ?? 'bg-gray-100';
                                                $textClass = $item->color_text ?? 'text-gray-700';
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md border border-gray-200 {{ $bgClass }} {{ $textClass }} bg-opacity-10 mt-1">
                                                @if ($item->icon)
                                                    <i class="{{ $item->icon }} mr-1.5 text-[11px]"></i>
                                                @endif
                                                {{ $item->name }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600 font-medium flex items-center gap-2">
                                            <i class="fa-solid fa-layer-group text-gray-300"></i>
                                            {{ $item->department ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($item->parent)
                                            <div class="flex items-center gap-2 text-sm text-slate-700">
                                                <i
                                                    class="fa-solid fa-arrow-turn-up fa-rotate-90 text-amber-500 text-xs"></i>
                                                <span class="font-semibold">{{ $item->parent->name }}</span>
                                            </div>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                <i class="fa-solid fa-star text-[10px] mr-1"></i> Pucuk Pimpinan
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        @php
                                            $userCount = $item->users()->count();
                                        @endphp
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-users text-gray-400"></i>
                                            <span
                                                class="{{ $userCount > 0 ? 'font-bold text-[#1E293B]' : 'text-gray-400' }}">
                                                {{ $userCount }} Orang
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center gap-4">
                                            <a href="{{ route('admin.positions.edit', $item->id) }}"
                                                class="text-blue-600 hover:text-blue-900 transition flex items-center gap-1">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>

                                            @if ($userCount > 0 || $item->children()->count() > 0)
                                                <button type="button"
                                                    class="text-gray-300 cursor-not-allowed flex items-center gap-1"
                                                    title="Tidak dapat dihapus karena sedang digunakan atau memiliki bawahan">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            @else
                                                <form action="{{ route('admin.positions.destroy', $item->id) }}"
                                                    method="POST" class="inline-block form-delete"
                                                    data-name="{{ $item->name }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 transition flex items-center gap-1">
                                                        <i class="fa-solid fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-solid fa-folder-open text-4xl text-gray-300 mb-3"></i>
                                            <p class="text-lg font-medium text-gray-900">Belum ada data jabatan</p>
                                            <p class="text-sm">Silakan tambah jabatan baru untuk menstrukturisasi
                                                perusahaan Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($positions->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $positions->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
