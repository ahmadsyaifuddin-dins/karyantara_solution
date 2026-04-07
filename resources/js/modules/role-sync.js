import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', () => {
    const syncBtn = document.querySelector('.btn-sync-permissions');
    
    if (syncBtn) {
        syncBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: 'Sinkronisasi Fitur?',
                text: 'Sistem akan memindai route web Anda dan mendaftarkan fitur/izin baru ke database.',
                iconHtml: '<i class="fa-solid fa-rotate text-amber-500 text-4xl"></i>',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-gray-100 bg-white p-6',
                    icon: 'border-0 bg-amber-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-5',
                    title: 'text-[#1E293B] font-bold text-2xl mt-2',
                    htmlContainer: 'text-gray-500 text-sm mt-2 mb-6',
                    actions: 'flex gap-3 w-full justify-center',
                    confirmButton: 'bg-[#1E293B] hover:bg-slate-800 text-white font-semibold py-2.5 px-6 rounded-lg focus:outline-none transition-all',
                    cancelButton: 'bg-white border-2 border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold py-2.5 px-6 rounded-lg transition-all'
                },
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Ya, Sinkronkan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Animasi Loading biar makin keren
                    Swal.fire({
                        title: 'Memindai Sistem...',
                        text: 'Mendeteksi fitur baru, mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    form.submit();
                }
            });
        });
    }
});