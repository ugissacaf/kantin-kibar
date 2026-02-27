<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center">
                <span class="bg-indigo-100 p-2 rounded-lg me-3">📅</span>
                {{ __('Menu Tersedia') }}
            </h2>
            
            <form method="GET" class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                <label for="date" class="text-xs font-bold uppercase text-gray-500 px-2 tracking-wider">Tanggal</label>
                <input type="date" id="date" name="date" value="{{ $date }}" 
                    class="border-none focus:ring-0 text-sm font-semibold text-gray-700 bg-transparent">
                <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition-all shadow-md shadow-indigo-100 uppercase tracking-widest">
                    Lihat
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Item Menu</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider text-center">Sisa Kuota</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($menus as $menu)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-500 font-bold text-xs shadow-inner">
                                                {{ substr($menu->name, 0, 1) }}
                                            </div>
                                            <div class="ms-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $menu->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-black text-gray-900">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $menu->remaining_quota > 0 ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $menu->remaining_quota }} porsi
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        @if($menu->remaining_quota > 0)
                                            <span class="inline-flex items-center text-green-600 text-xs font-black uppercase tracking-widest">
                                                <span class="h-2 w-2 bg-green-500 rounded-full me-2 animate-pulse"></span>
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="inline-flex items-center text-red-500 text-xs font-black uppercase tracking-widest opacity-60">
                                                <span class="h-2 w-2 bg-red-500 rounded-full me-2"></span>
                                                Habis
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">
                                        Belum ada menu yang didaftarkan untuk tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('orders.create', ['date' => $date]) }}" 
                   class="inline-flex items-center px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-black rounded-2xl transition-all shadow-lg shadow-green-100 group">
                    <svg class="w-5 h-5 me-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    {{ __('BUAT PRE-ORDER') }}
                </a>
            </div>

        </div>
    </div>
</x-app-layout>