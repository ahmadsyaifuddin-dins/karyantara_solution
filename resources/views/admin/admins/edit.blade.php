<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
            Edit Akun Admin: {{ $admin->name }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="p-6">
                <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                    @method('PUT')
                    @include('admin.admins._form', ['admin' => $admin])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
