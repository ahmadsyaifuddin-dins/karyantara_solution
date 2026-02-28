@props(['name', 'currentImage' => null])

<div class="flex flex-col gap-2">
    @if ($currentImage)
        <div class="mb-2">
            <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
            <img src="{{ asset('uploads/testimonials/' . $currentImage) }}" alt="Preview"
                class="h-16 w-16 object-cover rounded-full border border-gray-300">
        </div>
    @endif
    <input type="file" name="{{ $name }}" accept="image/*" {!! $attributes->merge([
        'class' =>
            'block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#1E293B] file:text-white hover:file:bg-opacity-90 transition',
    ]) !!}>
</div>
