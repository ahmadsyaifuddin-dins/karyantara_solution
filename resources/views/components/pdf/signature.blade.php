<table style="width: 100%; margin-top: 50px;">
    <tr>
        <td style="width: 60%;"></td>
        <td style="width: 40%; text-align: center;">
            <p style="margin-bottom: 5px; font-size: 12px;">Banjarmasin,
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
            <p style="margin-bottom: 70px; font-size: 12px;">Mengetahui,<br><strong>Pimpinan Operasional</strong></p>
            <p style="margin: 0; font-size: 12px; text-decoration: underline; font-weight: bold;">
                {{ Auth::user()->name }}</p>
            <p style="margin: 0; font-size: 12px;">NIP / ID: ADM-{{ Auth::user()->id }}</p>
        </td>
    </tr>
</table>
