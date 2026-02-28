<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice & MoU - {{ $project->client_name }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            text-decoration: underline;
            letter-spacing: 1px;
        }

        .section-title {
            background-color: #1E293B;
            color: #fff;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 4px 8px;
            vertical-align: top;
        }

        .info-table td.label {
            width: 30%;
            font-weight: bold;
        }

        .info-table td.colon {
            width: 2%;
            text-align: center;
        }

        .finance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .finance-table th,
        .finance-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .finance-table th {
            background-color: #f3f4f6;
            text-align: left;
        }

        .total-row {
            background-color: #fef3c7;
            font-weight: bold;
        }

        .terms {
            font-size: 11px;
            margin-top: 20px;
            padding: 10px;
            border: 1px dashed #999;
            background-color: #fafafa;
        }

        .terms ul {
            margin: 5px 0 0 0;
            padding-left: 20px;
        }

        .terms li {
            margin-bottom: 4px;
            text-align: justify;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 10px;
            color: #fff;
            background-color: #10b981;
        }
    </style>
</head>

<body>

    @include('components.pdf.header')

    <div class="title">INVOICE & KESEPAKATAN KERJA (MoU)</div>

    <div class="section-title">A. DATA KLIEN & PEKERJAAN</div>
    <table class="info-table">
        <tr>
            <td class="label">Nama Klien</td>
            <td class="colon">:</td>
            <td><strong>{{ strtoupper($project->client_name) }}</strong> (Klien {{ ucfirst($project->client_type) }})
            </td>
        </tr>
        <tr>
            <td class="label">Tanggal Order</td>
            <td class="colon">:</td>
            <td>{{ $project->created_at->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
        @if ($project->client_type == 'mahasiswa')
            <tr>
                <td class="label">NPM / Kelas</td>
                <td class="colon">:</td>
                <td>{{ $project->npm ?? '-' }} / {{ $project->class_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Dosen Pembimbing</td>
                <td class="colon">:</td>
                <td>1. {{ $project->dospem_1 ?? '-' }} <br> 2. {{ $project->dospem_2 ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Judul Skripsi</td>
                <td class="colon">:</td>
                <td><em>"{{ $project->skripsi_title ?? '-' }}"</em></td>
            </tr>
        @endif
        <tr>
            <td class="label">Deskripsi Pekerjaan</td>
            <td class="colon">:</td>
            <td style="text-align: justify;">{{ $project->project_description }}</td>
        </tr>
    </table>

    <div class="section-title">B. RINCIAN BIAYA & PEMBAYARAN</div>
    <table class="finance-table">
        <thead>
            <tr>
                <th style="width: 50%;">Keterangan</th>
                <th style="width: 50%; text-align: right;">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Biaya Proyek (Harga Fix)</td>
                <td class="text-right font-bold">Rp {{ number_format($project->net_income, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Sudah Dibayarkan (Deposit/DP)</td>
                <td class="text-right">Rp {{ number_format($project->paid_amount, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td>SISA PEMBAYARAN</td>
                <td class="text-right" style="color: {{ $project->is_paid_off ? '#10b981' : '#ef4444' }};">
                    @if ($project->is_paid_off)
                        LUNAS
                    @else
                        Rp {{ number_format($project->remaining_amount, 0, ',', '.') }}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <p style="font-size: 11px; margin-top: 5px;">
        <em>*Metode Pembayaran disepakati via: <strong>{{ strtoupper($project->payment_method) }}</strong></em>
    </p>

    <div class="terms">
        <strong>SYARAT & KETENTUAN (WAJIB DIBACA):</strong>
        <ul>
            <li>Pengerjaan selesai per aplikasi/skripsi target <strong>Maksimal 7 Hari Kerja</strong>.</li>
            <li>Biaya yang tercantum di atas adalah Harga Fix/Bersih yang disepakati di awal.</li>
            <li><strong>Revisi Minor GRATIS maksimal 5x</strong> (Ubah warna, geser tombol, perbaiki teks).</li>
            <li><strong>Revisi Mayor / Perubahan Alur / Ganti Judul Skripsi Total</strong> di tengah jalan akan
                dikenakan biaya tambahan (Charge/Proyek Baru) sesuai tingkat kesulitan.</li>
            <li>Kerahasiaan data klien (terutama mahasiswa) dan <em>source code</em> terjamin 100%.</li>
            <li>Uang muka (DP) yang sudah masuk tidak dapat dikembalikan (Non-Refundable) jika klien membatalkan
                sepihak.</li>
            <li><em>Source Code Full</em> dan Database akan diberikan setelah <strong>Sisa Pembayaran dilunasi
                    100%</strong>.</li>
        </ul>
    </div>

    <div style="page-break-inside: avoid;">
        @include('components.pdf.signature')
    </div>

</body>

</html>
