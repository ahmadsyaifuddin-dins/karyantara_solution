import Swal from 'sweetalert2';

document.addEventListener('alpine:init', () => {
    Alpine.data('aiTextarea', (endpointUrl) => ({
        textContent: '',
        originalText: '',   // State untuk menyimpan teks sebelum diubah
        isAiLoading: false,
        hasEnhanced: false, // Flag untuk memunculkan tombol Undo

        init() {
            this.textContent = this.$refs.aiInput.value;
        },

        // Fungsi baru untuk mengembalikan teks asli
        undo() {
            this.textContent = this.originalText;
            this.hasEnhanced = false; // Sembunyikan tombol Undo setelah diklik
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: 'Teks dikembalikan ke versi asli',
                showConfirmButton: false,
                timer: 3000
            });
        },

        async enhance() {
            if (!this.textContent.trim()) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: 'Teks masih kosong!',
                    showConfirmButton: false,
                    timer: 3000
                });
                return;
            }

            this.isAiLoading = true;
            
            // Simpan teks asli SEBELUM request (hanya jika belum ada history enhance)
            if (!this.hasEnhanced) {
                this.originalText = this.textContent;
            }

            // Siapkan AbortController untuk timeout 15 detik
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 15000);

            try {
                const response = await fetch(endpointUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ text: this.textContent }),
                    signal: controller.signal // Masukkan sinyal pembatalan
                });

                clearTimeout(timeoutId); // Hapus timer jika request berhasil sebelum 15 detik

                const data = await response.json();

                if (data.success) {
                    this.textContent = data.result;
                    this.hasEnhanced = true; // Tampilkan tombol Undo
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Teks berhasil dirapikan AI',
                        showConfirmButton: false,
                        timer: 3000,
                        customClass: {
                            popup: 'bg-white border-2 border-emerald-100 shadow-xl rounded-xl',
                            title: 'text-[#1E293B] text-sm font-bold'
                        }
                    });
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                // Tangkap spesifik jika error karena Timeout
                let errorMsg = 'Gagal merapikan teks.';
                if (error.name === 'AbortError') {
                    errorMsg = 'Koneksi ke AI terputus/Timeout.';
                }

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: errorMsg,
                    showConfirmButton: false,
                    timer: 3000
                });
            } finally {
                this.isAiLoading = false;
            }
        }
    }));
});