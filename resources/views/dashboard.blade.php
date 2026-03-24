<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#1E293B] leading-tight">
            Selamat Datang, {{ Auth::user()->name }}! 👋
        </h2>
        <p class="text-sm text-gray-500 mt-1">Berikut adalah ringkasan performa Karyantara Solution dan pendapatan
            pribadimu.</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @include('admin.dashboard.partials.metrics')

            @include('admin.dashboard.partials.revenue-chart')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div
                    class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                    @include('admin.dashboard.partials.recent-projects')
                </div>

                <div
                    class="lg:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                    @include('admin.dashboard.partials.admin-activities')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
