<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Laporan - Karyantara Solution</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 font-sans">

    <div class="bg-white rounded-3xl shadow-xl max-w-md w-full overflow-hidden border border-gray-100">
        <div class="bg-blue-600 p-6 text-center">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg">
                <i class="fa-solid fa-file-shield text-4xl text-blue-600"></i>
            </div>
            <h2 class="text-white font-bold text-xl uppercase tracking-wider">Laporan Valid</h2>
            <p class="text-blue-100 text-sm mt-1">Dokumen Internal Karyantara Solution</p>
        </div>

        <div class="p-8 text-center">
            <h3 class="font-bold text-gray-800 text-lg mb-2">Laporan Rekapitulasi Proyek</h3>
            <p class="text-gray-500 text-sm mb-6">
                Dokumen fisik/digital yang Anda pegang saat ini adalah laporan sah yang dicetak dari sistem database
                utama kami pada tanggal:
            </p>

            <div
                class="bg-blue-50 text-blue-800 font-black text-xl py-3 px-4 rounded-xl inline-block border border-blue-100">
                {{ $formattedDate }}
            </div>

            <div class="mt-8 text-xs text-gray-400">
                <p>Otentikasi berhasil pada: {{ \Carbon\Carbon::now()->timezone('Asia/Makassar')->format('H:i:s') }}
                    WITA</p>
            </div>
        </div>
    </div>

</body>

</html>
