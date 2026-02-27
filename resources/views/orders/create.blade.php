<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('menus.index') }}" class="p-2 bg-white rounded-lg shadow-sm hover:bg-gray-50 transition-colors border border-gray-100">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Buat Pre-order') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 p-4 text-red-700 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 me-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span class="font-bold">Mohon periksa kembali:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm opacity-90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center gap-4">
                    <div class="md:w-1/4">
                        <label for="order_date" class="block font-bold text-gray-700 uppercase text-xs tracking-widest">Tanggal Pemesanan</label>
                        <p class="text-xs text-gray-400 mt-1 italic italic">Pilih tanggal untuk menu ini</p>
                    </div>
                    <div class="md:w-1/3">
                        <input type="date" id="order_date" name="order_date" 
                            value="{{ $date ?? old('order_date') }}" 
                            class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm font-semibold" 
                            required>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-2xl">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Menu Makanan</th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-4 text-center text-xs font-black text-gray-500 uppercase tracking-wider">Jumlah Pesanan</th>
                                    <th class="px-6 py-4 text-right text-xs font-black text-gray-500 uppercase tracking-wider">Sisa Kuota</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($menus as $menu)
                                    <tr class="hover:bg-indigo-50/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                                    {{ substr($menu->name, 0, 1) }}
                                                </div>
                                                <div class="ms-4">
                                                    <span class="text-sm font-bold text-gray-900 block">{{ $menu->name }}</span>
                                                    <span class="text-[10px] text-gray-400 uppercase tracking-tighter italic">Tersedia Hari Ini</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-gray-700">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex justify-center">
                                                <div class="relative flex items-center max-w-[8rem]">
                                                    <input type="number" 
                                                        name="items[{{ $loop->index }}][quantity]" 
                                                        min="0" 
                                                        max="{{ $menu->remaining_quota }}" 
                                                        value="0" 
                                                        class="bg-gray-50 border border-gray-200 h-10 text-center text-gray-900 text-sm font-bold rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" 
                                                        required />
                                                    <input type="hidden" name="items[{{ $loop->index }}][menu_id]" value="{{ $menu->id }}" />
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $menu->remaining_quota <= 5 ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-green-50 text-green-700 border border-green-100' }}">
                                                {{ $menu->remaining_quota }} <span class="ms-1 font-normal opacity-70 italic">porsi</span>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="inline-flex items-center px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl transition-all shadow-lg shadow-indigo-100 uppercase tracking-widest text-sm group">
                        <svg class="w-5 h-5 me-2 transform group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Konfirmasi Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>