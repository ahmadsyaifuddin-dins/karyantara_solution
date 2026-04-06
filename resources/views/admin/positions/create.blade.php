<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.positions.index') }}" class="text-gray-400 hover:text-amber-500 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
                Tambah Jabatan Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-8">

                <form action="{{ route('admin.positions.store') }}" method="POST">
                    @include('admin.positions._form')
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
