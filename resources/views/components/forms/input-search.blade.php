@props([
    'disabled' => false,
    'placeholder' => 'Cari...',
    'alpineModel' => null, // Prop khusus untuk mengikat x-model Alpine.js
])

<div class="relative w-full">
    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>

    <input {{ $disabled ? 'disabled' : '' }} @if ($alpineModel) x-model="{{ $alpineModel }}" @endif
        placeholder="{{ $placeholder }}" {!! $attributes->merge([
            'type' => 'text',
            'class' =>
                'border-gray-300 focus:border-[#1E293B] focus:ring-[#1E293B] text-gray-900 text-sm rounded-xl block w-full pl-11 pr-11 p-3.5 shadow-sm transition-all',
        ]) !!}>

    @if ($alpineModel)
        <button x-cloak x-show="{{ $alpineModel }} !== ''" @click="{{ $alpineModel }} = ''" type="button"
            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-red-500 transition focus:outline-none">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    @endif
</div>
