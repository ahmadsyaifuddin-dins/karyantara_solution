@props(['disabled' => false, 'aiUrl'])

<div x-data="aiTextarea('{{ $aiUrl }}')" class="relative w-full">
    <textarea x-ref="aiInput" x-model="textContent" @input="hasEnhanced = false"
        :disabled="isAiLoading || {{ $disabled ? 'true' : 'false' }}" {!! $attributes->merge([
            'class' =>
                'border-gray-300 focus:border-[#1E293B] focus:ring-[#1E293B] rounded-md shadow-sm w-full pr-24 pb-10 disabled:bg-gray-100 disabled:text-gray-500 transition-colors',
            'rows' => 4,
        ]) !!}>{{ $slot }}</textarea>

    <div class="absolute bottom-3 right-3 flex items-center gap-2">

        <button type="button" x-show="hasEnhanced" @click="undo" x-transition x-cloak
            class="flex items-center justify-center px-2.5 h-8 rounded-md bg-gray-100 border border-gray-200 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gray-300 transition-all duration-300 shadow-sm text-xs font-semibold"
            title="Kembalikan ke teks aslimu">
            <i class="fa-solid fa-rotate-left mr-1.5"></i> Undo
        </button>

        <button type="button" @click="enhance" :disabled="isAiLoading"
            class="group flex items-center justify-center w-8 h-8 rounded-full bg-[#1E293B] text-amber-500 hover:bg-amber-500 hover:text-[#1E293B] focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#1E293B] transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed shadow-md"
            title="Rapikan dengan AI">
            <i class="fa-solid fa-wand-magic-sparkles text-sm" x-show="!isAiLoading"></i>

            <i class="fa-solid fa-circle-notch fa-spin text-sm" x-show="isAiLoading" style="display: none;"></i>
        </button>
    </div>
</div>
