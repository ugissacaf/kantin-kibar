<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $menu->name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($menu->image)
                    <img src="{{ asset('storage/'.$menu->image) }}" class="w-48 h-48 object-cover mb-4" />
                @endif
                <p>{{ $menu->description }}</p>
                <p class="mt-2">Harga: Rp {{ number_format($menu->price,0,',','.') }}</p>
                <p>Kuota harian: {{ $menu->daily_quota }}</p>
                <p>Status: {{ $menu->is_available ? 'tersedia' : 'tidak tersedia' }}</p>
            </div>
        </div>
    </div>
</x-app-layout>