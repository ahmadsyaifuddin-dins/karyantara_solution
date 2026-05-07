@php
    $manifestPath = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/') . '/build/manifest.json';
    if (!file_exists($manifestPath)) {
        $manifestPath = dirname(base_path()) . '/build/manifest.json';
    }
    if (!file_exists($manifestPath)) {
        $manifestPath = public_path('build/manifest.json');
    }

    $cssFile = '';
    $jsFile = '';

    if (file_exists($manifestPath)) {
        $manifest = json_decode(file_get_contents($manifestPath), true);
        $cssFile = $manifest['resources/css/app.css']['file'] ?? '';
        $jsFile = $manifest['resources/js/app.js']['file'] ?? '';
    }
@endphp

@if ($cssFile)
    <link rel="stylesheet" href="/build/{{ $cssFile }}">
@endif

@if ($jsFile)
    <script src="/build/{{ $jsFile }}" defer></script>
@endif
