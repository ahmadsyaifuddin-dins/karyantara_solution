@props(['setting', 'title', 'description'])

@if (isset($setting))
    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
        <div class="pr-4">
            <p class="font-bold text-[#1E293B] text-base">{{ $title }}</p>
            <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                {!! $description !!}
            </p>
        </div>

        <div x-data="settingToggle({{ $setting->value === '1' ? 'true' : 'false' }}, '{{ route('admin.settings.toggle', $setting->id) }}')" class="ml-6 flex-shrink-0">
            <button type="button" @click="toggleSetting" :disabled="isLoading"
                :class="isActive ? 'bg-amber-500' : 'bg-gray-300'"
                class="relative inline-flex h-7 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 disabled:opacity-50">

                <span aria-hidden="true" :class="isActive ? 'translate-x-7' : 'translate-x-0'"
                    class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
                </span>
            </button>
        </div>
    </div>
@endif
