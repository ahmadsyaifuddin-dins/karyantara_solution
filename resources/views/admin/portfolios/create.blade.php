<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">Tambah Portofolio</h2>
    </x-slot>
    <div class="max-w-4xl mx-auto py-8">
        <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-100">
            <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data">
                @include('admin.portfolios._form')
            </form>
        </div>
    </div>
</x-app-layout>
