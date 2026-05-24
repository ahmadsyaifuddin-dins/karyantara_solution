@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-amber-500 border-b-2 border-amber-500 focus:outline-none transition duration-150 ease-in-out h-full'
            : 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-slate-300 border-b-2 border-transparent hover:text-white hover:border-slate-500 focus:outline-none transition duration-150 ease-in-out h-full';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
