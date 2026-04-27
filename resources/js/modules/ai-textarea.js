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
                    toast: true, position: 'top-end', icon: 'warning',
                    title: 'Teks masih kosong!', showConfirmButton: false, timer: 3000
                });
                return;
            }

            this.isAiLoading = true;
            
            if (!this.hasEnhanced) {
                this.originalText = this.textContent;
            }

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
                    signal: controller.signal
                });

                clearTimeout(timeoutId); 
                const data = await response.json();

                if (data.success) {
                    // Update textarea
                    this.textContent = data.result;
                    this.hasEnhanced = true;

                    // FIRE EVENT: Kirim sinyal ke Tom Select untuk menyeleksi tag
                    if (data.suggested_tags && data.suggested_tags.length > 0) {
                        window.dispatchEvent(new CustomEvent('ai-tags-suggested', {
                            detail: { tags: data.suggested_tags }
                        }));
                    }

                    Swal.fire({
                        toast: true, position: 'top-end', icon: 'success',
                        title: 'Teks dirapikan & Tag otomatis terisi! 🪄',
                        showConfirmButton: false, timer: 3000,
                        customClass: {
                            popup: 'bg-white border-2 border-emerald-100 shadow-xl rounded-xl',
                            title: 'text-[#1E293B] text-sm font-bold'
                        }
                    });
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                let errorMsg = 'Gagal merapikan teks.';
                if (error.name === 'AbortError') errorMsg = 'Koneksi ke AI terputus/Timeout.';

                Swal.fire({
                    toast: true, position: 'top-end', icon: 'error',
                    title: errorMsg, showConfirmButton: false, timer: 3000
                });
            } finally {
                this.isAiLoading = false;
            }
        }
    }));
});