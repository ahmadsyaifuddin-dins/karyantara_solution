<x-app-layout>
    <x-slot name="header">
        <style>
            @keyframes wave {
                0% {
                    transform: rotate(0.0deg)
                }

                10% {
                    transform: rotate(15.0deg)
                }

                20% {
                    transform: rotate(-10.0deg)
                }

                30% {
                    transform: rotate(15.0deg)
                }

                40% {
                    transform: rotate(-10.0deg)
                }

                50% {
                    transform: rotate(10.0deg)
                }

                60% {
                    transform: rotate(0.0deg)
                }

                100% {
                    transform: rotate(0.0deg)
                }
            }

            .animate-wave {
                display: inline-block;
                animation: wave 2.5s ease-in-out infinite;
                transform-origin: 70% 90%;
                /* Poros putaran digeser ke bawah agar pas dengan base icon tangan */
            }
        </style>

        <h2 class="font-bold text-2xl text-[#1E293B] leading-tight flex items-center">
            Selamat Datang, {{ Auth::user()->name }}!
            <i class="fa-solid fa-hand text-amber-400 animate-wave ml-3 text-[1.4rem] drop-shadow-sm cursor-default"></i>
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
