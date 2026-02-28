<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Daftar Proyek Klien</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        .title {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        .table th {
            background-color: #f3f4f6;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge-mhs {
            color: #1d4ed8;
            font-weight: bold;
            font-size: 9px;
        }

        .badge-umum {
            color: #b45309;
            font-weight: bold;
            font-size: 9px;
        }
    </style>
</head>

<body>

    @include('components.pdf.header')

    <div class="title">Laporan Rekapitulasi Proyek & Klien</div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Klien & Info Akademik</th>
                <th style="width: 30%;">Pekerjaan / Judul Skripsi</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 30%;">Finansial (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->client_name }}</strong><br>
                        @if ($item->client_type == 'mahasiswa')
                            <span class="badge-mhs">[MAHASISWA]</span><br>
                            NPM: {{ $item->npm ?? '-' }}<br>
                            KLS: {{ $item->class_name ?? '-' }}
                        @else
                            <span class="badge-umum">[UMUM]</span>
                        @endif
                    </td>
                    <td>
                        @if ($item->client_type == 'mahasiswa' && $item->skripsi_title)
                            <strong>"{{ $item->skripsi_title }}"</strong><br>
                        @endif
                        <span style="font-size: 10px; color: #555;">{{ $item->project_description }}</span>
                    </td>
                    <td class="text-center">{{ $item->status }}</td>
                    <td>
                        Net: Rp {{ number_format($item->net_income, 0, ',', '.') }}<br>
                        Paid: Rp {{ number_format($item->paid_amount, 0, ',', '.') }}<br>
                        Sisa: Rp {{ number_format($item->remaining_amount, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr style="background-color: #fef3c7;">
                <td colspan="4" class="text-right" style="font-weight: bold; padding: 10px;">TOTAL KESELURUHAN
                    PENDAPATAN:</td>
                <td style="font-weight: bold; padding: 10px;">
                    Net: Rp {{ number_format($projects->sum('net_income'), 0, ',', '.') }}<br>
                    Paid: Rp {{ number_format($projects->sum('paid_amount'), 0, ',', '.') }}<br>
                    Sisa: Rp
                    {{ number_format($projects->sum('net_income') - $projects->sum('paid_amount'), 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>

    </table>

    @include('components.pdf.signature')

</body>

</html>
