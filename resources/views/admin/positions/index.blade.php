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

            {{-- Flash Messages --}}
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

            {{-- Filter & Search Bar Section --}}
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
                <form action="{{ route('admin.positions.index') }}" method="GET"
                    class="flex flex-col md:flex-row gap-4 items-end">

                    <div class="flex-1 w-full">
                        <label for="search"
                            class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Cari
                            Jabatan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Cari nama jabatan..."
                                class="pl-10 w-full rounded-xl border-gray-200 focus:border-amber-500 focus:ring-amber-500 text-sm transition-shadow">
                        </div>
                    </div>

                    <div class="w-full md:w-64">
                        <label for="department"
                            class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Filter
                            Divisi</label>
                        <select name="department" id="department"
                            class="w-full rounded-xl border-gray-200 focus:border-amber-500 focus:ring-amber-500 text-sm transition-shadow text-gray-700">
                            <option value="">Semua Divisi</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept }}"
                                    {{ request('department') == $dept ? 'selected' : '' }}>
                                    {{ $dept }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit"
                            class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-colors w-full md:w-auto flex items-center justify-center gap-2">
                            <i class="fa-solid fa-filter"></i> Filter
                        </button>

                        @if (request('search') || request('department'))
                            <a href="{{ route('admin.positions.index') }}"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-xl font-semibold text-sm transition-colors w-full md:w-auto flex items-center justify-center gap-2">
                                <i class="fa-solid fa-rotate-right"></i> Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Table Container --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                @include('admin.positions.partials.table')
            </div>

        </div>
    </div>
</x-app-layout>
