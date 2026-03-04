<x-guest-layout>
    <div class="text-center mb-8">
        <img src="{{ asset('logo/logo_transparent.jpg') }}" alt="Logo Karyantara Solution"
            class="w-24 h-auto mx-auto mb-3 drop-shadow-sm">
        <h2 class="text-3xl font-black text-gray-800 tracking-tight uppercase">KARYANTARA</h2>
        <p class="text-sm text-gray-500 mt-1">IT Consultant & Software Development</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block font-medium text-sm text-gray-700 mb-1.5">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                autocomplete="username"
                class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2f3573] focus:border-[#2f3573] transition-colors text-gray-800"
                placeholder="Masukkan email Anda">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block font-medium text-sm text-gray-700 mb-1.5">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2f3573] focus:border-[#2f3573] transition-colors text-gray-800"
                placeholder="Masukkan kata sandi">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-[#2f3573] shadow-sm focus:ring-[#2f3573]" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-[#2f3573] hover:text-indigo-800 hover:underline transition-colors font-medium"
                    href="{{ route('password.request') }}">
                    Lupa sandi?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full flex justify-center items-center bg-[#2f3573] hover:bg-indigo-900 text-white font-semibold py-3 px-4 rounded-lg shadow-md transition-all active:scale-[0.98]">
                Masuk Aplikasi
            </button>
        </div>
    </form>
</x-guest-layout>
