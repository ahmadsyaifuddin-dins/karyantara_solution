<table
    style="width: 100%; border-bottom: 3px solid #1E293B; padding-bottom: 8px; margin-bottom: 12px; font-family: Helvetica, Arial, sans-serif;">
    <tr>
        <td style="width: 20%; text-align: left; vertical-align: middle;">
            <img src="{{ public_path('logo/logo_transparent.jpg') }}" alt="Logo Karyantara Solution"
                style="max-width: 80px; height: auto;">
        </td>

        <td style="width: 90%; text-align: center; vertical-align: middle; line-height: 1.1;">
            <h2
                style="margin: 0; font-size: 20px; font-weight: 800; text-transform: uppercase; color: #1E293B; letter-spacing: 1px; font-family: Helvetica, Arial, sans-serif;">
                KARYANTARA SOLUTION
            </h2>
            <h3
                style="margin: 2px 0 6px 0; font-size: 12px; font-weight: 600; color: #64748B; letter-spacing: 0.5px; text-transform: uppercase; font-family: Helvetica, Arial, sans-serif;">
                IT Consultant & Software Development
            </h3>

            <p
                style="margin: 0; font-size: 10px; font-weight: normal; color: #475569; font-family: Helvetica, Arial, sans-serif;">
                Anjir Muara, Barito Kuala - Banjarmasin, Kalimantan Selatan<br>
                Email: karyantarasolution@gmail.com | WhatsApp: 0851-2423-7625 <br>
                Website: karyantara-solution.kesug.com
            </p>
        </td>

        <td style="width: 20%; text-align: right; vertical-align: top;">
            @php
                if (isset($project)) {
                    $securityHash = substr(md5($project->id . config('app.key')), 0, 8);
                    $qrUrl = route('validate.invoice', ['id' => $project->id, 'hash' => $securityHash]);
                } else {
                    $tanggal = date('Y-m-d');
                    $securityHash = substr(md5($tanggal . config('app.key')), 0, 8);
                    $qrUrl = route('validate.rekap', ['date' => $tanggal, 'hash' => $securityHash]);
                }
            @endphp

            <img src="data:image/svg+xml;base64, {!! base64_encode(QrCode::format('svg')->size(60)->margin(0)->generate($qrUrl)) !!}" alt="QR Validasi"
                style="max-width: 60px; height: auto; margin-bottom: 4px;">

            <div style="font-size: 8px; color: #64748B; font-family: Helvetica, Arial, sans-serif; line-height: 1.2;">
                <span style="font-weight: bold; color: #1E293B;">SCAN VALIDASI</span><br>
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d M Y, H:i') }}
            </div>
        </td>
    </tr>
</table>
