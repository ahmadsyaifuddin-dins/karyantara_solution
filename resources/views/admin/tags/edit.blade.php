<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.tags.index') }}" class="text-gray-400 hover:text-amber-500 transition">
                <i class="fa-solid fa-arrow-left text-lg"></i>
            </a>
            <h2 class="font-bold text-xl text-[#1E293B] leading-tight flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                {{ __('Edit Tag Revisi') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST" x-data="{
            bgColor: '{{ old('bg_color', $tag->bg_color) }}',
            textColor: '{{ old('text_color', $tag->text_color) }}',
            presetColors: [
                { name: 'Karyantara Dark', bg: 'bg-[#1E293B]', text: 'text-amber-500' },
                { name: 'Karyantara Amber', bg: 'bg-amber-500', text: 'text-[#1E293B]' },
                { name: 'Merah (Error)', bg: 'bg-red-100', text: 'text-red-700' },
                { name: 'Hijau (Success)', bg: 'bg-emerald-100', text: 'text-emerald-700' },
                { name: 'Biru (Info)', bg: 'bg-blue-100', text: 'text-blue-700' },
                { name: 'Kuning (Warning)', bg: 'bg-amber-100', text: 'text-amber-700' },
                { name: 'Ungu (Naskah)', bg: 'bg-purple-100', text: 'text-purple-700' },
                { name: 'Abu-abu (Netral)', bg: 'bg-slate-100', text: 'text-slate-700' }
            ],
            setColors(bg, text) {
                this.bgColor = bg;
                this.textColor = text;
            }
        }">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <x-forms.label for="name" value="Nama Tag" required />
                <x-forms.input id="name" name="name" value="{{ old('name', $tag->name) }}" required />
                @error('name')
                    <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6 p-4 bg-gray-50 border border-gray-100 rounded-xl">
                <p class="text-[11px] font-bold text-gray-500 mb-3 uppercase tracking-wide">
                    <i class="fa-solid fa-palette mr-1"></i> Pilih Preset Warna Cepat:
                </p>
                <div class="flex flex-wrap gap-2.5">
                    <template x-for="color in presetColors" :key="color.name">
                        <button type="button" @click="setColors(color.bg, color.text)"
                            class="text-xs font-bold px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm transition-all hover:scale-105 hover:shadow-md focus:ring-2 focus:ring-offset-1 focus:ring-amber-500"
                            :class="color.bg + ' ' + color.text" :title="color.name">
                            #<span x-text="color.name"></span>
                        </button>
                    </template>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-8">
                <div>
                    <x-forms.label for="bg_color" value="Class Background Color" required />
                    <x-forms.input id="bg_color" name="bg_color" x-model="bgColor" required />
                    <p class="text-xs text-gray-500 mt-1">Bisa diisi manual (ex: bg-amber-100)</p>
                </div>
                <div>
                    <x-forms.label for="text_color" value="Class Text Color" required />
                    <x-forms.input id="text_color" name="text_color" x-model="textColor" required />
                    <p class="text-xs text-gray-500 mt-1">Bisa diisi manual (ex: text-amber-700)</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.tags.index') }}"
                    class="bg-white border-2 border-gray-200 text-gray-600 hover:border-[#1E293B] hover:text-[#1E293B] px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-sm">
                    Batal
                </a>
                <button type="submit"
                    class="bg-[#1E293B] text-amber-500 hover:bg-slate-800 font-bold py-2.5 px-6 rounded-xl transition shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-check"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
