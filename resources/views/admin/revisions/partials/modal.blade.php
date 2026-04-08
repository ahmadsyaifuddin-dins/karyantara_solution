<div x-cloak x-show="ticketModalOpen"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <div @click.away="ticketModalOpen = false"
        class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

        <div class="bg-[#1E293B] px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-ticket text-amber-500"></i> Detail Tiket #<span x-text="activeTicket.id"></span>
            </h3>
            <button @click="ticketModalOpen = false" class="text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                    <p class="text-xs text-slate-500 font-semibold uppercase">Proyek / Klien</p>
                    <p class="font-bold text-[#1E293B]" x-text="activeTicket.project?.client_name || '-'"></p>
                </div>
                <div class="bg-amber-50 p-3 rounded-lg border border-amber-100">
                    <p class="text-xs text-amber-700 font-semibold uppercase">Tipe Revisi</p>
                    <p class="font-bold text-amber-600 uppercase" x-text="activeTicket.type"></p>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-sm font-bold text-[#1E293B] mb-1">Judul Revisi (Fase)</h4>
                <p class="text-gray-700 text-lg" x-text="activeTicket.title"></p>
            </div>

            <div class="mb-6">
                <h4 class="text-sm font-bold text-[#1E293B] mb-2">Deskripsi Revisi</h4>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-sm text-gray-700 whitespace-pre-line"
                    x-text="activeTicket.description || 'Tidak ada deskripsi rinci.'">
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4 mt-auto">
                <div class="flex justify-between items-end mb-2">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Jatah Revisi Klien</p>
                        <p class="text-sm">
                            Terpakai <span class="font-bold text-red-600"
                                x-text="activeTicket.project?.used_revision"></span> dari
                            <span class="font-bold text-emerald-600" x-text="activeTicket.project?.max_revision"></span>
                        </p>
                    </div>

                    @can('add_extra_quota_revisian')
                        <template x-if="activeTicket.project?.max_revision < 7">
                            <form :action="'/admin/projects/' + activeTicket.project?.id + '/add-revision-quota'"
                                method="POST"
                                @submit.prevent="
                  window.Swal.fire({
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
                                    class="text-xs text-amber-600 font-bold hover:text-amber-700 bg-amber-50 hover:bg-amber-100 px-2 py-1 rounded transition shadow-sm">
                                    <i class="fa-solid fa-plus mr-1"></i> Ekstra Kuota
                                </button>
                            </form>
                        </template>
                    @endcan
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                    <div class="bg-amber-500 h-2.5 rounded-full transition-all"
                        :style="'width: ' + Math.min(((activeTicket.project?.used_revision / activeTicket.project
                            ?.max_revision) * 100), 100) + '%'">
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <a :href="'/admin/revisions/' + activeTicket.id + '/edit'"
                        class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-[#1E293B] px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Tiket Ini
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
