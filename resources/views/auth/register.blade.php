<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black text-gray-800 tracking-tight">
            Buat Akun Baru ✨
        </h2>
        <p class="text-gray-500 mt-2 font-medium">Bergabunglah dengan kami dan nikmati menu lezat setiap hari.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold text-gray-700 ms-1" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <x-text-input id="name" 
                    class="block w-full pl-11 py-3 bg-gray-50 border-gray-200 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 rounded-2xl shadow-sm transition-all" 
                    type="text" 
                    name="name" 
                    :value="old('name')" 
                    required 
                    autofocus 
                    placeholder="Nama lengkap Anda"
                    autocomplete="name" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-gray-700 ms-1" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                </div>
                <x-text-input id="email" 
                    class="block w-full pl-11 py-3 bg-gray-50 border-gray-200 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 rounded-2xl shadow-sm transition-all" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    placeholder="nama@email.com"
                    autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" class="font-bold text-gray-700 ms-1" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <x-text-input id="password" 
                    class="block w-full pl-11 py-3 bg-gray-50 border-gray-200 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 rounded-2xl shadow-sm transition-all"
                    type="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    required autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="font-bold text-gray-700 ms-1" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <x-text-input id="password_confirmation" 
                    class="block w-full pl-11 py-3 bg-gray-50 border-gray-200 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 rounded-2xl shadow-sm transition-all"
                    type="password"
                    name="password_confirmation" 
                    placeholder="Ulangi kata sandi"
                    required autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4 flex flex-col space-y-4">
            <button type="submit" class="w-full flex justify-center items-center py-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-black rounded-2xl transition-all shadow-lg shadow-indigo-100 uppercase tracking-widest active:scale-[0.98]">
                {{ __('Daftar Sekarang') }}
                <svg class="w-5 h-5 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </button>

            <div class="text-center">
                <p class="text-sm text-gray-500 font-medium">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-indigo-600 font-black hover:underline underline-offset-4 tracking-tight">Login di sini</a>
                </p>
            </div>
        </div>
    </form>
</x-guest-layout>