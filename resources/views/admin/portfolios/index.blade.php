<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">Daftar Portofolio</h2>
            <a href="{{ route('admin.portfolios.create') }}"
                class="bg-[#1E293B] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition text-sm font-semibold shadow-sm">+
                Tambah Karya</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto">
        @if (session('success'))
            <div
                class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm text-sm text-green-700 font-medium">
                <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase">Gambar</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase">Judul &
                                Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase">Klien</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-[#1E293B] uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($portfolios as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ asset('uploads/portfolios/' . $item->image) }}"
                                        class="w-20 h-14 object-cover rounded shadow-sm border border-gray-200">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-[#1E293B]">{{ $item->title }}</div>
                                    <div class="text-xs text-amber-600 font-semibold">{{ $item->category }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $item->client_name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.portfolios.edit', $item->id) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-4"><i
                                            class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    <form action="{{ route('admin.portfolios.destroy', $item->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Hapus portofolio ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"><i
                                                class="fa-solid fa-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada portofolio.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($portfolios->hasPages())
                <div class="p-4 border-t border-gray-200">{{ $portfolios->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
