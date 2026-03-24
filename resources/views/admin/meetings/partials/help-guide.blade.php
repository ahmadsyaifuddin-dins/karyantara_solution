<div x-data="{ showGuide: false }" class="mb-6">
    <button type="button" @click="showGuide = !showGuide"
        class="flex items-center justify-between w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1">
        <div class="flex items-center gap-2 text-[#1E293B] font-semibold">
            <i class="fa-solid fa-circle-info text-amber-500 text-lg"></i>
            <span>Panduan Istilah & Pengisian Form Agenda</span>
        </div>
        <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300"
            :class="showGuide ? 'rotate-180' : ''"></i>
    </button>

    <div x-show="showGuide" x-collapse class="mt-2 bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden"
        x-cloak>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">

            <div>
                <h4 class="font-bold text-[#1E293B] mb-3 flex items-center gap-2 border-b border-gray-100 pb-2">
                    <i class="fa-solid fa-briefcase text-amber-500"></i> Jenis Rapat (Meeting Type)
                </h4>
                <ul class="space-y-3">
                    <li>
                        <span class="font-semibold text-[#1E293B] bg-slate-100 px-1.5 py-0.5 rounded">Internal
                            Board</span>
                        <p class="text-xs mt-1 text-gray-500">Rapat strategis antar manajemen/petinggi (CEO, CTO) untuk
                            membahas arah bisnis, finansial, atau kebijakan Karyantara Solution.</p>
                    </li>
                    <li>
                        <span class="font-semibold text-[#1E293B] bg-slate-100 px-1.5 py-0.5 rounded">Client
                            Meeting</span>
                        <p class="text-xs mt-1 text-gray-500">Pertemuan dengan klien untuk presentasi, *pitching* proyek
                            baru, atau diskusi kebutuhan *software* klien.</p>
                    </li>
                    <li>
                        <span class="font-semibold text-[#1E293B] bg-slate-100 px-1.5 py-0.5 rounded">Project
                            Sync</span>
                        <p class="text-xs mt-1 text-gray-500">Rapat sinkronisasi rutin (harian/mingguan) bersama tim
                            untuk membahas progres pengerjaan proyek dan kendala teknis.</p>
                    </li>
                    <li>
                        <span class="font-semibold text-[#1E293B] bg-slate-100 px-1.5 py-0.5 rounded">Evaluation</span>
                        <p class="text-xs mt-1 text-gray-500">Rapat evaluasi (*retrospective*) setelah proyek selesai.
                            Membahas apa yang sudah baik dan apa yang perlu ditingkatkan ke depannya.</p>
                    </li>
                </ul>
            </div>

            <div class="space-y-6">
                <div>
                    <h4 class="font-bold text-[#1E293B] mb-3 flex items-center gap-2 border-b border-gray-100 pb-2">
                        <i class="fa-solid fa-bars-progress text-amber-500"></i> Status Pelaksanaan
                    </h4>
                    <ul class="space-y-2">
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 mt-0.5"><i class="fa-regular fa-calendar-check"></i></span>
                            <div><span class="font-semibold text-[#1E293B]">Scheduled:</span> <span
                                    class="text-xs text-gray-500">Rapat sudah dijadwalkan, tapi belum waktunya
                                    dimulai.</span></div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-amber-500 mt-0.5"><i class="fa-solid fa-spinner fa-spin-pulse"></i></span>
                            <div><span class="font-semibold text-[#1E293B]">Ongoing:</span> <span
                                    class="text-xs text-gray-500">Rapat sedang berlangsung saat ini.</span></div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-600 mt-0.5"><i class="fa-solid fa-check-double"></i></span>
                            <div><span class="font-semibold text-[#1E293B]">Completed:</span> <span
                                    class="text-xs text-gray-500">Rapat selesai. (Pastikan Notulensi sudah diisi jika
                                    memilih status ini).</span></div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 mt-0.5"><i class="fa-solid fa-ban"></i></span>
                            <div><span class="font-semibold text-[#1E293B]">Canceled:</span> <span
                                    class="text-xs text-gray-500">Rapat dibatalkan.</span></div>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-[#1E293B] mb-3 flex items-center gap-2 border-b border-gray-100 pb-2">
                        <i class="fa-solid fa-spell-check text-amber-500"></i> Istilah Lainnya
                    </h4>
                    <ul class="space-y-3">
                        <li>
                            <span class="font-semibold text-[#1E293B]">Minutes of Meeting (MoM)</span>
                            <p class="text-xs mt-1 text-gray-500">Atau <b> Notulensi </b>. Merupakan catatan tertulis
                                berisi
                                poin-poin penting, ide, dan kesimpulan dari hasil rapat yang telah disepakati.</p>
                        </li>
                        <li>
                            <span class="font-semibold text-[#1E293B]">Action Items (Tindak Lanjut)</span>
                            <p class="text-xs mt-1 text-gray-500">Daftar <b> tugas nyata</b> yang harus dieksekusi
                                setelah
                                rapat selesai. Mencakup apa tugasnya, siapa <b>PIC</b> (Penanggung Jawab/Orang
                                yang
                                mengerjakan), dan kapan <b>Tenggat Waktu</b> (Deadline) tugas tersebut.
                            </p>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
