<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1E293B] leading-tight flex items-center gap-2">
            <i class="fa-solid fa-user-shield text-amber-500"></i>
            Manajemen Hak Akses (RBAC - Role Based Access Control)
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div
                    class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm flex items-start gap-3">
                    <i class="fa-solid fa-circle-check text-green-500 mt-0.5"></i>
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm flex items-start gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 mt-0.5"></i>
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            {{-- God Mode Info Box --}}
            <div
                class="bg-[#1E293B] rounded-2xl p-6 shadow-lg mb-8 text-white relative overflow-hidden border border-slate-700">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-amber-500/20 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex flex-col md:flex-row gap-6 items-start md:items-center justify-between">
                    <div class="flex gap-4 items-start md:items-center">
                        <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-crown text-amber-500 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-amber-500 mb-1">Super Admin "God Mode" Aktif</h3>
                            <p class="text-slate-300 text-sm leading-relaxed max-w-2xl">
                                Role <strong>Super Admin</strong> memiliki akses penuh ke seluruh sistem secara otomatis
                                (Bypass).
                                Jika ada penambahan modul/fitur baru di masa depan, klik tombol di samping untuk
                                mendeteksi Izin baru tanpa perlu akses CPanel/Terminal.
                            </p>
                        </div>
                    </div>

                    {{-- Tombol Eksekusi Seeder --}}
                    <form action="{{ route('admin.roles.sync-permissions') }}" method="POST" class="shrink-0">
                        @csrf
                        <button type="button"
                            class="btn-sync-permissions bg-white hover:bg-gray-100 text-[#1E293B] px-5 py-3 rounded-xl text-sm font-bold transition shadow-sm flex items-center gap-2 border-2 border-transparent hover:border-amber-500">
                            <i class="fa-solid fa-rotate text-amber-500"></i> Deteksi Fitur Baru
                        </button>
                    </form>
                </div>
            </div>

            {{-- Form Tambah Role Baru --}}
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-[#1E293B]">Tambah Role Baru</h3>
                    <p class="text-sm text-gray-500">Buat peran khusus (misal: <span
                            class="italic font-semibold">finance, editor, HR</span>)</p>
                </div>

                @error('name')
                    <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                @enderror

                <form action="{{ route('admin.roles.store') }}" method="POST" class="flex gap-3 w-full md:w-auto">
                    @csrf
                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-user-tag text-gray-400"></i>
                        </div>
                        <input type="text" name="name" placeholder="Nama Role..." required
                            class="pl-10 w-full rounded-xl border-gray-200 focus:border-amber-500 focus:ring-amber-500 text-sm transition-shadow">
                    </div>
                    <button type="submit"
                        class="bg-[#1E293B] hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition flex items-center justify-center gap-2 shrink-0">
                        <i class="fa-solid fa-plus"></i> Buat Role
                    </button>
                </form>
            </div>

            {{-- Loop Setiap Role (Selain Super Admin) --}}
            <div class="grid grid-cols-1 gap-8">
                @foreach ($roles as $role)
                    {{-- Wrapper Card (Bukan Form) --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                        {{-- Card Header --}}
                        <div
                            class="bg-gray-50/80 px-6 py-4 border-b border-gray-100 flex justify-between items-center flex-wrap gap-4">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-users-gear text-slate-400 text-xl"></i>
                                <h3 class="text-lg font-bold text-[#1E293B] uppercase tracking-wider">Role:
                                    {{ str_replace('_', ' ', $role->name) }}</h3>
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- Tombol Hapus Terintegrasi SweetAlert --}}
                                @if (!in_array($role->name, ['super_admin', 'admin']))
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                        class="inline-block form-delete"
                                        data-name="{{ str_replace('_', ' ', $role->name) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-bold transition flex items-center gap-2">
                                            <i class="fa-solid fa-trash"></i> <span
                                                class="hidden sm:inline">Hapus</span>
                                        </button>
                                    </form>
                                @endif

                                {{-- Tombol Simpan (Menggunakan atribut form="" untuk menghubungkan dengan form di bawah) --}}
                                <button type="submit" form="form-update-{{ $role->id }}"
                                    class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2 rounded-lg text-sm font-bold transition flex items-center gap-2">
                                    <i class="fa-solid fa-floppy-disk"></i> Simpan Hak Akses
                                </button>
                            </div>
                        </div>

                        {{-- Card Body (Grid Permissions) dijadikan Form Update --}}
                        <form id="form-update-{{ $role->id }}"
                            action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="p-6">
                            @csrf
                            @method('PUT')

                            @php
                                // Kelompokkan permission berdasarkan kata pertamanya untuk UI yang lebih rapi
                                $groupedPermissions = $permissions->groupBy(function ($perm) {
                                    if (str_contains($perm->name, 'view_')) {
                                        return 'Hak Melihat (View)';
                                    }
                                    if (str_contains($perm->name, 'manage_')) {
                                        return 'Hak Mengelola (Manage)';
                                    }
                                    if (str_contains($perm->name, 'use_')) {
                                        return 'Hak Menggunakan Fitur (Use)';
                                    }
                                    return 'Lainnya';
                                });
                            @endphp

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach ($groupedPermissions as $groupName => $perms)
                                    <div class="space-y-4 bg-slate-50 p-5 rounded-xl border border-gray-100">
                                        <h4
                                            class="text-xs font-bold text-gray-500 uppercase tracking-widest border-b border-gray-200 pb-2 mb-4">
                                            <i
                                                class="fa-solid fa-folder-open text-amber-500 mr-2"></i>{{ $groupName }}
                                        </h4>

                                        <div class="space-y-3">
                                            @foreach ($perms as $permission)
                                                <label class="relative flex items-center gap-3 cursor-pointer group">
                                                    <div class="relative">
                                                        <input type="checkbox" name="permissions[]"
                                                            value="{{ $permission->name }}" class="sr-only peer"
                                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>

                                                        {{-- Custom Toggle UI (Tailwind Murni) --}}
                                                        <div
                                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1E293B]">
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="text-sm font-semibold text-gray-700 group-hover:text-[#1E293B] transition">
                                                        {{ str_replace('_', ' ', ucwords($permission->name)) }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </form>

                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
