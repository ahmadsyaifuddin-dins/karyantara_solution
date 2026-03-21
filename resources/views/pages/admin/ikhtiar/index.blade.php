<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
            <i class="fa-solid fa-leaf text-amber-500 mr-2"></i> {{ __('Ruang Ikhtiar') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        @include('pages.admin.ikhtiar.partials.hero')
        @include('pages.admin.ikhtiar.partials.quran')
        @include('pages.admin.ikhtiar.partials.reminder')
    </div>
</x-app-layout>