<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
                Daftar Akun Admin
            </h2>
            <a href="{{ route('admin.admins.create') }}"
                class="bg-[#1E293B] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition text-sm font-semibold shadow-sm">
                + Tambah Admin
            </a>
        </div>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto">

            @if (session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                    <p class="text-sm text-green-700 font-medium"><i class="fa-solid fa-circle-check mr-2"></i>
                        {{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
                    <p class="text-sm text-red-700 font-medium"><i class="fa-solid fa-circle-exclamation mr-2"></i>
                        {{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Nama & Hak Akses
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Jabatan & Divisi
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Email
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Tanggal Bergabung
                                </th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($admins as $item)
                                @php
                                    // Ambil nama role pertama dari tabel spatie
                                    $roleName = $item->roles->pluck('name')->first();
                                @endphp
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 {{ $roleName === 'super_admin' ? 'bg-amber-500 text-[#1E293B]' : 'bg-[#1E293B] text-white' }} rounded-full flex items-center justify-center font-bold">
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-4 flex flex-col items-start">
                                                <div class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                                    {{ $item->name }}
                                                    @if ($item->id === Auth::id())
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-800">
                                                            ANDA
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="mt-1">
                                                    @if ($roleName === 'super_admin')
                                                        <span
                                                            class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-amber-600">
                                                            <i class="fa-solid fa-crown"></i> Super Admin
                                                        </span>
                                                    @elseif ($roleName)
                                                        <span
                                                            class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                                                            <i class="fa-solid fa-user-shield"></i>
                                                            {{ ucwords(str_replace('_', ' ', $roleName)) }}
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                                            <i class="fa-solid fa-user-xmark"></i> Belum ada role
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($item->position)
                                            <div>
                                                @php
                                                    // Membersihkan class agar bisa dipakai sebagai warna border/text/bg
                                                    $bgClass = $item->position->color_bg ?? 'bg-blue-50';
                                                    $textClass = $item->position->color_text ?? 'text-blue-700';
                                                @endphp
                                                <span
                                                    class="inline-flex px-2 py-0.5 text-[11px] font-bold rounded-md border border-gray-200 {{ $bgClass }} {{ $textClass }} bg-opacity-10">
                                                    @if ($item->position->icon)
                                                        <i class="{{ $item->position->icon }} mr-1.5"></i>
                                                    @endif
                                                    {{ $item->position->name }}
                                                </span>
                                            </div>
                                            <div
                                                class="text-[11px] text-gray-500 mt-1 font-medium flex items-center gap-1">
                                                <i class="fa-solid fa-sitemap text-gray-300"></i>
                                                {{ $item->position->department ?? 'Tidak ada divisi' }}
                                            </div>
                                        @else
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-medium bg-gray-100 text-gray-500 rounded-md border border-gray-200">
                                                Belum diatur
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $item->email }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $item->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.admins.edit', $item->id) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-4 transition"><i
                                                class="fa-solid fa-pen-to-square"></i> Edit</a>

                                        @if ($item->id !== Auth::id())
                                            <form action="{{ route('admin.admins.destroy', $item->id) }}"
                                                method="POST" class="inline-block form-delete"
                                                data-name="{{ $item->name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition"><i
                                                        class="fa-solid fa-trash"></i> Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($admins->hasPages())
                    <div class="p-4 border-t border-gray-200">
                        {{ $admins->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
