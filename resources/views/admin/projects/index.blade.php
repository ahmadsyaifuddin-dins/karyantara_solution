<x-app-layout>
    <x-slot name="header">
        @include('admin.projects.partials.index.header')
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">

            @include('admin.projects.partials.index.disclaimer')

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                    <p class="text-sm text-green-700 font-medium"><i
                            class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
                </div>
            @endif

            @include('admin.projects.partials.index.statistics')

            @include('admin.projects.partials.index.table')

        </div>
    </div>
</x-app-layout>
