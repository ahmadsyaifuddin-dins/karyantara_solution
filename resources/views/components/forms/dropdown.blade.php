@props(['disabled' => false, 'searchable' => false])

@if ($searchable)
    <div x-data="searchableDropdown()" class="relative w-full" wire:ignore>
        <select x-ref="selectNode" {{ $disabled ? 'disabled' : '' }} {!! $attributes !!}>
            {{ $slot }}
        </select>
    </div>
@else
    <select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' => 'border-gray-300 focus:border-[#1E293B] focus:ring-[#1E293B] rounded-md shadow-sm w-full',
    ]) !!}>
        {{ $slot }}
    </select>
@endif
