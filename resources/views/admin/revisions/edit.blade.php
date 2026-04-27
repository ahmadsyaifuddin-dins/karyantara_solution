<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-[#1E293B] leading-tight flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-amber-500"></i> Edit Tiket Revisi
            </h2>
        </div>
    </x-slot>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative">
        <div class="absolute top-6 right-6">
            <form action="{{ route('admin.revisions.destroy', $ticket->id) }}" method="POST" class="form-delete"
                data-name="Tiket: {{ $ticket->title }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md text-sm font-bold transition flex items-center shadow-sm">
                    <i class="fa-solid fa-trash-can mr-1.5"></i> Hapus
                </button>
            </form>
        </div>

        <form action="{{ route('admin.revisions.update', $ticket->id) }}" method="POST" x-data="{ isSubmitting: false }"
            @submit="isSubmitting = true">
            @csrf
            @method('PUT')

            @include('admin.revisions._form', ['ticket' => $ticket])

            <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.revisions.board') }}"
                    class="px-5 py-2.5 bg-white border-2 border-[#1E293B] text-[#1E293B] hover:bg-gray-50 font-semibold rounded-lg focus:outline-none transition-all">Batal</a>

                <button type="submit" :disabled="isSubmitting"
                    class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-[#1E293B] font-bold rounded-lg focus:outline-none shadow-md transition-all disabled:opacity-70 disabled:cursor-not-allowed flex items-center gap-2 min-w-[180px] justify-center">

                    <span x-show="!isSubmitting">Simpan Perubahan</span>

                    <span x-show="isSubmitting" x-cloak>
                        <i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Memperbarui...
                    </span>

                </button>
            </div>
        </form>
    </div>
</x-app-layout>
