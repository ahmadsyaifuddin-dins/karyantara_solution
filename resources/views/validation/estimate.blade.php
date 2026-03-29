<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Validasi Dokumen - Karyantara Solution</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('logo/logo_transparent.jpg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="bg-[#1E293B] p-6 text-center relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-500 rounded-full opacity-20 blur-xl"></div>

            <img src="{{ asset('logo/logo_transparent.jpg') }}" alt="Logo Karyantara"
                class="w-16 h-16 mx-auto rounded-full border-2 border-amber-500 mb-3 relative z-10 bg-white object-contain">

            <h1 class="text-xl font-bold text-white relative z-10">Karyantara Solution</h1>
            <p class="text-amber-400 text-sm font-medium relative z-10">Validasi Dokumen Sistem</p>
        </div>

        <div class="p-8 text-center">
            <div
                class="w-20 h-20 mx-auto bg-emerald-100 rounded-full flex items-center justify-center mb-6 shadow-sm border-4 border-emerald-50">
                <i class="fa-solid fa-file-circle-check text-4xl text-emerald-500"></i>
            </div>

            <h2 class="text-2xl font-bold text-[#1E293B] mb-2">Dokumen Valid!</h2>

            <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                QR Code yang Anda pindai adalah sah dan dikenali oleh sistem kami. Ini adalah dokumen <strong
                    class="text-[#1E293B]">Estimasi Penawaran</strong> yang dibuat secara resmi oleh Admin Karyantara
                Solution.
            </p>

            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 mb-6 flex flex-col items-center">
                <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Nomor Referensi</span>
                <span class="text-lg font-bold text-[#1E293B] tracking-widest font-mono">{{ $id }}</span>
            </div>

            <a href="{{ route('home') }}"
                class="inline-flex justify-center items-center w-full bg-amber-500 hover:bg-amber-600 text-[#1E293B] font-bold py-3 px-4 rounded-xl transition-all shadow-[0_4px_14px_0_rgba(245,158,11,0.39)]">
                Kembali ke Beranda
            </a>
        </div>

        <div class="bg-gray-50 p-4 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">
                &copy; 2026-{{ date('Y') }} Karyantara Solution. All rights reserved.
            </p>
        </div>
    </div>

</body>

</html>
