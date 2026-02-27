<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Menu') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nama')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="description" :value="__('Deskripsi')" />
                    <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="price" :value="__('Harga')" />
                    <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('price') }}" required />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="category" :value="__('Kategori')" />
                    <select id="category" name="category" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        <option value="">-- pilih --</option>
                        <option value="makanan" @selected(old('category')=='makanan')>Makanan</option>
                        <option value="minuman" @selected(old('category')=='minuman')>Minuman</option>
                        <option value="snack" @selected(old('category')=='snack')>Snack</option>
                    </select>
                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="daily_quota" :value="__('Kuota Harian')" />
                    <x-text-input id="daily_quota" name="daily_quota" type="number" class="mt-1 block w-full" value="{{ old('daily_quota') }}" required />
                    <x-input-error :messages="$errors->get('daily_quota')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="is_available" :value="__('Tersedia')" />
                    <input id="is_available" name="is_available" type="checkbox" class="mt-1" value="1" @checked(old('is_available')) />
                    <x-input-error :messages="$errors->get('is_available')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="image" :value="__('Gambar (opsional)')" />
                    <x-text-input id="image" name="image" type="file" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <x-primary-button>{{ __('Simpan') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>