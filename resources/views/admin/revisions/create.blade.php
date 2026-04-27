<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#1E293B] leading-tight flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-amber-500"></i> Buat Tiket Revisi Baru
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('admin.revisions.store') }}" method="POST" x-data="{ isSubmitting: false }"
            @submit="isSubmitting = true">
            @csrf

            @include('admin.revisions._form', ['ticket' => new \App\Models\RevisionTicket()])

            <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.revisions.board') }}"
                    class="px-5 py-2.5 bg-white border-2 border-[#1E293B] text-[#1E293B] hover:bg-gray-50 font-semibold rounded-lg focus:outline-none transition-all">Batal</a>

                <button type="submit" :disabled="isSubmitting"
                    class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-[#1E293B] font-bold rounded-lg focus:outline-none shadow-md transition-all disabled:opacity-70 disabled:cursor-not-allowed flex items-center gap-2 min-w-[180px] justify-center">

                    <span x-show="!isSubmitting">Simpan ke Antrean</span>

                    <span x-show="isSubmitting" x-cloak>
                        <i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Menyimpan...
                    </span>

                </button>
            </div>
        </form>
    </div>
</x-app-layout>
