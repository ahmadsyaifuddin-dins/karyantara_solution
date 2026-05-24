@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block w-full pl-3 pr-4 py-3 border-l-4 border-amber-500 text-left text-base font-medium text-amber-500 bg-amber-500/10 focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-3 border-l-4 border-transparent text-left text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800 hover:border-slate-500 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
