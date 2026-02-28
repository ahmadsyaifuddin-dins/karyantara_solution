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
                        class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">Profil
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">Klien
                        & Email</th>
                    <th scope="col"
                        class="px-6 py-3 text-center text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                        Status</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                        Testimonial</th>
                    <th scope="col"
                        class="px-6 py-3 text-right text-xs font-semibold text-[#1E293B] uppercase tracking-wider">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($testimonials as $item)
                    <tr class="hover:bg-gray-50 transition {{ $item->is_approved == 0 ? 'bg-amber-50/30' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" value="{{ $item->id }}" x-model="selectedIds" @change="checkItem"
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
                            <div class="text-xs text-amber-500 font-medium">{{ $item->client_title ?? '-' }}</div>
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
                            <div class="text-sm text-gray-600 line-clamp-2 max-w-xs" title="{{ $item->testimonial }}">
                                "{{ $item->testimonial }}"
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="{{ route('admin.testimonials.toggle-status', $item->id) }}" method="POST"
                                class="inline-block mr-3">
                                @csrf
                                @method('PATCH')
                                @if ($item->is_approved)
                                    <button type="submit" class="text-amber-600 hover:text-amber-900 transition"
                                        title="Sembunyikan dari Publik">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                @else
                                    <button type="submit" class="text-green-600 hover:text-green-900 transition"
                                        title="Publish ke Publik">
                                        <i class="fa-solid fa-check"></i> ACC
                                    </button>
                                @endif
                            </form>
                            <a href="{{ route('admin.testimonials.show', $item->id) }}"
                                class="text-teal-600 hover:text-teal-900 mr-3 transition" title="Lihat Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.testimonials.edit', $item->id) }}"
                                class="text-blue-600 hover:text-blue-900 mr-3 transition" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.testimonials.destroy', $item->id) }}" method="POST"
                                class="inline-block"
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
                        <td colspan="6" class="px-6 py-8 whitespace-nowrap text-sm text-gray-500 text-center">
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
