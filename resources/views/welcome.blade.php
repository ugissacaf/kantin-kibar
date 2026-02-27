<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pre-Order System</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,800" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { 
                font-family: 'Instrument Sans', sans-serif; 
                background-color: #FFFFFF; /* Murni Putih */
            }
        </style>
    </head>
    <body class="text-slate-900 min-h-screen flex flex-col">
        
        <header class="w-full max-w-7xl mx-auto px-6 py-10 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <div class="bg-indigo-600 w-9 h-9 rounded-xl flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span class="font-extrabold tracking-tighter text-xl text-slate-900 uppercase">Pre-Order</span>
            </div>

            @if (Route::has('login'))
                <nav class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-slate-100 text-slate-900 rounded-2xl text-sm font-bold hover:bg-slate-200 transition-all uppercase tracking-widest text-[10px]">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors uppercase tracking-widest text-[10px]">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-indigo-600 text-white rounded-2xl text-sm font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all uppercase tracking-widest text-[10px]">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="flex-grow flex items-center justify-center px-6">
            <div class="max-w-3xl text-center">
                <div class="space-y-6">
                    <h1 class="text-5xl lg:text-7xl font-black tracking-tight text-slate-900 leading-[0.9]">
                        Pesan Menu <br> <span class="text-indigo-600">Lebih Mudah</span>.
                    </h1>
                    <p class="text-slate-400 text-lg lg:text-xl font-medium max-w-md mx-auto leading-relaxed">
                        Platform manajemen pemesanan makanan harian yang efisien dan terorganisir.
                    </p>
                    
                    <div class="pt-8">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-10 py-5 bg-indigo-600 text-white font-black rounded-3xl shadow-2xl shadow-indigo-100 hover:bg-indigo-700 transition-all uppercase tracking-[0.1em] text-sm">
                                Buka Aplikasi
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-10 py-5 bg-indigo-600 text-white font-black rounded-3xl shadow-2xl shadow-indigo-100 hover:bg-indigo-700 transition-all uppercase tracking-[0.1em] text-sm">
                                Masuk Sekarang
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </main>

        <footer class="py-10 text-center">
            <p class="text-[11px] text-slate-300 font-bold uppercase tracking-[0.2em]">
                &copy; {{ date('Y') }} Pre-Order System. All rights reserved.
            </p>
        </footer>
    </body>
</html>