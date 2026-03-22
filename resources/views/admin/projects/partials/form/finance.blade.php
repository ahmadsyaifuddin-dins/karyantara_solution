<div class="bg-emerald-50/30 p-6 rounded-lg border border-emerald-100 mb-6 grid grid-cols-1 md:grid-cols-3 gap-6">
    <h3 class="col-span-1 md:col-span-3 font-bold text-emerald-700 border-b border-emerald-200 pb-2">
        <i class="fa-solid fa-rupiah-sign mr-2"></i>Keuangan
    </h3>

    <div x-show="clientType === 'mahasiswa' && ['aplikasi', 'keduanya', 'sempro_keduanya', 'sidang_aplikasi', 'sidang_keduanya'].includes(package)"
        x-cloak>
        <x-forms.label value="Harga Fix Aplikasi" class="text-blue-700" />
        <x-forms.currency name="app_price" value="{{ old('app_price', $project->app_price ?? 0) }}" />
        <span class="text-xs text-blue-600 mt-1 block font-medium">Alokasi untuk Developer.</span>
    </div>

    <div x-show="clientType === 'mahasiswa' && ['naskah', 'keduanya', 'sempro_naskah', 'sempro_bab3', 'sempro_keduanya', 'sidang_naskah', 'sidang_keduanya', 'sidang_bab4'].includes(package)"
        x-cloak>
        <x-forms.label value="Harga Fix Naskah" class="text-amber-700" />
        <x-forms.currency name="writer_price" value="{{ old('writer_price', $project->writer_price ?? 0) }}" />
        <span class="text-xs text-amber-600 mt-1 block font-medium">Alokasi untuk Penulis.</span>
    </div>

    <div x-show="clientType !== 'mahasiswa' || package === ''" x-cloak>
        <x-forms.label value="Pendapatan Bersih (Harga Total)" />
        <x-forms.currency name="net_income" value="{{ old('net_income', $project->net_income ?? 0) }}" />
        <span class="text-xs text-gray-500 mt-1 block">Harga final setelah potong fee.</span>
    </div>

    <div>
        <x-forms.label value="Sudah Terbayar (DP/Lunas)" required="true" />
        <x-forms.currency name="paid_amount" value="{{ old('paid_amount', $project->paid_amount ?? 0) }}"
            required="true" />
    </div>

    <div>
        <x-forms.label value="Jenis Pembayaran" required="true" />
        <x-forms.dropdown name="payment_method" required>
            <option value="transfer"
                {{ old('payment_method', $project->payment_method ?? '') == 'transfer' ? 'selected' : '' }}>Transfer
                Bank/E-Wallet</option>
            <option value="cash"
                {{ old('payment_method', $project->payment_method ?? '') == 'cash' ? 'selected' : '' }}>Cash (Tunai)
            </option>
        </x-forms.dropdown>
    </div>
</div>
