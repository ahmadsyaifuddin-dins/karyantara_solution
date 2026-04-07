<table style="width: 100%; margin-top: 10px;">
    <tr>
        <td style="width: 40%; text-align: center; vertical-align: bottom;">
            @isset($project)
                <p style="margin-bottom: 5px; font-size: 11px; color: transparent;">Tanggal</p>
                <p style="margin-bottom: 5px; font-size: 11px;">Menyetujui,<br><strong>Klien / Pemesan</strong></p>

                <div style="margin: 10px 0;">
                    <img src="data:image/svg+xml;base64,{{ $qrCodeClient }}" alt="QR Klien">
                </div>

                <p
                    style="margin: 0; font-size: 11px; text-decoration: underline; font-weight: bold; text-transform: uppercase;">
                    {{ $project->client_name }}
                </p>
                <p style="margin: 0; font-size: 11px;">
                    {{ $project->client_type == 'mahasiswa' ? 'NPM: ' . ($project->npm ?? '-') : 'Instansi/Umum' }}
                </p>
            @endisset
        </td>

        <td style="width: 20%;"></td>

        <td style="width: 40%; text-align: center; vertical-align: bottom;">
            @php
                $adminName = Auth::user()->name;
                $adminRole = 'Pimpinan Operasional'; // Default

                if ($adminName === 'Ahmad Syaifuddin') {
                    $adminRole = 'Co-Founder & Chief Technology Officer';
                } elseif ($adminName === 'Abdan Mustaqim Wardana') {
                    $adminRole = 'Co-Founder & Chief Executive Officer';
                }
            @endphp

            <p style="margin-bottom: 5px; font-size: 11px;">Banjarmasin,
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
            <p style="margin-bottom: 5px; font-size: 11px;">Mengetahui,<br><strong>{{ $adminRole }}</strong></p>

            <div style="margin: 10px 0;">
                <img src="data:image/svg+xml;base64,{{ $qrCodeAdmin }}" alt="QR Admin">
            </div>

            <p
                style="margin: 0; font-size: 11px; text-decoration: underline; font-weight: bold; text-transform: uppercase;">
                {{ $adminName }}
            </p>
            <p style="margin: 0; font-size: 11px;">ID: ADM-{{ Auth::user()->id }}</p>
        </td>
    </tr>
</table>
