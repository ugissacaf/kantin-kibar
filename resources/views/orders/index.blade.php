<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center">
                <span class="bg-indigo-100 p-2 rounded-lg me-3">📋</span>
                {{ __('Riwayat Pemesanan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 flex items-center p-4 text-green-800 bg-green-50 border-s-4 border-green-500 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 me-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">ID Order</th>
                                @if(auth()->user()->isAdmin())
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                @endif
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Tanggal Ambil</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider text-center">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Total Bayar</th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold text-indigo-600">#{{ $order->id }}</span>
                                    </td>
                                    
                                    @if(auth()->user()->isAdmin())
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600 shadow-inner">
                                                    {{ strtoupper(substr($order->user->name, 0, 2)) }}
                                                </div>
                                                <span class="ms-3 text-sm font-medium text-gray-700">{{ $order->user->name }}</span>
                                            </div>
                                        </td>
                                    @endif

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-semibold italic">
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                                                'completed' => 'bg-green-50 text-green-700 border-green-100',
                                                'cancelled' => 'bg-red-50 text-red-700 border-red-100',
                                            ];
                                            $currentClass = $statusClasses[strtolower($order->status)] ?? 'bg-gray-50 text-gray-700 border-gray-100';
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-black rounded-full border {{ $currentClass }} uppercase tracking-widest">
                                            {{ $order->status }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-black text-gray-900 italic">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('orders.show', $order) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 transition-all shadow-sm">
                                            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">
                                        Belum ada data pesanan yang tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 shadow-sm rounded-xl">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>