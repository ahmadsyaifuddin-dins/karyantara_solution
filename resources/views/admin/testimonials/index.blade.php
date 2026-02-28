<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
                {{ __('Daftar Testimonial') }}
            </h2>
            <a href="{{ route('admin.testimonials.create') }}"
                class="bg-[#1E293B] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition text-sm font-semibold shadow-sm">
                + Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-12">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Profil</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Klien</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Rating</th>
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
                                <tr class="hover:bg-gray-50 transition">
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
                                        <div class="text-sm font-semibold text-gray-900">{{ $item->client_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->client_title ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex text-amber-400 text-xs">
                                            @for ($i = 0; $i < $item->rating; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600 line-clamp-2 max-w-sm"
                                            title="{{ $item->testimonial }}">
                                            {{ $item->testimonial }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.testimonials.edit', $item->id) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-4 transition"><i
                                                class="fa-solid fa-pen-to-square"></i> Edit</a>

                                        <form action="{{ route('admin.testimonials.destroy', $item->id) }}"
                                            method="POST" class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data testimonial ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition"><i
                                                    class="fa-solid fa-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
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
