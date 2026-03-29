<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Estimasi Penawaran - Karyantara</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #1E293B;
        }

        .title-section {
            text-align: center;
            margin: 25px 0 15px 0;
        }

        .title-section h3 {
            margin: 0;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
            color: #1E293B;
        }

        .content {
            margin: 0 10px;
            line-height: 1.5;
        }

        table.table-details {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .table-details th,
        .table-details td {
            border: 1px solid #CBD5E1;
            padding: 10px 12px;
            text-align: left;
        }

        .table-details th {
            background-color: #F8FAFC;
            color: #475569;
            font-weight: bold;
            width: 35%;
        }

        .price-box {
            background-color: #FFFBEB;
            border: 1.5px dashed #F59E0B;
            padding: 15px;
            text-align: center;
            margin-top: 20px;
            border-radius: 6px;
        }

        .price-text {
            font-size: 18px;
            font-weight: bold;
            color: #B45309;
            margin: 8px 0;
            display: block;
        }

        .notes {
            font-size: 10px;
            color: #64748B;
            margin-top: 5px;
            font-style: italic;
        }
    </style>
</head>

<body>

    @include('components.pdf.header')

    <div class="title-section">
        <h3>Dokumen Estimasi Penawaran Layanan</h3>
    </div>

    <div class="content">
        <p>Kepada Yth. <strong>{{ $project->client_name }}</strong>,</p>
        <p>Berdasarkan hasil diskusi dan analisis awal sistem/kebutuhan yang telah disampaikan, berikut adalah rincian
            estimasi biaya pengerjaan dari Karyantara Solution:</p>

        <table class="table-details">
            <tr>
                <th>Jenis Layanan / Paket</th>
                <td>{{ $data['paket_nama'] }}</td>
            </tr>
            <tr>
                <th>Sumber Kode Aplikasi</th>
                <td>{{ $data['sumber_app'] == 'internal' ? 'Dibuat oleh Karyantara Solution' : 'Buatan Luar (Legacy Code / Bawa Sendiri)' }}
                </td>
            </tr>
            <tr>
                <th>Volume Pekerjaan / Kesulitan</th>
                <td>{{ ucfirst($data['kesulitan']) }}</td>
            </tr>
        </table>

        <div class="price-box">
            Rentang Estimasi Biaya (Investasi):
            <span class="price-text">
                Rp {{ number_format($data['min_price'], 0, ',', '.') }} - Rp
                {{ number_format($data['max_price'], 0, ',', '.') }}
            </span>
            <div class="notes">*Catatan: Harga final (fix) akan ditentukan setelah tim developer Karyantara melakukan
                pengecekan detail terhadap sistem dan list revisi secara menyeluruh.</div>
        </div>

        <p style="margin-top: 20px; font-size: 11px;">Demikian estimasi penawaran ini kami sampaikan. Jika ada pertanyaan
            lebih lanjut, silakan hubungi kontak WhatsApp yang tertera pada kop surat di atas.</p>
    </div>

    <br><br>

    @include('components.pdf.signature')

</body>

</html>
