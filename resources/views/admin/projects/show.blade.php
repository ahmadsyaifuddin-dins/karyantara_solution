<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight flex items-center">
                <i class="fa-solid fa-file-lines text-amber-500 mr-3"></i>
                {{ __('Detail Proyek / Klien') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.projects.invoice', $project->id) }}" target="_blank"
                    class="bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition flex items-center">
                    <i class="fa-solid fa-print mr-2"></i> Cetak Invoice / MoU
                </a>

                <a href="{{ route('admin.projects.edit', $project->id) }}"
                    class="bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition flex items-center">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Data
                </a>
                <a href="{{ route('admin.projects.index') }}"
                    class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition text-sm font-bold shadow-sm flex items-center">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @include('admin.projects.partials.show.header-card')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                @include('admin.projects.partials.show.finance-card')

                @include('admin.projects.partials.show.scope-card')

            </div>

        </div>
    </div>
</x-app-layout>
