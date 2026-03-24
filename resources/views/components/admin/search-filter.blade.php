@props([
    'action' => '',
    'searchPlaceholder' => 'Cari data...',
    'options' => [], // Untuk Filter Status Proyek
    'paymentOptions' => [], // Untuk Filter Status Pembayaran
])

<form action="{{ $action }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full">

    <div class="relative flex-grow">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
        </div>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder }}"
            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 sm:text-sm transition-colors shadow-sm">
    </div>

    @if (count($paymentOptions) > 0)
        <div class="sm:w-48 flex-shrink-0">
            <select name="payment_status" onchange="this.form.submit()"
                class="block w-full py-2.5 pl-3 pr-10 border border-gray-300 bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-colors cursor-pointer shadow-sm text-gray-700">
                <option value="">Status Bayar (Semua)</option>
                @foreach ($paymentOptions as $value => $label)
                    <option value="{{ $value }}" {{ request('payment_status') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    @if (count($options) > 0)
        <div class="sm:w-48 flex-shrink-0">
            <select name="status" onchange="this.form.submit()"
                class="block w-full py-2.5 pl-3 pr-10 border border-gray-300 bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 sm:text-sm transition-colors cursor-pointer shadow-sm text-gray-700">
                <option value="">Status Proyek (Semua)</option>
                @foreach ($options as $value => $label)
                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    <button type="submit"
        class="bg-[#1E293B] text-white px-5 py-2.5 rounded-lg hover:bg-gray-800 transition text-sm font-bold shadow-sm flex-shrink-0 flex items-center justify-center">
        Cari
    </button>

    @if (
        (request()->has('search') && request('search') != '') ||
            (request()->has('status') && request('status') != '') ||
            (request()->has('payment_status') && request('payment_status') != ''))
        <a href="{{ $action }}"
            class="bg-red-50 text-red-600 border border-red-200 px-5 py-2.5 rounded-lg hover:bg-red-100 transition text-sm font-bold shadow-sm flex items-center justify-center flex-shrink-0"
            title="Reset semua filter">
            <i class="fa-solid fa-xmark mr-2"></i> Reset
        </a>
    @endif
</form>
