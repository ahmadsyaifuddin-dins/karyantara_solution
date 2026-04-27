<div x-cloak x-show="ticketModalOpen"
    class="fixed inset-0 z-50 flex items-center justify-center bg-[#1E293B]/60 backdrop-blur-sm p-4 sm:p-0"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <div @click.away="!document.body.classList.contains('swal2-shown') ? ticketModalOpen = false : null"
        class="bg-slate-50/95 rounded-2xl shadow-2xl w-full max-w-3xl overflow-hidden transform transition-all flex flex-col max-h-[90vh]"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

        <div class="bg-[#1E293B] px-6 py-4 flex justify-between items-center shrink-0">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-ticket text-amber-500"></i> Detail Tiket <span class="text-amber-500">#<span
                        x-text="activeTicket.id"></span></span>
            </h3>
            <button @click="ticketModalOpen = false"
                class="text-slate-400 hover:text-white bg-slate-800/50 hover:bg-slate-700 w-8 h-8 rounded-full flex items-center justify-center transition-all">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar flex-grow">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-center">
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-1">Proyek / Klien</p>
                    <p class="font-extrabold text-[#1E293B] text-base truncate"
                        x-text="activeTicket.project?.client_name || '-'"></p>
                </div>
                <div
                    class="bg-gradient-to-br from-amber-50 to-white p-4 rounded-xl border border-amber-100 shadow-sm flex flex-col justify-center">
                    <p class="text-[11px] text-amber-600/70 font-bold uppercase tracking-wider mb-1">Tipe Revisi</p>
                    <p class="font-extrabold text-amber-600 uppercase text-base flex items-center gap-2">
                        <i class="fa-solid fa-layer-group text-sm"></i> <span x-text="activeTicket.type"></span>
                    </p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm mb-6">
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-1.5">Judul Revisi (Fase)</p>
                <h4 class="text-xl font-bold text-[#1E293B] mb-4 leading-snug" x-text="activeTicket.title"></h4>

                <template x-if="activeTicket.tags && activeTicket.tags.length > 0">
                    <div class="flex flex-wrap gap-2 pt-3 border-t border-slate-50">
                        <template x-for="tag in activeTicket.tags" :key="tag.id">
                            <span
                                class="text-[11px] font-bold px-3 py-1.5 rounded-lg shadow-sm border border-gray-100 transition-transform hover:-translate-y-0.5"
                                :class="tag.bg_color + ' ' + tag.text_color">
                                #<span x-text="tag.name"></span>
                            </span>
                        </template>
                    </div>
                </template>
            </div>

            <div class="mb-6">
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-2 ml-1">Deskripsi Revisi</p>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-inner text-sm text-slate-700 whitespace-pre-line leading-relaxed min-h-[120px]"
                    x-text="activeTicket.description || 'Tidak ada deskripsi rinci.'">
                </div>
            </div>

        </div>

        <div class="bg-white border-t border-slate-200 px-6 py-5 shrink-0">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

                <div class="w-full sm:w-1/2">
                    <div class="flex justify-between items-end mb-1.5">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jatah Revisi Klien</p>
                        <p class="text-xs font-bold">
                            <span class="text-red-500" x-text="activeTicket.project?.used_revision"></span>
                            <span class="text-slate-400 mx-0.5">/</span>
                            <span class="text-emerald-500" x-text="activeTicket.project?.max_revision"></span>
                        </p>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 shadow-inner overflow-hidden flex">
                        <div class="bg-gradient-to-r from-amber-400 to-amber-500 h-full rounded-full transition-all duration-500 relative"
                            :style="'width: ' + Math.min(((activeTicket.project?.used_revision / activeTicket.project
                                ?.max_revision) * 100), 100) + '%'">
                            <div class="absolute top-0 left-0 w-full h-1/2 bg-white/20 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                    @can('add_extra_quota_revisian')
                        <template x-if="activeTicket.project?.max_revision < 7">
                            <form :action="'/admin/projects/' + activeTicket.project?.id + '/add-revision-quota'"
                                method="POST"
                                @submit.prevent="window.Swal.fire({
                      title: 'Tambah Ekstra Kuota?',
                      text: 'Yakin ingin menambah jatah ekstra revisi untuk klien ini? (Maksimal 7x)',
                      iconHtml: '<i class=\'fa-solid fa-plus-circle text-amber-500 text-4xl\'></i>',
                      customClass: {
                          popup: 'rounded-2xl shadow-xl border border-gray-100 bg-white p-6',
                          icon: 'border-0 bg-amber-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-5',
                          title: 'text-[#1E293B] font-bold text-xl md:text-2xl mt-2',
                          htmlContainer: 'text-gray-500 text-sm mt-2 mb-6',
                          actions: 'flex gap-3 w-full justify-center',
                          confirmButton: 'bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 px-6 rounded-lg transition-all',
                          cancelButton: 'bg-white border-2 border-[#1E293B] text-[#1E293B] hover:bg-gray-50 font-semibold py-2.5 px-6 rounded-lg transition-all'
                      },
                      buttonsStyling: false,
                      showCancelButton: true,
                      confirmButtonText: 'Ya, Tambah',
                      cancelButtonText: 'Batal',
                      reverseButtons: true
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $el.submit();
                      }
                  })
              ">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="h-10 px-3 flex items-center justify-center text-xs text-amber-600 font-bold hover:text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors border border-amber-200/50">
                                    <i class="fa-solid fa-plus mr-1.5"></i> Kuota
                                </button>
                            </form>
                        </template>
                    @endcan

                    <a :href="'/admin/revisions/' + activeTicket.id + '/edit'"
                        class="h-10 px-5 flex items-center justify-center gap-2 bg-[#1E293B] hover:bg-slate-800 text-amber-500 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all focus:ring-2 focus:ring-offset-2 focus:ring-[#1E293B]">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Tiket
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
