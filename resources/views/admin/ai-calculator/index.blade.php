<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-[#1E293B] leading-tight flex items-center gap-2">
                    <i class="fa-solid fa-robot text-amber-500"></i>
                    Kalkulator AI Karyantara Solution
                </h2>
                <p class="text-sm text-gray-500 mt-1">Asisten pintar untuk analisis <b>cashflow</b> pribadi dan rencana
                    belanja <b>gear</b> IT.</p>
            </div>
        </div>
    </x-slot>

    <div x-data="aiCalculator()" class="space-y-6">

        @include('admin.ai-calculator.partials.cards')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            @include('admin.ai-calculator.partials.form')

            @include('admin.ai-calculator.partials.result')

        </div>
    </div>

    @include('admin.ai-calculator.partials.script')

</x-app-layout>
