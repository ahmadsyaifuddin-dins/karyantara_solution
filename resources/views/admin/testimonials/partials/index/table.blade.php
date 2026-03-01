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
                        & Kontak</th>
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
                            <img class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm"
                                src="{{ $item->profile_image ? asset('uploads/testimonials/' . $item->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($item->client_name) . '&background=1E293B&color=fff' }}"
                                alt="{{ $item->client_name }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">{{ $item->client_name }}</div>
                            <div class="text-xs text-gray-500"><i
                                    class="fa-regular fa-envelope mr-1"></i>{{ $item->email ?? '-' }}</div>

                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs font-bold text-green-600 flex items-center">
                                    <i class="fa-brands fa-whatsapp mr-1"></i>{{ $item->phone_number ?? '-' }}
                                </span>
                                @if ($item->phone_number)
                                    <a href="https://wa.me/{{ $item->phone_number }}" target="_blank"
                                        class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded font-black hover:bg-green-200 uppercase">Chat</a>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span
                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->is_approved ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                                <i
                                    class="fa-solid {{ $item->is_approved ? 'fa-check-circle' : 'fa-clock' }} mr-1 mt-0.5"></i>
                                {{ $item->is_approved ? 'Dipublikasi' : 'Pending' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex text-amber-400 text-xs mb-1">
                                @for ($i = 0; $i < $item->rating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                            <div class="text-sm text-gray-600 line-clamp-2 max-w-xs" title="{{ $item->testimonial }}">
                                "{{ $item->testimonial }}"</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end items-center gap-3">
                                <form action="{{ route('admin.testimonials.toggle-status', $item->id) }}"
                                    method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="{{ $item->is_approved ? 'text-amber-600 hover:text-amber-900' : 'text-green-600 hover:text-green-900' }}"
                                        title="{{ $item->is_approved ? 'Sembunyikan' : 'ACC' }}">
                                        <i
                                            class="fa-solid {{ $item->is_approved ? 'fa-eye-slash' : 'fa-check-double' }}"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.testimonials.show', $item->id) }}"
                                    class="text-teal-600 hover:text-teal-900"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('admin.testimonials.edit', $item->id) }}"
                                    class="text-blue-600 hover:text-blue-900"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.testimonials.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus data ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"><i
                                            class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</div>
