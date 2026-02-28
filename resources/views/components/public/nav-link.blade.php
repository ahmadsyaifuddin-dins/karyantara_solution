@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'text-[#1E293B] font-bold border-b-2 border-amber-500 py-1 transition duration-150 ease-in-out'
            : 'text-gray-600 hover:text-[#1E293B] font-medium border-b-2 border-transparent hover:border-amber-500 py-1 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
