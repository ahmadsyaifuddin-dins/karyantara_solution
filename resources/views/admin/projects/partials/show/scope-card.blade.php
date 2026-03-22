<div class="lg:col-span-2 space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden h-full">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h4 class="font-bold text-[#1E293B]"><i class="fa-solid fa-list-check text-blue-500 mr-2"></i> Ruang Lingkup
                Pekerjaan</h4>
        </div>
        <div class="p-6">

            @if ($project->skripsi_package)
                @php
                    $isSempro = str_starts_with($project->skripsi_package, 'sempro_');
                    $isSidang = str_starts_with($project->skripsi_package, 'sidang_');

                    if ($isSempro) {
                        $boxClass = 'border-teal-200 bg-teal-50/50';
                        $iconColor = 'text-teal-500';
                        $textColor = 'text-teal-800';
                        $descColor = 'text-teal-700';
                    } elseif ($isSidang) {
                        $boxClass = 'border-purple-200 bg-purple-50/50';
                        $iconColor = 'text-purple-500';
                        $textColor = 'text-purple-800';
                        $descColor = 'text-purple-700';
                    } else {
                        $boxClass = 'border-amber-200 bg-amber-50/50';
                        $iconColor = 'text-amber-500';
                        $textColor = 'text-amber-800';
                        $descColor = 'text-amber-700';
                    }
                @endphp
                <div class="mb-6 p-4 rounded-xl border {{ $boxClass }} flex items-start gap-4">
                    <div class="mt-1">
                        <i class="fa-solid fa-bullseye text-2xl {{ $iconColor }}"></i>
                    </div>
                    <div>
                        <h4 class="font-bold {{ $textColor }} text-sm uppercase tracking-wider">Target Pekerjaan Tim
                        </h4>
                        <p class="{{ $descColor }} font-medium text-sm mt-1 leading-relaxed">
                            @if ($project->skripsi_package == 'keduanya')
                                Tim wajib menyelesaikan <strong>Sistem/Aplikasi</strong> beserta penyusunan
                                <strong>Naskah Skripsi Lengkap (Bab 1 - 5)</strong> sesuai panduan kampus.
                            @elseif($project->skripsi_package == 'aplikasi')
                                Tim hanya fokus mengembangkan <strong>Sistem/Aplikasi</strong>. Klien menyusun naskah
                                secara mandiri.
                            @elseif($project->skripsi_package == 'naskah')
                                Tim hanya fokus menyusun <strong>Naskah Skripsi Lengkap (Bab 1 - 5)</strong>. Aplikasi
                                sudah ada atau dikerjakan pihak lain.
                            @elseif($project->skripsi_package == 'sempro_keduanya')
                                Tim wajib menyelesaikan <strong>Sistem/Aplikasi Prototype</strong> beserta penyusunan
                                <strong>Naskah Proposal (Bab 1 - 3)</strong> untuk keperluan Seminar.
                            @elseif($project->skripsi_package == 'sempro_naskah')
                                Tim fokus menyusun <strong>Naskah Proposal (Bab 1 - 3)</strong> untuk keperluan Seminar
                                Proposal.
                            @elseif($project->skripsi_package == 'sempro_bab3')
                                Tim khusus menyusun lanjutan naskah pada bagian <strong>Bab 3 (Metodologi
                                    Penelitian)</strong> saja.
                            @elseif($project->skripsi_package == 'sidang_aplikasi')
                                Tim wajib menyelesaikan <strong>Revisi Sistem/Aplikasi</strong> pasca seminar proposal.
                            @elseif($project->skripsi_package == 'sidang_naskah')
                                Tim fokus menyusun lanjutan <strong>Naskah Bab 4 (Hasil/Pengujian) dan Bab 5
                                    (Kesimpulan)</strong>.
                            @elseif($project->skripsi_package == 'sidang_bab4')
                                Tim khusus mengerjakan bagian <strong>Bab 4 (Pengujian Aplikasi / Blackbox
                                    Testing)</strong> saja.
                            @elseif($project->skripsi_package == 'sidang_keduanya')
                                Tim wajib menyelesaikan <strong>Revisi Aplikasi</strong> sekaligus penyusunan naskah
                                <strong>Bab 4 dan Bab 5</strong> hingga siap sidang akhir.
                            @endif
                        </p>
                    </div>
                </div>
            @endif

            @if ($project->client_type === 'mahasiswa')
                <div class="mb-6 pb-6 border-b border-gray-100">
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Judul Skripsi /
                        Sempro (Fix)</span>
                    <h3 class="text-lg font-bold text-gray-800 leading-relaxed">
                        {{ $project->skripsi_title ? '"' . $project->skripsi_title . '"' : 'Belum ada judul' }}
                    </h3>
                </div>
            @endif

            <div class="mb-6">
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Fitur /
                    Aplikasi yang dibuat</span>
                <div
                    class="prose max-w-none text-gray-700 bg-slate-50 p-5 rounded-xl border border-gray-100 whitespace-pre-line leading-relaxed">
                    {{ $project->project_description }}
                </div>
            </div>

            @if ($project->revision_notes)
                <div class="mt-8">
                    <span class="flex items-center text-xs font-bold text-amber-600 uppercase tracking-wider mb-2">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i> Catatan Revisi Aktif
                    </span>
                    <div
                        class="bg-amber-50 p-5 rounded-xl border border-amber-200 text-amber-800 whitespace-pre-line leading-relaxed font-medium text-sm">
                        {{ $project->revision_notes }}
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
