<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
                {{ __('Daftar Testimonial') }}
            </h2>

            <div class="flex items-center gap-4">
                <form action="{{ route('admin.testimonials.toggle-setting') }}" method="POST"
                    class="flex items-center bg-white px-3 py-1.5 rounded-md shadow-sm border border-gray-200">
                    @csrf
                    <span class="text-xs font-bold text-gray-600 mr-3 uppercase tracking-wider">Auto-Publish
                        Guest:</span>
                    <label for="auto_approve_toggle" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="hidden" name="auto_approve" value="0">
                            <input type="checkbox" id="auto_approve_toggle" name="auto_approve" value="1"
                                class="sr-only" onchange="this.form.submit()"
                                {{ $autoApproveSetting == '1' ? 'checked' : '' }}>
                            <div
                                class="block {{ $autoApproveSetting == '1' ? 'bg-amber-500' : 'bg-gray-300' }} w-10 h-6 rounded-full transition-colors duration-300">
                            </div>
                            <div
                                class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-300 {{ $autoApproveSetting == '1' ? 'transform translate-x-4' : '' }}">
                            </div>
                        </div>
                        <div
                            class="ml-2 text-sm font-semibold {{ $autoApproveSetting == '1' ? 'text-amber-600' : 'text-gray-500' }}">
                            {{ $autoApproveSetting == '1' ? 'ON' : 'OFF' }}
                        </div>
                    </label>
                </form>

                <a href="{{ route('admin.testimonials.create') }}"
                    class="bg-[#1E293B] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition text-sm font-semibold shadow-sm whitespace-nowrap">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Data
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="bulkManager('{{ route('admin.testimonials.bulk-action') }}', '{{ route('admin.testimonials.action-all') }}')">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-circle-check text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-medium">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div
                class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-t-lg shadow-sm border-b border-gray-200">

                <div class="flex items-center gap-2 mb-4 sm:mb-0">
                    <span class="text-sm font-semibold text-gray-500 mr-2 border-r pr-4 border-gray-300">
                        <span x-text="selectedIds.length"></span> Terpilih
                    </span>

                    <button @click="submitBulk('approve')" :disabled="selectedIds.length === 0"
                        class="px-3 py-1.5 text-xs font-bold rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed bg-green-100 text-green-700 hover:bg-green-200">
                        <i class="fa-solid fa-check mr-1"></i> ACC Terpilih
                    </button>
                    <button @click="submitBulk('hide')" :disabled="selectedIds.length === 0"
                        class="px-3 py-1.5 text-xs font-bold rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed bg-amber-100 text-amber-700 hover:bg-amber-200">
                        <i class="fa-solid fa-eye-slash mr-1"></i> Sembunyikan Terpilih
                    </button>
                    <button @click="submitBulk('delete')" :disabled="selectedIds.length === 0"
                        class="px-3 py-1.5 text-xs font-bold rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed bg-red-100 text-red-700 hover:bg-red-200">
                        <i class="fa-solid fa-trash mr-1"></i> Hapus Terpilih
                    </button>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider mr-2">Global:</span>
                    <button @click="submitAll('approve')"
                        class="px-3 py-1.5 text-xs font-bold bg-[#1E293B] text-white rounded-md hover:bg-gray-800 transition shadow-sm">
                        <i class="fa-solid fa-check-double mr-1"></i> ACC Semua
                    </button>
                    <button @click="submitAll('hide')"
                        class="px-3 py-1.5 text-xs font-bold bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition shadow-sm">
                        <i class="fa-solid fa-eye-slash mr-1"></i> Sembunyikan Semua
                    </button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-b-lg">
                <div class="p-6 bg-white overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left w-12">
                                    <input type="checkbox" x-model="selectAll" @change="toggleAll"
                                        class="rounded border-gray-300 text-amber-500 shadow-sm focus:ring-amber-500 cursor-pointer">
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Profil</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Klien & Email</th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Testimonial</th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($testimonials as $item)
                                <tr
                                    class="hover:bg-gray-50 transition {{ $item->is_approved == 0 ? 'bg-amber-50/30' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" value="{{ $item->id }}" x-model="selectedIds"
                                            @change="checkItem"
                                            class="row-checkbox rounded border-gray-300 text-amber-500 shadow-sm focus:ring-amber-500 cursor-pointer">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($item->profile_image)
                                            <img class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm"
                                                src="{{ asset('uploads/testimonials/' . $item->profile_image) }}"
                                                alt="{{ $item->client_name }}">
                                        @else
                                            <img class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm"
                                                src="https://ui-avatars.com/api/?name={{ urlencode($item->client_name) }}&background=1E293B&color=fff"
                                                alt="Default Avatar">
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->client_name }}</div>
                                        <div class="text-xs text-gray-500 mb-1"><i
                                                class="fa-regular fa-envelope mr-1"></i>{{ $item->email ?? '-' }}</div>
                                        <div class="text-xs text-amber-500 font-medium">
                                            {{ $item->client_title ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($item->is_approved)
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                <i class="fa-solid fa-check-circle mr-1 mt-0.5"></i> Dipublikasi
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                                <i class="fa-solid fa-clock mr-1 mt-0.5"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex text-amber-400 text-xs mb-1">
                                            @for ($i = 0; $i < $item->rating; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor
                                        </div>
                                        <div class="text-sm text-gray-600 line-clamp-2 max-w-xs"
                                            title="{{ $item->testimonial }}">
                                            "{{ $item->testimonial }}"
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                        <form action="{{ route('admin.testimonials.toggle-status', $item->id) }}"
                                            method="POST" class="inline-block mr-3">
                                            @csrf
                                            @method('PATCH')
                                            @if ($item->is_approved)
                                                <button type="submit"
                                                    class="text-amber-600 hover:text-amber-900 transition"
                                                    title="Sembunyikan dari Publik">
                                                    <i class="fa-solid fa-eye-slash"></i>
                                                </button>
                                            @else
                                                <button type="submit"
                                                    class="text-green-600 hover:text-green-900 transition"
                                                    title="Publish ke Publik">
                                                    <i class="fa-solid fa-check"></i> ACC
                                                </button>
                                            @endif
                                        </form>

                                        <a href="{{ route('admin.testimonials.edit', $item->id) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-3 transition" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('admin.testimonials.destroy', $item->id) }}"
                                            method="POST" class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data testimonial ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition"
                                                title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-6 py-8 whitespace-nowrap text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-regular fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                            <p>Belum ada data testimonial.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($testimonials->hasPages())
                        <div class="mt-6">
                            {{ $testimonials->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
