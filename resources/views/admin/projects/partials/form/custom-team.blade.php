<div x-show="clientType === 'umum'" x-cloak class="bg-indigo-50/30 p-6 rounded-xl border border-indigo-100 mb-6"
    style="display: none;">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center border-b border-indigo-200 pb-3 mb-5 gap-3">
        <div>
            <h3 class="font-bold text-indigo-800 text-lg">
                <i class="fa-solid fa-users-gear mr-2"></i>Tim Proyek (Kustom)
            </h3>
            <p class="text-xs text-indigo-600 mt-1">Tambahkan anggota tim dan alokasi fee khusus untuk proyek ini.</p>
        </div>
        <button type="button" @click="addTeamMember"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition shadow-sm flex items-center justify-center w-full sm:w-auto">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Anggota
        </button>
    </div>

    <div class="space-y-4">
        <template x-for="(member, index) in customTeam" :key="index">
            <div
                class="flex flex-col md:flex-row gap-4 items-start bg-white p-5 rounded-lg border border-indigo-100 relative shadow-sm hover:border-indigo-300 transition-colors">

                <div class="w-full md:w-1/3">
                    <x-forms.label value="1. Pilih Anggota" required="true" />
                    <x-forms.dropdown ::name="'custom_team[' + index + '][user_id]'" x-model="member.user_id" ::required="clientType === 'umum'" ::disabled="clientType !== 'umum'">
                        <option value="">-- Pilih Tim --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-forms.dropdown>
                </div>

                <div class="w-full md:w-1/3">
                    <x-forms.label value="2. Tugas / Role" required="true" />
                    <x-forms.input type="text" ::name="'custom_team[' + index + '][role]'" x-model="member.role"
                        placeholder="Cth: UI/UX Designer" ::required="clientType === 'umum'" ::disabled="clientType !== 'umum'" />
                </div>

                <div class="w-full md:w-1/3">
                    <x-forms.label value="3. Alokasi Fee (Rp)" required="true" />
                    <div class="relative w-full mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-semibold sm:text-sm">Rp</span>
                        </div>

                        <input type="text"
                            :value="member.fee ? new Intl.NumberFormat('id-ID').format(member.fee) : ''"
                            @input="
                                let num = $event.target.value.replace(/\D/g, '');
                                member.fee = num ? parseInt(num) : 0;
                                $event.target.value = num ? new Intl.NumberFormat('id-ID').format(num) : '';
                            "
                            class="pl-10 border-gray-300 focus:border-[#1E293B] focus:ring-[#1E293B] rounded-md shadow-sm w-full transition-colors text-sm font-bold text-indigo-700 bg-gray-50"
                            :required="clientType === 'umum'" :disabled="clientType !== 'umum'">

                        <input type="hidden" :name="'custom_team[' + index + '][fee]'" :value="member.fee || 0"
                            :disabled="clientType !== 'umum'">
                    </div>
                </div>

                <button type="button" @click="removeTeamMember(index)"
                    class="absolute -top-2 -right-2 bg-red-100 text-red-600 hover:bg-red-600 hover:text-white rounded-full w-7 h-7 flex items-center justify-center transition shadow-md border border-white"
                    title="Hapus Baris">
                    <i class="fa-solid fa-times text-xs"></i>
                </button>
            </div>
        </template>

        <div x-show="customTeam.length === 0"
            class="text-center py-8 text-sm text-indigo-400 font-medium border-2 border-dashed border-indigo-200 rounded-xl bg-white">
            <i class="fa-solid fa-user-plus text-2xl mb-2 opacity-50 block"></i>
            Belum ada anggota tim yang ditambahkan. <br>Klik tombol "Tambah Anggota" di atas.
        </div>
    </div>
</div>
