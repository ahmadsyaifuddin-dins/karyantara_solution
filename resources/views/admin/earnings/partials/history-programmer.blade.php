<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col max-h-[600px]">
    <div class="px-6 py-5 border-b border-blue-100 bg-blue-50/30 flex items-center justify-between">
        <h3 class="font-bold text-[#1E293B]"><i class="fa-solid fa-code text-blue-500 mr-2"></i> Histori Developer
            Aplikasi</h3>
        <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-md font-bold">{{ $appProjects->count() }}
            Proyek</span>
    </div>

    <div class="divide-y divide-gray-100 overflow-y-auto flex-1">
        @forelse($appProjects as $project)
            <div
                class="p-5 hover:bg-gray-50 transition-colors {{ !$project->is_programmer_paid ? 'bg-red-50/10' : '' }}">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-bold text-[#1E293B] text-sm">{{ $project->client_name }}</h4>
                    <span class="font-black text-blue-600">Rp
                        {{ number_format($project->app_price, 0, ',', '.') }}</span>
                </div>
                <p class="text-xs text-gray-500 line-clamp-1 mb-2">
                    {{ $project->skripsi_title ?? $project->project_description }}
                </p>

                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-[11px] font-medium flex items-center gap-2">
                        <span
                            class="px-2 py-0.5 rounded border shadow-sm {{ $project->status == 'Selesai' ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-gray-100 text-gray-600 border-gray-200' }}">
                            {{ $project->status }}
                        </span>
                        @if ($project->is_programmer_paid)
                            <span class="text-emerald-600 bg-emerald-50 px-2 py-1 rounded"><i
                                    class="fa-solid fa-check-double mr-1"></i> Cair</span>
                        @else
                            <span class="text-red-500 bg-red-50 px-2 py-1 rounded"><i
                                    class="fa-solid fa-clock mr-1"></i> Belum Cair</span>
                        @endif
                    </div>
                    <form action="{{ route('admin.earnings.toggle-paid', $project->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="type" value="programmer">
                        <button type="submit"
                            class="text-[10px] px-3 py-1.5 rounded font-bold shadow-sm transition-all focus:ring-2 focus:outline-none 
                            {{ $project->is_programmer_paid ? 'bg-white border border-gray-200 text-gray-500 hover:bg-gray-100' : 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-300' }}">
                            {{ $project->is_programmer_paid ? 'Batalkan' : 'Tandai Cair' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-gray-400">
                <i class="fa-solid fa-ghost text-3xl mb-3"></i>
                <p class="text-sm">Belum ada proyek aplikasi.</p>
            </div>
        @endforelse
    </div>
</div>
