<div x-show="showReferenceModal" style="display: none;" class="relative z-[60]" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">

    <div x-show="showReferenceModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" @click="showReferenceModal = false">
    </div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 pt-20 sm:p-8 sm:pt-28 text-center">

            <div x-show="showReferenceModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform flex flex-col rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-4xl max-h-[85vh] overflow-hidden">

                <div class="bg-[#1E293B] px-4 md:px-6 py-4 flex justify-between items-center shrink-0">
                    <h3 class="text-base md:text-lg font-bold text-white flex items-center" id="modal-title">
                        <i class="fa-solid fa-lightbulb text-amber-500 mr-2"></i> Referensi Pengisian
                    </h3>
                    <button @click="showReferenceModal = false"
                        class="text-gray-400 hover:text-white transition focus:outline-none">
                        <i class="fa-solid fa-xmark text-xl md:text-2xl"></i>
                    </button>
                </div>

                <div class="px-4 md:px-6 py-6 bg-white overflow-y-auto flex-1">
                    <p class="text-sm text-gray-600 mb-5 text-center md:text-left">
                        Anda bebas mengisi kolom <span class="font-bold text-[#1E293B]">"Jabatan / Instansi"</span>
                        dengan
                        identitas yang paling mewakili Anda. Berikut adalah beberapa contohnya:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h4 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-2"><i
                                    class="fa-solid fa-building mr-1"></i> Perusahaan / Bisnis</h4>
                            <ul class="text-sm text-gray-700 space-y-1.5 list-disc list-inside ml-1 font-medium">
                                <li>CEO PT. Maju Jaya Bersama</li>
                                <li>Owner "Kopi Senja"</li>
                                <li>Manager Marketing Toko Makmur</li>
                            </ul>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h4 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-2"><i
                                    class="fa-solid fa-graduation-cap mr-1"></i> Pendidikan / Akademik</h4>
                            <ul class="text-sm text-gray-700 space-y-1.5 list-disc list-inside ml-1 font-medium">
                                <li>Mahasiswa Uniska FTI Banjarmasin</li>
                                <li>Mahasiswa Teknik Informatika Semester 8</li>
                                <li>Mahasiswa TI Reguler Malam</li>
                                <li>Dosen Teknik Informatika</li>
                                <li>Guru SMAN 1 Jakarta</li>
                            </ul>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h4 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-2"><i
                                    class="fa-solid fa-landmark mr-1"></i> Pemerintahan / Organisasi</h4>
                            <ul class="text-sm text-gray-700 space-y-1.5 list-disc list-inside ml-1 font-medium">
                                <li>Kepala Desa Suka Makmur</li>
                                <li>Ketua Karang Taruna RW 05</li>
                                <li>Staf Dinas Kesehatan Daerah</li>
                            </ul>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h4 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-2"><i
                                    class="fa-solid fa-laptop-code mr-1"></i> Pekerja Bebas / Personal</h4>
                            <ul class="text-sm text-gray-700 space-y-1.5 list-disc list-inside ml-1 font-medium">
                                <li>Freelance Graphic Designer</li>
                                <li>Content Creator</li>
                                <li>Wirausaha / Personal</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 md:px-6 py-4 border-t border-gray-200 text-right shrink-0">
                    <button type="button" @click="showReferenceModal = false"
                        class="inline-flex w-full justify-center rounded-xl bg-[#1E293B] px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-gray-800 transition focus:ring-2 focus:ring-amber-500 sm:w-auto">
                        Tutup & Lanjut Mengisi
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
