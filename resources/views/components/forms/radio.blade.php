@props(['disabled' => false])

<input type="radio" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'text-[#1E293B] focus:ring-[#1E293B] border-gray-300 shadow-sm cursor-pointer',
]) !!}>
