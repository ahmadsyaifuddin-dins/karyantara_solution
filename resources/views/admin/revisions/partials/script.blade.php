@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lists = document.querySelectorAll('.sortable-list');

            lists.forEach(list => {
                new Sortable(list, {
                    group: 'kanban', // Memungkinkan drag antar kolom
                    animation: 200, // Diperhalus animasinya
                    ghostClass: 'opacity-40', // Efek transparan saat ditarik
                    dragClass: 'shadow-2xl', // Bayangan lebih tebal saat ditarik
                    easing: "cubic-bezier(1, 0, 0, 1)",

                    onEnd: function(evt) {
                        const itemEl = evt.item;
                        const toList = evt.to;

                        const ticketId = itemEl.getAttribute('data-id');
                        const newStatus = toList.getAttribute('data-status');

                        // Ambil urutan baru di kolom tujuan untuk update Sort_Order
                        const orderArray = Array.from(toList.children).map(child => child
                            .getAttribute('data-id'));

                        // Fetch API native (Vanilla JS)
                        fetch('{{ route('admin.revisions.update-status') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    ticket_id: ticketId,
                                    status: newStatus,
                                    new_order: orderArray
                                })
                            }).then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Notifikasi elegan pakai SweetAlert global kita
                                    window.Toast.fire({
                                        icon: 'success',
                                        title: 'Status Diperbarui'
                                    });
                                }
                            }).catch(err => {
                                console.error(err);
                                window.Toast.fire({
                                    icon: 'error',
                                    title: 'Gagal memperbarui status'
                                });
                            });
                    },
                });
            });
        });
    </script>
@endpush
