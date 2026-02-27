<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pre-order') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 p-4 text-red-700 bg-red-100 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="order_date" class="block font-medium">Tanggal Pemesanan</label>
                    <input type="date" id="order_date" name="order_date" value="{{ $date ?? old('order_date') }}" class="mt-1 block w-full border rounded p-2" required>
                </div>

                <table class="min-w-full divide-y divide-gray-200 mb-4">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">Menu</th>
                            <th class="px-6 py-3 text-left">Harga</th>
                            <th class="px-6 py-3 text-left">Jumlah</th>
                            <th class="px-6 py-3 text-left">Sisa Kuota</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($menus as $menu)
                            <tr>
                                <td class="px-6 py-4">{{ $menu->name }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($menu->price,0,',','.') }}</td>
                                <td class="px-6 py-4">
                                    <input type="number" name="items[{{ $loop->index }}][quantity]" min="0" max="{{ $menu->remaining_quota }}" value="0" class="w-20 border rounded p-1"/>
                                    <input type="hidden" name="items[{{ $loop->index }}][menu_id]" value="{{ $menu->id }}" />
                                </td>
                                <td class="px-6 py-4">{{ $menu->remaining_quota }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <x-primary-button>{{ __('Pesan') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>