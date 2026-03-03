<table
    style="width: 100%; border-bottom: 3px solid #1E293B; padding-bottom: 12px; margin-bottom: 24px; font-family: Helvetica, Arial, sans-serif;">
    <tr>
        <td style="width: 20%; text-align: left; vertical-align: middle;">
            <img src="{{ public_path('logo/logo_transparent.png') }}" alt="Logo Karyantara Solution"
                style="max-width: 90px; height: auto;">
        </td>

        <td style="width: 60%; text-align: center; vertical-align: middle; line-height: 1.4;">
            <h2
                style="margin: 0; font-size: 22px; font-weight: 800; text-transform: uppercase; color: #1E293B; letter-spacing: 1px; font-family: Helvetica, Arial, sans-serif;">
                KARYANTARA SOLUTION
            </h2>
            <h3
                style="margin: 2px 0 8px 0; font-size: 13px; font-weight: 600; color: #64748B; letter-spacing: 0.5px; text-transform: uppercase; font-family: Helvetica, Arial, sans-serif;">
                IT Consultant & Software Development
            </h3>

            <p
                style="margin: 0; font-size: 11px; font-weight: normal; color: #475569; font-family: Helvetica, Arial, sans-serif;">
                Anjir Muara, Barito Kuala - Banjarmasin, Kalimantan Selatan<br>
                Email: karyantarasolution@gmail.com | WhatsApp: 0851-2423-7625 <br>
                Website: https://karyantara-solution.kesug.com
            </p>
        </td>

        <td style="width: 20%; text-align: right; vertical-align: top;">
            <div style="font-size: 9px; color: #64748B; font-family: Helvetica, Arial, sans-serif; line-height: 1.3;">
                <span style="font-weight: bold; color: #1E293B;">Dicetak pada:</span><br>
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}<br>
                Pukul {{ \Carbon\Carbon::now()->format('H:i') }} WITA
            </div>
        </td>
    </tr>
</table>
