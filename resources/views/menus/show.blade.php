<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('menus.index') }}" class="p-2 bg-white rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Detail Menu') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100">
                <div class="flex flex-col md:flex-row">
                    
                    <div class="md:w-1/2 bg-gray-50 flex items-center justify-center p-4">
                        @if($menu->image)
                            <img src="{{ asset('storage/'.$menu->image) }}" 
                                 class="w-full h-80 md:h-[450px] object-cover rounded-2xl shadow-lg transform hover:scale-[1.02] transition-transform duration-300" 
                                 alt="{{ $menu->name }}" />
                        @else
                            <div class="w-full h-80 md:h-[450px] bg-gray-200 rounded-2xl flex items-center justify-center">
                                <span class="text-6xl italic opacity-20">No Image</span>
                            </div>
                        @endif
                    </div>

                    <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <h1 class="text-3xl font-black text-gray-900 leading-tight">{{ $menu->name }}</h1>
                                @if($menu->is_available)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-black uppercase tracking-wider rounded-full border border-green-200">
                                        {{ __('Tersedia') }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-black uppercase tracking-wider rounded-full border border-red-200">
                                        {{ __('Kosong') }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-gray-600 leading-relaxed mb-8 text-lg italic">
                                "{{ $menu->description ?? 'Tidak ada deskripsi untuk menu ini.' }}"
                            </p>

                            <div class="space-y-4 border-t border-gray-100 pt-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400 font-semibold uppercase text-xs tracking-widest">Harga Satuan</span>
                                    <span class="text-3xl font-black text-indigo-600">
                                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <span class="text-sm font-bold text-gray-600 uppercase">Kuota Harian</span>
                                    </div>
                                    <span class="text-lg font-black text-gray-800">{{ $menu->daily_quota }} <span class="text-sm font-normal text-gray-500">Porsi</span></span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex gap-3">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('menus.edit', $menu) }}" class="flex-1 bg-amber-400 hover:bg-amber-500 text-white font-bold py-4 rounded-2xl text-center shadow-lg shadow-amber-100 transition-all">
                                    Edit Menu
                                </a>
                            @else
                                <a href="{{ route('orders.create', ['menu_id' => $menu->id]) }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl text-center shadow-lg shadow-indigo-100 transition-all">
                                    Pesan Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>