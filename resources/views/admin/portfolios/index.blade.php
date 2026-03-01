<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
                <i class="fa-solid fa-briefcase text-amber-500 mr-2"></i> {{ __('Daftar Portofolio') }}
            </h2>
            <a href="{{ route('admin.portfolios.create') }}"
                class="bg-[#1E293B] text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm font-bold shadow-sm flex items-center">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Karya
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                    <p class="text-sm text-green-700 font-medium"><i
                            class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">

                <x-admin.search-filter action="{{ route('admin.portfolios.index') }}"
                    searchPlaceholder="Cari judul proyek atau nama klien..." />

                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="w-32 px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Gambar</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Judul & Kategori</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Klien</th>
                                <th scope="col"
                                    class="w-32 px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($portfolios as $item)
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="w-24 h-16 rounded-lg overflow-hidden border border-gray-200 shadow-sm bg-gray-100 flex items-center justify-center">
                                            @if ($item->image)
                                                <img src="{{ asset('uploads/portfolios/' . $item->thumbnail) }}"
                                                    class="w-full h-full object-cover transition duration-300 hover:scale-110"
                                                    alt="{{ $item->title }}">
                                            @else
                                                <i class="fa-solid fa-image text-gray-300 text-2xl"></i>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-base font-bold text-[#1E293B] mb-1">{{ $item->title }}</div>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 uppercase tracking-wider">
                                            <i class="fa-solid fa-tag mr-1.5"></i> {{ $item->category }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm font-medium text-gray-700">
                                            <i class="fa-solid fa-user-tie text-gray-400 mr-2"></i>
                                            {{ $item->client_name ?? 'Internal / Pribadi' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-2">

                                            <a href="{{ route('admin.portfolios.show', $item->id) }}"
                                                class="text-teal-600 hover:text-teal-900 bg-teal-50 hover:bg-teal-100 p-2.5 rounded-lg transition shadow-sm"
                                                title="Lihat Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.portfolios.edit', $item->id) }}"
                                                class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2.5 rounded-lg transition shadow-sm"
                                                title="Edit Data">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <form action="{{ route('admin.portfolios.destroy', $item->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Yakin ingin menghapus portofolio ini secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2.5 rounded-lg transition shadow-sm"
                                                    title="Hapus Data">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-regular fa-folder-open text-5xl mb-4 text-gray-300"></i>
                                            <p class="text-lg font-medium text-gray-600">Belum ada portofolio</p>
                                            <p class="text-sm text-gray-400 mt-1">Mulai tambahkan karya terbaikmu agar
                                                dilihat oleh calon klien.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($portfolios->hasPages())
                    <div class="mt-6 border-t border-gray-100 pt-4">
                        {{ $portfolios->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
