<div class="lg:col-span-1 space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">
        <div class="bg-emerald-50/50 px-5 py-4 border-b border-emerald-100 flex items-center justify-between">
            <h4 class="font-bold text-emerald-800"><i class="fa-solid fa-rupiah-sign mr-2"></i> Rincian Keuangan</h4>
            @if ($project->is_paid_off)
                <span
                    class="bg-emerald-500 text-white text-[10px] px-2 py-0.5 rounded font-bold tracking-wider">LUNAS</span>
            @else
                <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded font-bold tracking-wider">BELUM
                    LUNAS</span>
            @endif
        </div>
        <div class="p-5 space-y-4">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Harga Fix (Pendapatan Bersih)
                </p>
                <p class="text-lg font-black text-[#1E293B]">Rp {{ number_format($project->net_income, 0, ',', '.') }}
                </p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Sudah Terbayar</p>
                <p class="text-lg font-black text-emerald-600">Rp
                    {{ number_format($project->paid_amount, 0, ',', '.') }}</p>
            </div>
            <div class="pt-3 border-t border-gray-100">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Sisa Pembayaran</p>
                <p class="text-xl font-black text-red-500">Rp
                    {{ number_format($project->remaining_amount, 0, ',', '.') }}</p>
            </div>
            <div
                class="bg-gray-50 p-3 rounded-lg border border-gray-100 text-xs font-medium text-gray-600 flex items-center">
                <i
                    class="fa-solid {{ $project->payment_method == 'cash' ? 'fa-money-bill text-green-500' : 'fa-building-columns text-blue-500' }} mr-2 text-lg"></i>
                Metode Pembayaran: <span class="font-bold ml-1 uppercase">{{ $project->payment_method }}</span>
            </div>
        </div>
    </div>

    @if ($project->client_type === 'mahasiswa')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-5 py-4 border-b border-gray-200">
                <h4 class="font-bold text-[#1E293B]"><i class="fa-solid fa-graduation-cap text-amber-500 mr-2"></i> Info
                    Akademik</h4>
            </div>
            <div class="p-5 space-y-3">
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">NPM / NIM</span>
                    <span class="font-semibold text-gray-800">{{ $project->npm ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kelas /
                        Jurusan</span>
                    <span class="font-semibold text-gray-800">{{ $project->class_name ?? '-' }}</span>
                </div>
                <div class="pt-2 border-t border-gray-50">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Dosen
                        Pembimbing</span>
                    <ul class="text-sm font-medium text-gray-700 space-y-1">
                        <li><i class="fa-solid fa-user-tie text-gray-400 mr-1 text-xs"></i> 1:
                            {{ $project->dospem_1 ?? '-' }}</li>
                        <li><i class="fa-solid fa-user-tie text-gray-400 mr-1 text-xs"></i> 2:
                            {{ $project->dospem_2 ?? '-' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if ($project->client_type === 'umum' && !empty($project->custom_team))
        <div class="bg-white rounded-2xl shadow-sm border border-indigo-100 overflow-hidden">
            <div class="bg-indigo-50 px-5 py-4 border-b border-indigo-100">
                <h4 class="font-bold text-[#1E293B]"><i class="fa-solid fa-users-gear text-indigo-500 mr-2"></i> Alokasi
                    Fee Tim</h4>
            </div>
            <div class="p-0">
                <ul class="divide-y divide-gray-100">
                    @foreach ($project->custom_team as $member)
                        @php $teamUser = \App\Models\User::find($member['user_id']); @endphp
                        @if ($teamUser)
                            <li class="p-4 flex justify-between items-center hover:bg-gray-50 transition-colors">
                                <div>
                                    <p class="font-bold text-sm text-[#1E293B]">{{ $teamUser->name }}</p>
                                    <p
                                        class="text-[11px] font-semibold text-indigo-600 mt-0.5 uppercase tracking-wider">
                                        {{ $member['role'] }}</p>
                                </div>
                                <span
                                    class="font-black text-gray-800 text-sm bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                    Rp {{ number_format($member['fee'], 0, ',', '.') }}
                                </span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
