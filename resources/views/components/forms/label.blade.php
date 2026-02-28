@props(['value', 'required' => false])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-[#1E293B] mb-1']) }}>
    {{ $value ?? $slot }}
    @if ($required)
        <span class="text-red-500 ml-1">*</span>
    @endif
</label>
