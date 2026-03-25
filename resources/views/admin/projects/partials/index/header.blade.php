<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

    <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
        <i class="fa-solid fa-file-invoice-dollar mr-2"></i> {{ __('Daftar Klien & Proyek') }}
    </h2>
    <div class="flex flex-wrap gap-2">

        <div x-data="{
            copyLink() {
                navigator.clipboard.writeText('{{ route('rules.mahasiswa') }}');
        
                // Panggil SweetAlert yang sudah kita import di alpine-components.js
                window.Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Link Panduan berhasil disalin!',
                    showConfirmButton: false,
                    timer: 2000,
                    customClass: {
                        popup: 'border border-emerald-100 shadow-xl rounded-xl'
                    }
                });
            }
        }">
            <button @click="copyLink()" type="button"
                class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-amber-400">
                <i class="fa-solid fa-link mr-2"></i> Copy Link Panduan MoU
            </button>
        </div>

        <div x-data="googleSheetSync('{{ route('admin.projects.sync-sheet') }}')" class="inline-block">
            <button @click="syncData" type="button"
                class="bg-amber-50 text-amber-600 border border-amber-200 hover:bg-amber-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition inline-flex items-center focus:outline-none focus:ring-2 focus:ring-amber-500">
                <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Sync Spreadsheet
            </button>
        </div>

        <a href="{{ route('admin.projects.priority') }}"
            class="bg-indigo-50 text-indigo-600 border border-indigo-200 hover:bg-indigo-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition inline-flex items-center">
            <i class="fa-solid fa-list-check mr-1"></i> Atur Prioritas
        </a>

        <a href="{{ route('admin.projects.export.pdf') }}" target="_blank"
            class="bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition inline-flex items-center">
            <i class="fa-solid fa-file-pdf mr-1"></i> Export PDF
        </a>

        <a href="{{ route('admin.projects.export.excel') }}"
            class="bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition inline-flex items-center">
            <i class="fa-solid fa-file-excel mr-1"></i> Export Excel
        </a>

        <a href="{{ route('admin.projects.create') }}"
            class="bg-[#1E293B] text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm font-bold shadow-sm inline-flex items-center">
            <i class="fa-solid fa-plus mr-1"></i> Tambah Data
        </a>
    </div>
</div>
