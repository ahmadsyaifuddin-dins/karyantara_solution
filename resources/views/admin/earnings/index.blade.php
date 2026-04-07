<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-[#1E293B] leading-tight">
                    <i class="fa-solid fa-sack-dollar text-emerald-500 mr-2"></i> Dompet & Pendapatan Saya
                </h2>
                <p class="text-sm text-gray-500 mt-1">Rincian proyek dan bagi hasil yang dialokasikan untuk Anda.</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.earnings.export.pdf', request()->all()) }}" target="_blank"
                    class="bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition inline-flex items-center">
                    <i class="fa-solid fa-file-pdf mr-2"></i> Export PDF
                </a>
                <a href="{{ route('admin.earnings.export.excel', request()->all()) }}"
                    class="bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition inline-flex items-center">
                    <i class="fa-solid fa-file-excel mr-2"></i> Export Excel
                </a>
            </div>
        </div>

        @include('admin.earnings.partials.filter')
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                    <p class="text-sm text-green-700 font-medium"><i
                            class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
                </div>
            @endif

            @include('admin.earnings.partials.wallet-cards')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @include('admin.earnings.partials.history-programmer')
                @include('admin.earnings.partials.history-writer')
            </div>

        </div>
    </div>
</x-app-layout>
