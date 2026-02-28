<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
            <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Data Klien: {{ $project->client_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="p-8 bg-white">
                    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.projects._form', ['project' => $project])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
