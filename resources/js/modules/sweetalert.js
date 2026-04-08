import Swal from 'sweetalert2';

// Jadikan global agar bisa dipanggil dari tag <script> di Blade jika terpaksa
window.Swal = Swal;

// 1. SETUP TOAST (Untuk Flash Message / Notif Sukses)
const ToastKaryantara = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    // TAMBAHKAN 2 BARIS INI UNTUK OVERRIDE DEFAULT SWEETALERT
    background: '#1E293B', 
    color: '#ffffff',      
    customClass: {
        // Hapus class bg-[#1E293B] dan text-white dari sini karena sudah di-handle di atas
        popup: 'rounded-xl shadow-2xl border border-slate-700 mt-4 mr-4',
        title: 'text-sm font-medium ml-2',
        timerProgressBar: 'bg-amber-500',
    },
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = ToastKaryantara;

// 2. EVENT LISTENER KONFIRMASI HAPUS GLOBAL (Class .form-delete)
document.addEventListener('DOMContentLoaded', () => {
    const deleteForms = document.querySelectorAll('.form-delete');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); 
            
            // Tangkap nama data dari atribut data-name
            // Jika atribut tidak ada/kosong, fallback ke teks default 'Data Ini'
            const dataName = this.dataset.name ? `"${this.dataset.name}"` : 'Data Ini';
            
            Swal.fire({
                // Gunakan dataName yang sudah ditangkap untuk Title
                title: `Hapus ${dataName}?`,
                text: "Tindakan ini permanen dan data tidak dapat dikembalikan.",
                iconHtml: '<i class="fa-solid fa-trash-can text-red-500 text-4xl"></i>',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-gray-100 bg-white p-6',
                    icon: 'border-0 bg-red-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-5',
                    title: 'text-[#1E293B] font-bold text-xl md:text-2xl mt-2', // Ukuran teks disesuaikan sedikit agar rapi jika nama panjang
                    htmlContainer: 'text-gray-500 text-sm mt-2 mb-6',
                    actions: 'flex gap-3 w-full justify-center',
                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-all',
                    cancelButton: 'bg-white border-2 border-[#1E293B] text-[#1E293B] hover:bg-gray-50 font-semibold py-2.5 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-300 transition-all'
                },
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});