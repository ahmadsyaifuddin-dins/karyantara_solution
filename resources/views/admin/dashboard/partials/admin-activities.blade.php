<div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
    <h3 class="font-bold text-[#1E293B]"><i class="fa-solid fa-users-viewfinder text-blue-500 mr-2"></i> Aktivitas Admin
    </h3>
</div>

<div class="p-6 space-y-5">
    @foreach ($onlineAdmins ?? [] as $admin)
        @php
            $isOnline = false;
            $lastSeenText = 'Belum pernah login';

            if ($admin->last_seen) {
                $lastActivity = \Carbon\Carbon::createFromTimestamp($admin->last_seen);
                $isOnline = $lastActivity->diffInMinutes(now()) <= 15;
                $lastSeenText = $isOnline ? 'Sedang Online' : $lastActivity->locale('id')->diffForHumans();
            }
        @endphp

        <div class="flex items-center gap-4">
            <div class="relative">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=random&color=fff"
                    alt="Avatar" class="w-10 h-10 rounded-full shadow-sm">
                <span
                    class="absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-white {{ $isOnline ? 'bg-green-500' : 'bg-gray-300' }}"></span>
            </div>

            <div class="flex-1">
                <h4 class="text-sm font-bold text-[#1E293B] leading-tight">
                    {{ $admin->name }}
                    @if (Auth::id() == $admin->id)
                        <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded ml-1">Anda</span>
                    @endif
                </h4>
                <p class="text-xs {{ $isOnline ? 'text-green-600 font-medium' : 'text-gray-400' }} mt-0.5">
                    {{ $lastSeenText }}
                </p>
            </div>
        </div>
    @endforeach
</div>
