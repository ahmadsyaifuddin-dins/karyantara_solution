<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
            <i class="fa-solid fa-cogs mr-2"></i> {{ __('Pengaturan Sistem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-[#1E293B] mb-6 border-b pb-3">
                    <i class="fa-solid fa-cloud mr-2 text-amber-500"></i> Integrasi & Otomatisasi
                </h3>

                <div class="space-y-4">

                    <x-setting-item :setting="$settings['auto_sync_sheet'] ?? null" title="Auto-Sync Google Spreadsheet">
                        <x-slot:description>
                            Jika diaktifkan, data klien & proyek (publik) akan langsung dikirim ke Google Sheet secara
                            otomatis setiap kali Anda menekan tombol Simpan.
                            <br><span class="text-amber-600 font-semibold"><i
                                    class="fa-solid fa-circle-info mt-2 mr-1"></i> Catatan:</span> Membutuhkan waktu
                            loading 2-3 detik saat menyimpan data. Jika dimatikan, Anda wajib menggunakan tombol "Sync
                            Spreadsheet" di halaman proyek untuk mem-backup data.

                            <div class="mt-3">
                                <a href="https://docs.google.com/spreadsheets/d/1HFmSp8B6V03saKbhjLotI3OSfemU2eoxfftdAdTpUYQ/edit?usp=sharing"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold text-xs rounded-lg border border-emerald-200 transition-colors shadow-sm">
                                    <i class="fa-solid fa-file-excel text-emerald-600 text-sm"></i>
                                    Buka File Spreadsheet
                                    <i class="fa-solid fa-arrow-up-right-from-square ml-1 text-[10px]"></i>
                                </a>
                            </div>
                        </x-slot:description>
                    </x-setting-item>

                    <x-setting-item :setting="$settings['auto_approve_testimonial'] ?? null" title="Auto-Approve Testimonial"
                        description="Jika diaktifkan, testimoni baru dari klien akan langsung tampil di website tanpa perlu persetujuan (ACC) manual dari Admin." />

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
