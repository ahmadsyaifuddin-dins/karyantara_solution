<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#1E293B] leading-tight flex items-center gap-2">
            <i class="fa-solid fa-tags text-amber-500"></i>
            {{ __('Master Data Tag Revisi') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-lg text-[#1E293B] mb-4 border-b border-gray-100 pb-3">Tambah Tag Baru</h3>

                <form action="{{ route('admin.tags.store') }}" method="POST" x-data="{
                    bgColor: 'bg-[#1E293B]',
                    textColor: 'text-amber-500',
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
                    <div class="mb-4">
                        <x-forms.label for="name" value="Nama Tag" required />
                        <x-forms.input id="name" name="name" placeholder="Misal: UI/UX, Logic Error..."
                            required />
                        @error('name')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4 p-3 bg-gray-50 border border-gray-100 rounded-xl">
                        <p class="text-[11px] font-bold text-gray-500 mb-2 uppercase tracking-wide">
                            <i class="fa-solid fa-palette mr-1"></i> Pilih Preset Warna Cepat:
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="color in presetColors" :key="color.name">
                                <button type="button" @click="setColors(color.bg, color.text)"
                                    class="text-[10px] font-bold px-2 py-1.5 rounded-md border border-gray-200 shadow-sm transition-all hover:scale-105 hover:shadow-md focus:ring-2 focus:ring-offset-1 focus:ring-amber-500"
                                    :class="color.bg + ' ' + color.text" :title="color.name">
                                    #<span x-text="color.name"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <x-forms.label for="bg_color" value="Class BG Color" required />
                            <x-forms.input id="bg_color" name="bg_color" x-model="bgColor" required />
                            <p class="text-[10px] text-gray-500 mt-1">Bisa diisi manual (ex: bg-red-100)</p>
                        </div>
                        <div>
                            <x-forms.label for="text_color" value="Class Text Color" required />
                            <x-forms.input id="text_color" name="text_color" x-model="textColor" required />
                            <p class="text-[10px] text-gray-500 mt-1">Bisa diisi manual (ex: text-red-700)</p>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#1E293B] text-amber-500 hover:bg-slate-800 font-bold py-2.5 px-4 rounded-xl transition shadow-sm">
                        <i class="fa-solid fa-save mr-1"></i> Simpan Tag
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-[#1E293B]">Daftar Tag</h3>
                    <span
                        class="bg-[#1E293B] text-amber-500 text-xs font-bold px-3 py-1 rounded-full">{{ $tags->count() }}
                        Tag</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nama Tag</th>
                                <th class="px-6 py-4 font-bold text-center">Preview Badge</th>
                                <th class="px-6 py-4 font-bold text-center">Digunakan</th>
                                <th class="px-6 py-4 font-bold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($tags as $tag)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-semibold text-[#1E293B]">{{ $tag->name }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="text-xs font-bold px-2.5 py-1 rounded-md shadow-sm border border-gray-100 {{ $tag->bg_color }} {{ $tag->text_color }}">
                                            #{{ $tag->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium text-gray-600">
                                        {{ $tag->revisionTickets()->count() }} Tiket
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.tags.edit', $tag->id) }}"
                                                class="text-amber-500 hover:text-amber-600 bg-amber-50 hover:bg-amber-100 p-2 rounded-lg transition">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST"
                                                class="inline form-delete" data-name="{{ $tag->name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-500 hover:text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data tag.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
