<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center">
                <span class="bg-indigo-100 p-2 rounded-lg me-3">🍱</span>
                {{ __('Daftar Menu Restoran') }}
            </h2>

            @if(auth()->user()->isAdmin())
                <a href="{{ route('menus.create') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-100">
                    
                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"></path>
                    </svg>

                    Tambah Menu Baru
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 flex items-center p-4 text-green-800 bg-green-50 border-s-4 border-green-500 rounded-r-xl shadow-sm">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 
                              7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                              clip-rule="evenodd">
                        </path>
                    </svg>
                    <div class="ms-3 text-sm font-bold">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">

                        {{-- TABLE HEADER --}}
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                                    Info Menu
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                                    Harga
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-black text-gray-500 uppercase tracking-wider">
                                    Status Stok
                                </th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>

                        {{-- TABLE BODY --}}
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($menus as $menu)
                                <tr class="hover:bg-gray-50 transition-colors">

                                    {{-- Info --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center text-lg shadow-inner">
                                                🍽️
                                            </div>
                                            <div class="ms-4">
                                                <div class="text-sm font-bold text-gray-900">
                                                    {{ $menu->name }}
                                                </div>
                                                <div class="text-[10px] text-gray-400">
                                                    ID: #{{ $menu->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-[10px] font-black rounded-full uppercase italic border border-blue-100">
                                            {{ $menu->category }}
                                        </span>
                                    </td>

                                    {{-- Harga --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-black text-gray-900">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </div>
                                    </td>

                                    {{-- Stok --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-bold 
                                            {{ ($menu->remaining_quota ?? 0) <= 0 ? 'text-red-500' : 'text-gray-700' }}">
                                            {{ $menu->remaining_quota ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                   <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
    <div class="flex justify-end items-center gap-3">

        {{-- View --}}
        <a href="{{ route('menus.show', $menu) }}"
           class="text-indigo-600 hover:text-indigo-800 font-medium">
            View
        </a>

        @if(auth()->user()->isAdmin())

            {{-- Edit --}}
            <a href="{{ route('menus.edit', $menu) }}"
               class="text-yellow-600 hover:text-yellow-800 font-medium">
                Edit
            </a>

            {{-- Delete --}}
            <form action="{{ route('menus.destroy', $menu) }}"
                  method="POST"
                  class="inline"
                  onsubmit="return confirm('Yakin hapus?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="text-red-600 hover:text-red-800 font-medium">
                    Delete
                </button>
            </form>

        @endif

            {{-- PRE ORDER --}}
            <a href="{{ route('orders.create', ['menu_id' => $menu->id]) }}"
               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition">
                Pre-Order
            </a>

       

    </div>
</td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $menus->links() }}
            </div>

        </div>
    </div>
</x-app-layout>