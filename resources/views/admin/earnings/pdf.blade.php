<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Pendapatan - {{ auth()->user()->name }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .section-title {
            background-color: #f1f5f9;
            padding: 6px 10px;
            font-weight: bold;
            font-size: 11px;
            border-left: 4px solid #3b82f6;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        .section-title.writer {
            border-left-color: #f59e0b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f8fafc;
            font-weight: bold;
            font-size: 11px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }

        .bg-green {
            background-color: #d1fae5;
            color: #047857;
        }

        .bg-red {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .summary-box {
            border: 1px dashed #94a3b8;
            padding: 10px;
            margin-top: 20px;
            background-color: #f8fafc;
        }
    </style>
</head>

<body>

    <table
        style="width: 100%; border-bottom: 3px solid #1E293B; padding-bottom: 10px; margin-bottom: 15px; font-family: Helvetica, Arial, sans-serif; border-collapse: collapse; border: none;">
        <tr>
            <td style="width: 20%; text-align: left; vertical-align: middle; border: none; padding: 0;">
                <img src="{{ public_path('logo/logo_transparent.jpg') }}" alt="Logo Karyantara Solution"
                    style="max-width: 90px; height: auto;">
            </td>

            <td
                style="width: 60%; text-align: center; vertical-align: middle; line-height: 1.2; border: none; padding: 0;">
                <h2
                    style="margin: 0 0 2px 0; font-size: 22px; font-weight: 800; text-transform: uppercase; color: #1E293B; letter-spacing: 1px; font-family: Helvetica, Arial, sans-serif;">
                    KARYANTARA SOLUTION
                </h2>
                <h3
                    style="margin: 0 0 6px 0; font-size: 12px; font-weight: 600; color: #64748B; letter-spacing: 0.5px; text-transform: uppercase; font-family: Helvetica, Arial, sans-serif;">
                    IT Consultant & Software Development
                </h3>
                <p
                    style="margin: 0; font-size: 10px; font-weight: normal; color: #475569; font-family: Helvetica, Arial, sans-serif; line-height: 1.4;">
                    Anjir Muara, Barito Kuala - Banjarmasin, Kalimantan Selatan<br>
                    Email: karyantarasolution@gmail.com | WhatsApp: 0851-2423-7625 <br>
                    Website: karyantara-solution.kesug.com
                </p>
            </td>

            <td style="width: 20%; border: none; padding: 0;">
                &nbsp;
            </td>
        </tr>
    </table>

    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 14px; font-weight: bold; color: #1E293B; text-decoration: underline;">SLIP
            REKAP PENDAPATAN TIM</h2>
    </div>

    <table style="border: none; margin-bottom: 10px;">
        <tr>
            <td style="border: none; width: 100px; font-weight: bold; padding: 2px 0;">Nama Tim</td>
            <td style="border: none; width: 10px; padding: 2px 0;">:</td>
            <td style="border: none; padding: 2px 0;">{{ auth()->user()->name }}</td>
        </tr>
        <tr>
            <td style="border: none; font-weight: bold; padding: 2px 0;">Periode Filter</td>
            <td style="border: none; padding: 2px 0;">:</td>
            <td style="border: none; padding: 2px 0;">{{ $periode }}</td>
        </tr>
    </table>

    <div class="section-title">A. PENDAPATAN SEBAGAI DEVELOPER APLIKASI</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Nama Klien & Pekerjaan</th>
                <th style="width: 15%;">Status Proyek</th>
                <th style="width: 20%;">Status Fee</th>
                <th style="width: 20%;" class="text-right">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appProjects as $idx => $project)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td>
                        <strong>{{ $project->client_name }}</strong><br>
                        <span
                            style="font-size: 10px; color: #64748b;">{{ substr($project->skripsi_title ?? $project->project_description, 0, 50) }}...</span>
                    </td>
                    <td class="text-center">{{ $project->status }}</td>
                    <td class="text-center">
                        @if ($project->is_programmer_paid)
                            <span class="badge bg-green">Sudah Cair</span>
                        @else
                            <span class="badge bg-red">Belum Cair</span>
                        @endif
                    </td>
                    <td class="text-right font-bold">{{ number_format($project->app_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500">Tidak ada data proyek aplikasi di periode ini.
                    </td>
                </tr>
            @endforelse
            <tr>
                <td colspan="4" class="text-right font-bold" style="background-color: #f1f5f9;">SUBTOTAL APLIKASI
                </td>
                <td class="text-right font-bold" style="background-color: #f1f5f9;">
                    {{ number_format($appProjects->sum('app_price'), 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title writer">B. PENDAPATAN SEBAGAI PENYUSUN NASKAH</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Nama Klien & Pekerjaan</th>
                <th style="width: 15%;">Status Proyek</th>
                <th style="width: 20%;">Status Fee</th>
                <th style="width: 20%;" class="text-right">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($writerProjects as $idx => $project)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td>
                        <strong>{{ $project->client_name }}</strong><br>
                        <span
                            style="font-size: 10px; color: #64748b;">{{ substr($project->skripsi_title ?? $project->project_description, 0, 50) }}...</span>
                    </td>
                    <td class="text-center">{{ $project->status }}</td>
                    <td class="text-center">
                        @if ($project->is_writer_paid)
                            <span class="badge bg-green">Sudah Cair</span>
                        @else
                            <span class="badge bg-red">Belum Cair</span>
                        @endif
                    </td>
                    <td class="text-right font-bold">{{ number_format($project->writer_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500">Tidak ada data proyek naskah di periode ini.
                    </td>
                </tr>
            @endforelse
            <tr>
                <td colspan="4" class="text-right font-bold" style="background-color: #fffbeb;">SUBTOTAL NASKAH</td>
                <td class="text-right font-bold" style="background-color: #fffbeb;">
                    {{ number_format($writerProjects->sum('writer_price'), 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    @php
        $totalApp = $appProjects->sum('app_price');
        $totalWriter = $writerProjects->sum('writer_price');
        $grandTotal = $totalApp + $totalWriter;

        $unpaidApp = $appProjects->where('is_programmer_paid', false)->sum('app_price');
        $unpaidWriter = $writerProjects->where('is_writer_paid', false)->sum('writer_price');
        $totalUnpaid = $unpaidApp + $unpaidWriter;
    @endphp

    <div class="summary-box">
        <h4 style="margin-top: 0; margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">RINGKASAN
            TOTAL</h4>
        <table style="border: none; margin-bottom: 0;">
            <tr>
                <td style="border: none; width: 60%; padding: 4px 0;">Total Keseluruhan (Semua Status Proyek)</td>
                <td style="border: none; text-align: right; font-weight: bold; font-size: 14px; padding: 4px 0;">Rp
                    {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border: none; color: #b91c1c; padding: 4px 0;">Total Sisa Piutang (Belum Ditransfer ke
                    Rekening)</td>
                <td
                    style="border: none; text-align: right; font-weight: bold; color: #b91c1c; font-size: 14px; padding: 4px 0;">
                    Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <p style="text-align: right; font-size: 10px; color: #94a3b8; margin-top: 20px;">
        Dicetak pada: {{ now()->locale('id')->translatedFormat('l, d F Y H:i') }} WITA
    </p>

</body>

</html>
