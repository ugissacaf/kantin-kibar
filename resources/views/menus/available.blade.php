<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu Tersedia') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" class="mb-4">
                <label for="date">Tanggal pemesanan</label>
                <input type="date" id="date" name="date" value="{{ $date }}" class="border rounded p-1">
                <button class="px-2 py-1 bg-blue-600 text-white rounded">Lihat</button>
            </form>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa Kuota</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($menus as $menu)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $menu->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($menu->price,0,',','.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $menu->remaining_quota }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">@if($menu->remaining_quota > 0) tersedia @else kosong @endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <a href="{{ route('orders.create', ['date' => $date]) }}" class="px-4 py-2 bg-green-600 text-white rounded">Buat Pre-order</a>
            </div>
        </div>
    </div>
</x-app-layout>