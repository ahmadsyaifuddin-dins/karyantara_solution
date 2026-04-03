<div class="mt-10 border-t border-gray-200 pt-6" x-data="{
    // Ambil data yang sudah tercentang (dari old input atau database)
    selected: {{ json_encode(old('attendee_emails', $meeting->attendee_emails ?? [])) }},
    // Ambil semua email dari koleksi $users
    all: {{ json_encode(isset($users) ? $users->pluck('email') : []) }},

    // Fungsi untuk Toggle Centang Semua
    toggleAll() {
        if (this.selected.length === this.all.length) {
            this.selected = []; // Kosongkan jika sudah terpilih semua
        } else {
            this.selected = [...this.all]; // Pilih semua
        }
    }
}">

    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-4 gap-4">
        <div>
            <h3 class="text-lg font-bold text-[#1E293B]">Peserta Rapat (Undangan Email)</h3>
            <p class="text-xs text-gray-500 mt-1">Centang nama pengguna di bawah ini untuk mengirimkan file undangan
                (.ics) ke email mereka.</p>
        </div>

        <button type="button" @click="toggleAll()"
            class="shrink-0 px-3 py-1.5 text-sm font-medium bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">

            <i class="fa-solid"
                :class="selected.length === all.length ? 'fa-square-check text-amber-500' : 'fa-square text-gray-300'"></i>

            <span x-text="selected.length === all.length ? 'Batalkan Semua' : 'Pilih Semua'"></span>

        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @if (isset($users) && count($users) > 0)
            @foreach ($users as $user)
                <label
                    class="relative flex items-start p-4 border border-gray-200 rounded-xl cursor-pointer transition-all duration-200 hover:bg-slate-50 has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50 has-[:checked]:ring-1 has-[:checked]:ring-amber-500 shadow-sm">

                    <div class="flex-shrink-0 mt-0.5">
                        <input type="checkbox" name="attendee_emails[]" value="{{ $user->email }}" x-model="selected"
                            class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-amber-500 transition-colors">
                    </div>

                    <div class="ml-3 flex flex-col">
                        <span class="block text-sm font-bold text-[#1E293B] leading-tight">{{ $user->name }}</span>
                        <span class="block text-[11px] font-medium text-gray-500 mt-0.5 mb-1.5">
                            <i class="fa-regular fa-envelope mr-1"></i> {{ $user->email }}
                        </span>

                        @if ($user->position)
                            <div>
                                <span
                                    class="px-2 py-0.5 text-[10px] font-bold rounded-full border 
                                    {{ $user->department === 'Board of Directors' ? 'bg-purple-50 text-purple-700 border-purple-200' : 'bg-blue-50 text-blue-700 border-blue-200' }}">
                                    {{ $user->position }}
                                </span>
                            </div>
                        @endif
                    </div>

                </label>
            @endforeach
        @else
            <div
                class="col-span-full p-4 bg-gray-50 rounded-lg text-center text-sm text-gray-500 border border-dashed border-gray-300">
                Belum ada pengguna lain yang terdaftar di sistem.
            </div>
        @endif
    </div>
</div>
