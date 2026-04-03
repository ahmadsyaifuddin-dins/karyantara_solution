<div style="font-family: sans-serif; color: #1E293B;">
    <h2>Halo Tim Karyantara Solution,</h2>
    <p>Anda diundang untuk menghadiri rapat <strong>{{ $meeting->title }}</strong>.</p>

    <table style="text-align: left; margin-bottom: 20px;">
        <tr>
            <th style="padding-right: 15px;">Tipe Rapat</th>
            <td>: {{ $meeting->type }}</td>
        </tr>
        <tr>
            <th>Waktu</th>
            <td>: {{ $meeting->start_time->format('d M Y, H:i') }} WITA</td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td>: {{ $meeting->location }}</td>
        </tr>
    </table>

    <p style="padding: 15px; background-color: #f8fafc; border-left: 4px solid #f59e0b; border-radius: 4px;">
        <em>Silakan gunakan tombol <strong>Yes / No / Maybe (Ya / Tidak / Mungkin)</strong> pada bagian atas email ini
            untuk mengonfirmasi kehadiran Anda dan menambahkan jadwal ini ke Kalender Anda.</em>
    </p>

    <p>Terima kasih,<br>Sistem Manajemen Karyantara Solution</p>
</div>
