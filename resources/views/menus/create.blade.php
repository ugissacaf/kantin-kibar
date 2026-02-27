<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('menus.index') }}" class="p-2 bg-white rounded-lg shadow-sm hover:bg-gray-50 transition-colors border border-gray-100">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Tambah Menu Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
                <div class="p-8 sm:p-12">
                    <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <h3 class="text-lg font-bold text-gray-700 border-b pb-2 flex items-center">
                                    <span class="bg-indigo-100 text-indigo-600 p-1.5 rounded-md me-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </span>
                                    Informasi Dasar
                                </h3>
                                
                                <div>
                                    <x-input-label for="name" :value="__('Nama Menu')" class="font-bold text-gray-600" />
                                    <x-text-input id="name" name="name" type="text" class="mt-2 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" :value="old('name')" required placeholder="Misal: Sate Ayam Madura" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="category" :value="__('Kategori')" class="font-bold text-gray-600" />
                                    <select id="category" name="category" class="mt-2 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition-all" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="makanan" @selected(old('category')=='makanan')>Makanan</option>
                                        <option value="minuman" @selected(old('category')=='minuman')>Minuman</option>
                                        <option value="snack" @selected(old('category')=='snack')>Snack</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="description" :value="__('Deskripsi')" class="font-bold text-gray-600" />
                                    <textarea id="description" name="description" rows="4" class="mt-2 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" placeholder="Jelaskan komposisi atau rasa menu...">{{ old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                            </div>

                            <div class="space-y-6">
                                <h3 class="text-lg font-bold text-gray-700 border-b pb-2 flex items-center">
                                    <span class="bg-green-100 text-green-600 p-1.5 rounded-md me-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </span>
                                    Harga & Stok
                                </h3>

                                <div>
                                    <x-input-label for="price" :value="__('Harga Jual')" class="font-bold text-gray-600" />
                                    <div class="relative mt-2">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-gray-500 font-bold sm:text-sm">Rp</span>
                                        </div>
                                        <x-text-input id="price" name="price" type="number" step="0.01" class="pl-12 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" :value="old('price')" required placeholder="0" />
                                    </div>
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="daily_quota" :value="__('Kuota Per Hari')" class="font-bold text-gray-600" />
                                    <x-text-input id="daily_quota" name="daily_quota" type="number" class="mt-2 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" :value="old('daily_quota')" required placeholder="Misal: 50" />
                                    <x-input-error :messages="$errors->get('daily_quota')" class="mt-2" />
                                </div>

                                <div class="flex items-center p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100/50">
                                    <input id="is_available" name="is_available" type="checkbox" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition-all" value="1" @checked(old('is_available', true)) />
                                    <label for="is_available" class="ms-3 text-sm font-bold text-indigo-900 cursor-pointer">
                                        Aktifkan menu agar bisa dipesan
                                    </label>
                                </div>

                                <div class="pt-2">
                                    <x-input-label for="image" :value="__('Foto Menu (Opsional)')" class="font-bold text-gray-600 mb-2" />
                                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-indigo-400 transition-colors bg-gray-50/30">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-bold text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Upload file</span>
                                                    <input id="image" name="image" type="file" class="sr-only">
                                                </label>
                                                <p class="pl-1">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-8">
                            <a href="{{ route('menus.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest">
                                Batal
                            </a>
                            <button type="submit" class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl transition-all shadow-lg shadow-indigo-100 uppercase tracking-widest text-sm">
                                Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>