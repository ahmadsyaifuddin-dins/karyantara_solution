<div
    class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4 mt-6">
    <div class="flex items-center gap-2 text-gray-500">
        <i class="fa-solid fa-calendar-days text-blue-500 text-lg"></i>
        <span class="font-bold text-sm uppercase tracking-wider">Filter Rekap Pendapatan</span>
    </div>

    @php
        $bulanIndo = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    @endphp

    <form method="GET" action="{{ route('admin.earnings.index') }}" class="flex items-center gap-3 w-full md:w-auto">
        <select name="month"
            class="bg-gray-50 border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="all" {{ $selectedMonth == 'all' ? 'selected' : '' }}>Semua Bulan</option>
            @foreach ($bulanIndo as $num => $name)
                @php $val = str_pad($num, 2, '0', STR_PAD_LEFT); @endphp
                <option value="{{ $val }}" {{ $selectedMonth == $val ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>

        <select name="year"
            class="bg-gray-50 border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="all" {{ $selectedYear == 'all' ? 'selected' : '' }}>Semua Tahun</option>
            @foreach ($years as $y)
                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}
                </option>
            @endforeach
        </select>

        <button type="submit"
            class="bg-[#1E293B] text-white px-4 py-2.5 rounded-lg hover:bg-gray-800 transition font-bold shadow-sm">
            Tampilkan
        </button>
    </form>
</div>
