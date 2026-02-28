@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block px-4 py-3 text-base font-bold text-[#1E293B] bg-amber-50 border-l-4 border-amber-500 transition'
            : 'block px-4 py-3 text-base font-medium text-gray-600 hover:text-[#1E293B] hover:bg-gray-50 border-l-4 border-transparent hover:border-amber-300 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
