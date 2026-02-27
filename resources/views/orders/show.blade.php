<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Order') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p><strong>ID:</strong> {{ $order->id }}</p>
                <p><strong>Tanggal:</strong> {{ $order->order_date }}</p>
                <p><strong>Status:</strong> {{ $order->status }}</p>
                <p><strong>Total:</strong> Rp {{ number_format($order->total_amount,0,',','.') }}</p>
                @if(auth()->user()->isAdmin())
                    <form action="{{ route('orders.update', $order) }}" method="POST" class="mb-4">
                        @csrf
                        @method('PUT')
                        <label for="status">Ubah status:</label>
                        <select name="status" id="status" class="border rounded">
                            <option value="pending" @selected($order->status=='pending')>pending</option>
                            <option value="confirmed" @selected($order->status=='confirmed')>confirmed</option>
                            <option value="completed" @selected($order->status=='completed')>completed</option>
                            <option value="cancelled" @selected($order->status=='cancelled')>cancelled</option>
                        </select>
                        <button class="px-2 py-1 bg-blue-600 text-white rounded">Simpan</button>
                    </form>
                @elseif(!auth()->user()->isAdmin() && $order->status=='confirmed')
                    <!-- user can mark order as completed -->
                    <form action="{{ route('orders.update', $order) }}" method="POST" class="mb-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="completed" />
                        <button class="px-2 py-1 bg-green-600 text-white rounded">Tandai Selesai</button>
                    </form>
                @endif

                <h3 class="font-semibold mt-4">Item:</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4">{{ $item->menu->name }}</td>
                                <td class="px-6 py-4">{{ $item->quantity }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($item->price,0,',','.') }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($item->subtotal,0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    @if(!auth()->user()->isAdmin() && $order->status=='pending')
                        <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Yakin batalkan order?');">
                            @csrf
                            @method('DELETE')
                            <button class="px-4 py-2 bg-red-600 text-white rounded">Batal Pesan</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>