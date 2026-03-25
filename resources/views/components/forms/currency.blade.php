@props(['name' => '', 'value' => '', 'required' => false])

<div x-data="{
    rawValue: '{{ $value ?: 0 }}',
    formattedValue: '{{ $value }}',

    formatCurrency() {
        // Hapus semua karakter yang bukan angka
        let number = String(this.formattedValue).replace(/\D/g, '');

        // JURUS JITU: Jika kosong, otomatis kirim angka 0 ke database
        this.rawValue = number ? number : 0;

        // Format angka dengan pemisah ribuan ala Indonesia (titik)
        this.formattedValue = number ? new Intl.NumberFormat('id-ID').format(number) : '';
    },

    init() {
        // Jalankan format saat halaman pertama kali dimuat (untuk data lama / edit)
        this.formatCurrency();
    }
}" class="relative w-full">

    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <span class="text-gray-500 font-semibold sm:text-sm">Rp</span>
    </div>

    <input type="text" x-model="formattedValue" @input="formatCurrency" {{ $required ? 'required' : '' }}
        {!! $attributes->except(['::name', 'x-bind:name'])->merge([
            'class' =>
                'pl-10 border-gray-300 focus:border-[#1E293B] focus:ring-[#1E293B] rounded-md shadow-sm w-full transition-colors',
        ]) !!}>

    <input type="hidden" name="{{ $name }}" {!! $attributes->only(['::name', 'x-bind:name']) !!} x-model="rawValue">

</div>
