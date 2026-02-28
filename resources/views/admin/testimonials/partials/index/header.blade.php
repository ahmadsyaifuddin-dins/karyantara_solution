<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h2 class="font-semibold text-xl text-[#1E293B] leading-tight">
        {{ __('Daftar Testimonial') }}
    </h2>

    <div class="flex items-center gap-4">
        <form action="{{ route('admin.testimonials.toggle-setting') }}" method="POST"
            class="flex items-center bg-white px-3 py-1.5 rounded-md shadow-sm border border-gray-200">
            @csrf
            <span class="text-xs font-bold text-gray-600 mr-3 uppercase tracking-wider">Auto-Publish Guest:</span>
            <label for="auto_approve_toggle" class="flex items-center cursor-pointer">
                <div class="relative">
                    <input type="hidden" name="auto_approve" value="0">
                    <input type="checkbox" id="auto_approve_toggle" name="auto_approve" value="1" class="sr-only"
                        onchange="this.form.submit()" {{ $autoApproveSetting == '1' ? 'checked' : '' }}>
                    <div
                        class="block {{ $autoApproveSetting == '1' ? 'bg-amber-500' : 'bg-gray-300' }} w-10 h-6 rounded-full transition-colors duration-300">
                    </div>
                    <div
                        class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-300 {{ $autoApproveSetting == '1' ? 'transform translate-x-4' : '' }}">
                    </div>
                </div>
                <div
                    class="ml-2 text-sm font-semibold {{ $autoApproveSetting == '1' ? 'text-amber-600' : 'text-gray-500' }}">
                    {{ $autoApproveSetting == '1' ? 'ON' : 'OFF' }}
                </div>
            </label>
        </form>

        <a href="{{ route('admin.testimonials.create') }}"
            class="bg-[#1E293B] text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition text-sm font-semibold shadow-sm whitespace-nowrap">
            <i class="fa-solid fa-plus mr-1"></i> Tambah Data
        </a>
    </div>
</div>
