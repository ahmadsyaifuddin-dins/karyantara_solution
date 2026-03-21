import Swal from 'sweetalert2'; // Import untuk digunakan di dalam file ini

document.addEventListener('alpine:init', () => {
    
    Alpine.data('bulkManager', (bulkUrl, actionAllUrl) => ({
        selectedIds: [],
        selectAll: false,

        toggleAll() {
            if (this.selectAll) {
                this.selectedIds = Array.from(document.querySelectorAll('.row-checkbox')).map(cb => cb.value);
            } else {
                this.selectedIds = [];
            }
        },

        checkItem() {
            const totalCheckboxes = document.querySelectorAll('.row-checkbox').length;
            this.selectAll = this.selectedIds.length === totalCheckboxes && totalCheckboxes > 0;
        },

        submitBulk(action) {
            if (this.selectedIds.length === 0) {
                return Swal.fire({
                    iconHtml: '<i class="fa-solid fa-circle-exclamation text-amber-500 text-4xl"></i>',
                    title: 'Pilih Data!',
                    text: 'Pilih minimal satu data terlebih dahulu!',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-gray-100 bg-white p-6',
                        icon: 'border-0 bg-amber-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-5',
                        title: 'text-[#1E293B] font-bold text-2xl mt-2',
                        htmlContainer: 'text-gray-500 text-sm mt-2 mb-6',
                        confirmButton: 'bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 px-8 rounded-lg focus:outline-none transition-all'
                    },
                    buttonsStyling: false
                });
            }

            let actionText = '';
            let iconConfig = '';
            let btnConfig = '';

            if (action === 'approve') {
                actionText = 'meng-ACC';
                iconConfig = { html: '<i class="fa-solid fa-check-circle text-amber-500 text-4xl"></i>', bg: 'bg-amber-50' };
                btnConfig = 'bg-amber-500 hover:bg-amber-600 text-white focus:ring-amber-400';
            } else if (action === 'hide') {
                actionText = 'menyembunyikan';
                iconConfig = { html: '<i class="fa-solid fa-eye-slash text-slate-600 text-4xl"></i>', bg: 'bg-slate-100' };
                btnConfig = 'bg-[#1E293B] hover:bg-slate-800 text-white focus:ring-slate-500';
            } else {
                actionText = 'MENGHAPUS';
                iconConfig = { html: '<i class="fa-solid fa-trash-can text-red-500 text-4xl"></i>', bg: 'bg-red-50' };
                btnConfig = 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500';
            }

            Swal.fire({
                title: 'Konfirmasi Aksi',
                text: `Yakin ingin ${actionText} ${this.selectedIds.length} data yang dipilih?`,
                iconHtml: iconConfig.html,
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-gray-100 bg-white p-6',
                    icon: `border-0 ${iconConfig.bg} rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-5`,
                    title: 'text-[#1E293B] font-bold text-2xl mt-2',
                    htmlContainer: 'text-gray-500 text-sm mt-2 mb-6',
                    actions: 'flex gap-3 w-full justify-center',
                    confirmButton: `${btnConfig} font-semibold py-2.5 px-6 rounded-lg focus:outline-none focus:ring-2 transition-all`,
                    cancelButton: 'bg-white border-2 border-[#1E293B] text-[#1E293B] hover:bg-gray-50 font-semibold py-2.5 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-300 transition-all'
                },
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.sendPost(bulkUrl, { ids: this.selectedIds, action: action });
                }
            });
        },

        submitAll(action) {
            const actionName = action === 'approve' ? 'meng-ACC' : 'menyembunyikan';
            const actionColor = action === 'approve' ? 'text-amber-500' : 'text-slate-600';
            const btnColor = action === 'approve' ? 'bg-amber-500 hover:bg-amber-600 focus:ring-amber-400' : 'bg-[#1E293B] hover:bg-slate-800 focus:ring-slate-500';
            const iconBg = action === 'approve' ? 'bg-amber-50' : 'bg-slate-100';
            
            Swal.fire({
                title: 'PERINGATAN!',
                text: `Yakin ingin ${actionName} SEMUA data di database?`,
                iconHtml: `<i class="fa-solid fa-triangle-exclamation ${actionColor} text-4xl"></i>`,
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-gray-100 bg-white p-6',
                    icon: `border-0 ${iconBg} rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-5`,
                    title: 'text-red-600 font-bold text-2xl mt-2',
                    htmlContainer: 'text-gray-500 text-sm mt-2 mb-6',
                    actions: 'flex gap-3 w-full justify-center',
                    confirmButton: `${btnColor} text-white font-semibold py-2.5 px-6 rounded-lg focus:outline-none focus:ring-2 transition-all`,
                    cancelButton: 'bg-white border-2 border-[#1E293B] text-[#1E293B] hover:bg-gray-50 font-semibold py-2.5 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-300 transition-all'
                },
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: `Ya, ${actionName} Semua`,
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.sendPost(actionAllUrl, { action: action });
                }
            });
        },

        sendPost(url, data) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrf);

            for (const key in data) {
                if (Array.isArray(data[key])) {
                    data[key].forEach(val => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `${key}[]`;
                        input.value = val;
                        form.appendChild(input);
                    });
                } else {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = data[key];
                    form.appendChild(input);
                }
            }
            document.body.appendChild(form);
            form.submit();
        }
    }));

    Alpine.data('googleSheetSync', (syncUrl) => ({
        syncData() {
            Swal.fire({
                title: 'Konfirmasi Sinkronisasi',
                    html: `
                    <p class="mb-4">Tindakan ini akan memperbarui seluruh data proyek publik di Google Spreadsheet secara massal. Pastikan data di sistem saat ini sudah akurat dan tidak ada data penting yang tidak sengaja terhapus sebelum Anda melanjutkan.</p>
                    
                    <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-100 inline-block w-full">
                        <p class="text-xs text-gray-500 font-semibold mb-1 uppercase tracking-wider">Target File Backup:</p>
                        <a href="https://docs.google.com/spreadsheets/d/1HFmSp8B6V03saKbhjLotI3OSfemU2eoxfftdAdTpUYQ/edit?usp=sharing" 
                           target="_blank" 
                           class="text-amber-600 hover:text-amber-700 font-bold flex items-center justify-center gap-2 transition-colors">
                            <i class="fa-solid fa-file-excel text-emerald-600 text-lg"></i>
                            Buka Google Spreadsheet Karyantara
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs ml-1"></i>
                        </a>
                    </div>
                `,
                
                iconHtml: '<i class="fa-solid fa-cloud-arrow-up text-amber-500 text-4xl"></i>',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-gray-100 bg-white p-6',
                    icon: 'border-0 bg-amber-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-5',
                    title: 'text-[#1E293B] font-bold text-2xl mt-2',
                    htmlContainer: 'text-gray-500 text-sm mt-2 mb-6', 
                    actions: 'flex gap-3 w-full justify-center',
                    confirmButton: 'bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 px-6 rounded-lg focus:outline-none focus:ring-2 transition-all',
                    cancelButton: 'bg-white border-2 border-[#1E293B] text-[#1E293B] hover:bg-gray-50 font-semibold py-2.5 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-300 transition-all'
                },
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Ya, Sync Sekarang',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menyinkronkan...',
                        text: 'Mohon tunggu, jangan tutup halaman ini.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = syncUrl;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                    form.appendChild(csrf);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    }));

    Alpine.data('settingToggle', (initialState, toggleUrl) => ({
        isActive: initialState,
        isLoading: false,

        toggleSetting() {
            this.isLoading = true;
            fetch(toggleUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.isActive = data.value === '1';
                    
                    window.Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'bg-white border-2 border-emerald-100 shadow-xl rounded-xl',
                            title: 'text-[#1E293B] text-sm font-bold'
                        }
                    });
                }
                this.isLoading = false;
            })
            .catch(() => {
                this.isLoading = false;
                window.Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Gagal memperbarui pengaturan!',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        }
    }));
});

