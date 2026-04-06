<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#1E293B] leading-tight flex items-center gap-2">
            <i class="fa-solid fa-network-wired text-amber-500"></i>
            {{ __('Bagan Struktur Organisasi Karyantara Solution') }}
        </h2>
    </x-slot>

    <div class="py-1" x-data="orgChart({{ \Illuminate\Support\Js::from($structure) }})">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 max-w-xl">
                <x-forms.input-search alpineModel="searchQuery" placeholder="Cari jabatan atau personil..." />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                <template x-for="pucuk in filteredStruktur" :key="pucuk.id">
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">

                        <div class="p-6 border-b border-gray-100 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition"
                            @click="toggleNode(pucuk)">
                            <div class="flex items-center gap-4">
                                <div
                                    :class="`w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-md ${pucuk.color_bg || 'bg-slate-800'}`">
                                    <i :class="`${pucuk.icon || 'fa-solid fa-user'} text-xl`"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold tracking-wider text-gray-400 uppercase"
                                        x-text="pucuk.department"></p>
                                    <h3 class="text-lg font-bold text-[#1E293B]" x-text="pucuk.name"></h3>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button @click.stop="showDetail(pucuk, true)"
                                    class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:text-amber-500 transition flex items-center justify-center">
                                    <i class="fa-solid fa-circle-info text-lg"></i>
                                </button>
                                <i class="fa-solid text-gray-400 transition-transform duration-300"
                                    :class="pucuk.isOpen ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            </div>
                        </div>

                        <div x-show="pucuk.isOpen" x-collapse class="p-6 pt-2 bg-gray-50/50">
                            <div
                                class="space-y-4 relative before:absolute before:inset-y-0 before:left-4 before:w-0.5 before:bg-gray-200">
                                <template x-for="child in pucuk.children" :key="child.id">
                                    <div class="relative pl-10 pt-4">
                                        <div class="absolute left-4 top-10 w-6 h-0.5 bg-gray-200"></div>

                                        <div
                                            class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        :class="`w-8 h-8 rounded-lg flex items-center justify-center text-xs ${child.color_bg} ${child.color_text} bg-opacity-10`">
                                                        <i :class="child.icon"></i>
                                                    </div>
                                                    <h4 class="font-bold text-gray-800" x-text="child.name"></h4>
                                                </div>
                                                <button @click="showDetail(child)"
                                                    class="text-xs font-bold text-amber-500 bg-amber-50 px-2 py-1 rounded-md hover:bg-amber-100 transition">
                                                    Detail
                                                </button>
                                            </div>

                                            <div class="mt-3 flex -space-x-2 overflow-hidden"
                                                x-show="child.users && child.users.length > 0">
                                                <template x-for="user in child.users" :key="user.id">
                                                    <div :title="user.name"
                                                        class="inline-block h-6 w-6 rounded-full ring-2 ring-white bg-slate-800 flex items-center justify-center text-[10px] text-white font-bold cursor-help">
                                                        <span x-text="user.name.substring(0,1).toUpperCase()"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>

                                        <div x-show="child.children && child.children.length > 0"
                                            class="relative ml-6 mt-3 border-l-2 border-gray-200 pt-2 pb-2">
                                            <template x-for="grandchild in child.children" :key="grandchild.id">
                                                <div class="relative pl-6 mb-3 last:mb-0">
                                                    <div class="absolute left-0 top-5 w-6 h-0.5 bg-gray-200"></div>

                                                    <div
                                                        class="bg-gray-50 border border-gray-100 rounded-lg p-3 hover:bg-white hover:shadow-sm transition-all">
                                                        <div class="flex justify-between items-center">
                                                            <div class="flex items-center gap-2">
                                                                <i
                                                                    :class="`${grandchild.icon} text-gray-400 text-xs w-4 text-center`"></i>
                                                                <span class="text-sm font-semibold text-gray-700"
                                                                    x-text="grandchild.name"></span>
                                                            </div>
                                                            <button @click="showDetail(grandchild)"
                                                                class="text-[10px] font-bold text-gray-400 hover:text-amber-500 uppercase tracking-wider transition-colors">
                                                                Detail
                                                            </button>
                                                        </div>

                                                        <div class="mt-2 pl-6 flex -space-x-2 overflow-hidden"
                                                            x-show="grandchild.users && grandchild.users.length > 0">
                                                            <template x-for="user in grandchild.users"
                                                                :key="user.id">
                                                                <div :title="user.name"
                                                                    class="inline-block h-5 w-5 rounded-full ring-2 ring-white bg-amber-500 flex items-center justify-center text-[8px] text-[#1E293B] font-bold cursor-help">
                                                                    <span
                                                                        x-text="user.name.substring(0,1).toUpperCase()"></span>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div>

                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>
