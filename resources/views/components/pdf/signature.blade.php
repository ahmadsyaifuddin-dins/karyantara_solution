<table style="width: 100%; margin-top: 20px;">
    <tr>
        <td style="width: 40%; text-align: center; vertical-align: bottom;">
            @isset($project)
                <p style="margin-bottom: 5px; font-size: 11px; color: transparent;">Tanggal</p>
                <p style="margin-bottom: 50px; font-size: 11px;">Menyetujui,<br><strong>Klien / Pemesan</strong></p>
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
            <p style="margin-bottom: 5px; font-size: 11px;">Banjarmasin,
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
            <p style="margin-bottom: 50px; font-size: 11px;">Mengetahui,<br><strong>Pimpinan Operasional</strong></p>
            <p style="margin: 0; font-size: 11px; text-decoration: underline; font-weight: bold;">
                {{ Auth::user()->name }}</p>
            <p style="margin: 0; font-size: 11px;">ID: ADM-{{ Auth::user()->id }}</p>
        </td>
    </tr>
</table>
