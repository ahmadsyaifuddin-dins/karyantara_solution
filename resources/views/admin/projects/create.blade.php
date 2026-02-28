<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Klien / Proyek Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="p-8 bg-white">
                    <form action="{{ route('admin.projects.store') }}" method="POST">
                        @csrf
                        @include('admin.projects._form', ['project' => new \App\Models\Project()])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
