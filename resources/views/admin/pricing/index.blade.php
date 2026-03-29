<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#1E293B] leading-tight flex items-center gap-2">
            <i class="fa-solid fa-calculator text-amber-500"></i>
            {{ __('Kalkulator Estimasi Harga Karyantara') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="pricingCalculator('{{ route('admin.pricing-calculator.pdf') }}')">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    @include('admin.pricing.partials.form')
                </div>

                <div
                    class="bg-[#1E293B] rounded-2xl shadow-xl border border-gray-800 p-6 flex flex-col h-fit sticky top-24 relative overflow-hidden">
                    @include('admin.pricing.partials.summary')
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
