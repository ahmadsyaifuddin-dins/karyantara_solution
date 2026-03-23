<section>
    <header>
        <h2 class="text-lg font-medium text-[#1E293B]">
            Pengaturan Musik Latar
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Atur apakah sistem harus memutar musik latar secara otomatis saat Anda masuk ke halaman admin. Pilihan lagu
            akan menyesuaikan dengan halaman yang sedang dibuka.
        </p>
    </header>

    <form method="post" action="{{ route('profile.music.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="flex items-center">
            <label for="autoplay_music" class="inline-flex items-center cursor-pointer">
                <input type="checkbox" id="autoplay_music" name="autoplay_music" value="1" class="sr-only peer"
                    {{ $user->autoplay_music ? 'checked' : '' }}>
                <div
                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500">
                </div>
                <span class="ms-3 text-sm font-medium text-gray-700">Putar Otomatis Musik Latar (Autoplay)</span>
            </label>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-[#1E293B] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Simpan Pengaturan
            </button>

            @if (session('status') === 'music-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-amber-600 font-medium">
                    <i class="fa-solid fa-check-circle mr-1"></i> Tersimpan.
                </p>

                <script>
                    localStorage.removeItem('karyantara_music_playing');
                </script>
            @endif
        </div>
    </form>
</section>
