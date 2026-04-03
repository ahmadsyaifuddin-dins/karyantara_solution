<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
            {{ __('Jadwalkan Rapat Baru') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.meetings.store') }}" method="POST" class="p-6" enctype="multipart/form-data">
            @csrf

            @include('admin.meetings.partials.form')

            <div class="mt-8 flex justify-end items-center gap-3">
                <a href="{{ route('admin.meetings.index') }}"
                    class="px-5 py-2.5 bg-white border-2 border-[#1E293B] text-[#1E293B] hover:bg-gray-50 font-semibold rounded-lg transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg shadow-sm transition-all focus:ring-2 focus:ring-amber-400">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Agenda
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
