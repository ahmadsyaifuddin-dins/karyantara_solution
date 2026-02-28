@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-300 focus:border-[#1E293B] focus:ring-[#1E293B] rounded-md shadow-sm w-full',
]) !!}>{{ $slot }}</textarea>
