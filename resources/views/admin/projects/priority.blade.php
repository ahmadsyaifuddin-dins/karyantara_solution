<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
                <i class="fa-solid fa-list-check text-amber-500 mr-2"></i> {{ __('Atur Prioritas Pengerjaan') }}
            </h2>
            <a href="{{ route('admin.projects.index') }}"
                class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-xl text-sm font-bold shadow-sm hover:bg-gray-50 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-xl shadow-sm mb-6 flex items-start gap-3">
                <i class="fa-solid fa-circle-info text-amber-500 mt-0.5"></i>
                <p class="text-sm text-amber-800">
                    <strong>Tarik dan lepas (Drag & Drop)</strong> kartu proyek di bawah ini untuk mengatur urutan
                    prioritas pengerjaan. Proyek paling atas adalah prioritas utama. Perubahan akan <b>tersimpan
                        otomatis</b>.
                </p>
            </div>

            <div class="bg-gray-100 p-6 rounded-2xl shadow-inner min-h-[500px]">
                <ul id="sortable-list" class="space-y-4">
                    @forelse($projects as $project)
                        <li data-id="{{ $project->id }}"
                            class="cursor-grab active:cursor-grabbing bg-white border border-gray-200 p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div class="text-gray-300 group-hover:text-amber-500 transition-colors">
                                    <i class="fa-solid fa-grip-vertical text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[#1E293B]">{{ $project->client_name }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $project->project_description }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span
                                    class="px-2.5 py-1 text-[10px] font-bold rounded-full 
                                    {{ $project->status == 'Progress' ? 'bg-blue-100 text-blue-800' : ($project->status == 'Revisi' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ $project->status }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <div class="text-center py-10 text-gray-500">
                            Tidak ada proyek yang berstatus Pending, Progress, atau Revisi saat ini.
                        </div>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const list = document.getElementById('sortable-list');

            if (list) {
                new Sortable(list, {
                    animation: 150,
                    ghostClass: 'opacity-50', // Efek transparan saat digeser
                    handle: '.cursor-grab', // Area yang bisa di-drag
                    onEnd: function(evt) {
                        // Ambil semua ID berdasarkan urutan elemen li
                        let order = [];
                        document.querySelectorAll('#sortable-list li').forEach(function(el) {
                            order.push(el.getAttribute('data-id'));
                        });

                        // Kirim data ke backend pakai fetch API (AJAX)
                        fetch('{{ route('admin.projects.update-priority') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    orders: order
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Notifikasi sukses kecil di pojok kanan atas
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 2000,
                                        timerProgressBar: true,
                                    });
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Urutan tersimpan!'
                                    })
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    },
                });
            }
        });
    </script>
</x-app-layout>
