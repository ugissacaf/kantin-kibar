<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center">
                <span class="bg-indigo-600 text-white p-2 rounded-xl me-3 shadow-lg shadow-indigo-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </span>
                {{ __('Dashboard Overview') }}
            </h2>
            <div class="text-sm font-bold text-slate-400 uppercase tracking-widest">
                {{ now()->format('d M Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-3xl font-black text-slate-900">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-slate-500 mt-2 font-medium max-w-xl">Selamat datang di sistem manajemen Pre-Order. Pantau pesanan Anda dan kelola menu restoran dengan lebih efisien hari ini.</p>
                </div>
                <div class="absolute top-0 right-0 -translate-y-12 translate-x-12 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-60"></div>
            </div>

          

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                <a href="{{ route('menus.index') }}" class="group bg-indigo-600 p-8 rounded-[2rem] text-white shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all flex justify-between items-center">
                    <div>
                        <h4 class="text-xl font-black uppercase tracking-tight">Lihat Katalog Menu</h4>
                        <p class="text-indigo-100 text-sm mt-1">Pesan hidangan lezat hari ini</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full group-hover:translate-x-2 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>

                <a href="{{ route('orders.index') }}" class="group bg-slate-900 p-8 rounded-[2rem] text-white shadow-xl shadow-slate-100 hover:bg-black transition-all flex justify-between items-center">
                    <div>
                        <h4 class="text-xl font-black uppercase tracking-tight">Riwayat Pesanan</h4>
                        <p class="text-slate-400 text-sm mt-1">Cek status pengiriman & detail</p>
                    </div>
                    <div class="bg-white/10 p-3 rounded-full group-hover:translate-x-2 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout> 