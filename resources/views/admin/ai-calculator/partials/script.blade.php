@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('aiCalculator', () => ({
                isLoading: false,
                result: null,
                renderedResult: '',
                form: {
                    target_item: '',
                    target_price: '',
                    model: '{{ $defaultModel }}'
                },

                submitCalculation() {
                    this.isLoading = true;
                    this.result = null;

                    // Ambil harga barang
                    const priceInput = document.querySelector('input[name="target_price"]');
                    if (priceInput) {
                        this.form.target_price = priceInput.value == '0' ? '' : priceInput.value;
                    }

                    // Ambil saldo tabungan pribadi
                    const balanceInput = document.querySelector('input[name="current_balance"]');
                    if (balanceInput) {
                        this.form.current_balance = balanceInput.value == '0' ? '0' : balanceInput
                        .value;
                    }

                    fetch('{{ route('admin.ai-calculator.calculate') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.form)
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.isLoading = false;
                            if (data.success) {
                                this.result = data.data;
                                this.renderedResult = marked.parse(data.data);
                            } else {
                                window.Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message ||
                                        'Terjadi kesalahan saat memproses data.'
                                });
                            }
                        })
                        .catch(error => {
                            this.isLoading = false;
                            console.error(error);
                            window.Swal.fire({
                                icon: 'error',
                                title: 'Error Jaringan!',
                                text: 'Gagal menghubungi server.'
                            });
                        });
                },

                loadHistory(id) {
                    this.isLoading = true;
                    this.result = null;

                    const fetchUrl = `{{ url('/admin/ai-calculator/history') }}/${id}`;

                    fetch(fetchUrl, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            this.isLoading = false;
                            if (data.success) {
                                this.result = data.data;
                                let historyHeader =
                                    `<div class="mb-4 p-3 bg-slate-100 text-[#1E293B] rounded-lg text-sm border border-slate-200"><i class="fa-solid fa-clock-rotate-left mr-2 text-amber-500"></i> Menampilkan riwayat analisis untuk: <strong class="text-amber-600">${data.item}</strong></div>`;
                                this.renderedResult = historyHeader + marked.parse(data.data);
                            }
                        })
                        .catch(error => {
                            this.isLoading = false;
                            console.error("Error Fetch History:", error);
                            window.Swal.fire({
                                icon: 'error',
                                title: 'Waduh!',
                                text: 'Gagal memuat riwayat. Coba cek Inspect Element.'
                            });
                        });
                }
            }));
        });
    </script>
@endpush
