<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('orders.index') }}" class="p-2 bg-white rounded-lg shadow-sm hover:bg-gray-50 transition-colors border border-gray-100">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Rincian Pesanan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 flex items-center p-4 text-green-800 bg-green-50 border-s-4 border-green-500 rounded-xl shadow-sm">
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100">
                <div class="bg-gray-50/50 p-8 border-b border-gray-100 flex flex-col md:flex-row justify-between gap-6">
                    <div>
                        <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-1">Nomor Pesanan</p>
                        <h3 class="text-3xl font-black text-gray-900">#{{ $order->id }}</h3>
                        <p class="text-sm text-gray-500 mt-1 font-medium">
                            {{ \Carbon\Carbon::parse($order->order_date)->format('d F Y') }}
                        </p>
                    </div>

                    <div class="flex flex-col md:items-end justify-center">
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Status Saat Ini</p>
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'confirmed' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'completed' => 'bg-green-100 text-green-700 border-green-200',
                                'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                            ];
                            $colorClass = $statusColors[strtolower($order->status)] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="px-4 py-1.5 rounded-full border text-xs font-black uppercase tracking-widest {{ $colorClass }}">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <div class="mb-10 bg-indigo-50/30 p-6 rounded-2xl border border-indigo-100">
                        <h4 class="text-sm font-bold text-indigo-900 mb-4 flex items-center">
                            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            Panel Kontrol Pesanan
                        </h4>

                        @if(auth()->user()->isAdmin())
                            <form action="{{ route('orders.update', $order) }}" method="POST" class="flex flex-wrap items-center gap-3">
                                @csrf
                                @method('PUT')
                                <select name="status" id="status" class="bg-white border-gray-200 text-sm font-bold text-gray-700 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 min-w-[150px]">
                                    <option value="pending" @selected($order->status=='pending')>Pending</option>
                                    <option value="confirmed" @selected($order->status=='confirmed')>Confirmed</option>
                                    <option value="completed" @selected($order->status=='completed')>Completed</option>
                                    <option value="cancelled" @selected($order->status=='cancelled')>Cancelled</option>
                                </select>
                                <button class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-black rounded-xl transition-all shadow-md shadow-indigo-100 uppercase tracking-widest">
                                    Simpan Perubahan
                                </button>
                            </form>
                        @elseif(!auth()->user()->isAdmin() && $order->status=='confirmed')
                            <form action="{{ route('orders.update', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed" />
                                <button class="w-full md:w-auto px-8 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-black rounded-xl transition-all shadow-lg shadow-green-100 uppercase tracking-widest">
                                    Konfirmasi Pesanan Diterima
                                </button>
                            </form>
                        @else
                            <p class="text-xs font-medium text-gray-500 italic italic">Tidak ada aksi yang tersedia untuk status pesanan ini.</p>
                        @endif
                    </div>

                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Daftar Item</h4>
                    <div class="overflow-hidden rounded-2xl border border-gray-100 mb-8">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Menu</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $item->menu->name }}</td>
                                        <td class="px-6 py-4 text-center text-sm font-medium text-gray-600">{{ $item->quantity }}x</td>
                                        <td class="px-6 py-4 text-right text-sm text-gray-500">Rp {{ number_format($item->price,0,',','.') }}</td>
                                        <td class="px-6 py-4 text-right text-sm font-black text-gray-900 italic">Rp {{ number_format($item->subtotal,0,',','.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50/50 font-black">
                                <tr>
                                    <td colspan="3" class="px-6 py-5 text-right text-gray-500 uppercase tracking-widest text-xs">Total Keseluruhan</td>
                                    <td class="px-6 py-5 text-right text-2xl text-indigo-600">
                                        Rp {{ number_format($order->total_amount,0,',','.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if(!auth()->user()->isAdmin() && $order->status=='pending')
                        <div class="mt-10 pt-6 border-t border-dashed border-gray-200">
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="group flex items-center text-red-500 hover:text-red-700 transition-colors">
                                    <div class="p-2 bg-red-50 rounded-lg group-hover:bg-red-100 me-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </div>
                                    <span class="text-sm font-bold uppercase tracking-widest">Batalkan Pesanan Ini</span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            
            <p class="mt-8 text-center text-gray-400 text-xs font-medium">
                Terima kasih telah melakukan pemesanan di platform kami.
            </p>
        </div>
    </div>
</x-app-layout>