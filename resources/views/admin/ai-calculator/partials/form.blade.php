<div class="lg:col-span-4 space-y-6">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-[#1E293B] mb-4 border-b pb-2">Rencana Pembelian</h3>

        <form @submit.prevent="submitCalculation" class="space-y-4">
            <div>
                <x-forms.label required="true">Barang yang Ingin Dibeli</x-forms.label>
                <input type="text" x-model="form.target_item" required placeholder="Cth: Laptop ASUS TUF Dash F15"
                    class="w-full border-gray-300 focus:border-[#1E293B] focus:ring-[#1E293B] rounded-md shadow-sm">
            </div>

            <div>
                <x-forms.label>
                    Total Saldo Rekening Saat Ini <span class="text-xs text-gray-400 font-normal">- SeaBank, dll (Udah
                        gabungan fee & cicilan)</span>
                </x-forms.label>

                <x-forms.currency name="current_balance" placeholder="Cth: 6.751.000" />
            </div>

            <div>
                <x-forms.label>
                    Estimasi Harga <span class="text-xs text-gray-400 font-normal">- Kosongkan jika ingin AI
                        menebak</span>
                </x-forms.label>

                <x-forms.currency name="target_price" placeholder="Cth: 16.500.000" />
            </div>

            <div>
                <x-forms.label required="true">Model AI Groq</x-forms.label>
                <select x-model="form.model" required
                    class="w-full border-gray-300 focus:border-[#1E293B] focus:ring-[#1E293B] rounded-md shadow-sm text-sm">
                    @foreach ($models as $model)
                        <option value="{{ $model }}" {{ $model === $defaultModel ? 'selected' : '' }}>
                            {{ $model }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" :disabled="isLoading"
                class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-[#1E293B] hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1E293B] transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                <span x-show="!isLoading"><i class="fa-solid fa-wand-magic-sparkles mr-2 text-amber-500"></i> Analisis
                    Sekarang</span>
                <span x-show="isLoading" class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-notch fa-spin text-amber-500"></i> AI Sedang Berpikir...
                </span>
            </button>
        </form>
    </div>

    @if ($histories->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                <h3 class="text-sm font-bold text-[#1E293B]"><i
                        class="fa-solid fa-clock-rotate-left mr-2 text-amber-500"></i> Riwayat Terakhir</h3>
            </div>
            <div class="divide-y divide-gray-100 max-h-64 overflow-y-auto">
                @foreach ($histories as $hist)
                    <button type="button" @click.prevent="loadHistory({{ $hist->id }})"
                        class="w-full text-left p-4 hover:bg-slate-50 transition-colors flex flex-col gap-1 focus:outline-none">
                        <span class="font-bold text-sm text-[#1E293B] truncate">{{ $hist->target_item }}</span>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>{{ $hist->target_price ? 'Rp ' . number_format($hist->target_price, 0, ',', '.') : 'Harga Tebakan AI' }}</span>
                            <span>{{ $hist->created_at->diffForHumans() }}</span>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    @endif
</div>
