<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Menu') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-end mb-2">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('menus.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah Menu</a>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            @if(!auth()->user()->isAdmin())
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                            @endif
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($menus as $menu)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $menu->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $menu->category }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($menu->price,0,',','.') }}</td>
                                @if(!auth()->user()->isAdmin())
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $menu->remaining_quota ?? '-' }}
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('menus.show', $menu) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                    @if(auth()->user()->isAdmin())
                                        | <a href="{{ route('menus.edit', $menu) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        | <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                          </form>
                                    @else
                                        | <a href="{{ route('orders.create', ['menu_id' => $menu->id]) }}" class="text-green-600 hover:text-green-900">Pesan</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $menus->links() }}
            </div>
        </div>
    </div>
</x-app-layout>