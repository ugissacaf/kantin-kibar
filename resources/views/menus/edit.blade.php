<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('menus.index') }}" class="p-2 bg-white rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Edit Menu: ') }} <span class="text-indigo-600">{{ $menu->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
                <div class="p-8 sm:p-12">
                    <form action="{{ route('menus.update', $menu) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <h3 class="text-lg font-bold text-gray-700 border-b pb-2">Informasi Umum</h3>
                                
                                <div>
                                    <x-input-label for="name" :value="__('Nama Menu')" class="font-bold" />
                                    <x-text-input id="name" name="name" type="text" class="mt-2 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl" value="{{ old('name',$menu->name) }}" required placeholder="Contoh: Nasi Goreng Spesial" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="category" :value="__('Kategori')" class="font-bold" />
                                    <select id="category" name="category" class="mt-2 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="makanan" @selected(old('category',$menu->category)=='makanan')>Makanan</option>
                                        <option value="minuman" @selected(old('category',$menu->category)=='minuman')>Minuman</option>
                                        <option value="snack" @selected(old('category',$menu->category)=='snack')>Snack</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="description" :value="__('Deskripsi')" class="font-bold" />
                                    <textarea id="description" name="description" rows="4" class="mt-2 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" placeholder="Ceritakan kelezatan menu ini...">{{ old('description',$menu->description) }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                            </div>

                            <div class="space-y-6">
                                <h3 class="text-lg font-bold text-gray-700 border-b pb-2">Harga & Ketersediaan</h3>

                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <x-input-label for="price" :value="__('Harga (Rp)')" class="font-bold" />
                                        <div class="relative mt-2">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                                            </div>
                                            <x-text-input id="price" name="price" type="number" step="0.01" class="pl-10 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl" value="{{ old('price',$menu->price) }}" required />
                                        </div>
                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="daily_quota" :value="__('Kuota Harian')" class="font-bold" />
                                        <x-text-input id="daily_quota" name="daily_quota" type="number" class="mt-2 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl" value="{{ old('daily_quota',$menu->daily_quota) }}" required />
                                        <x-input-error :messages="$errors->get('daily_quota')" class="mt-2" />
                                    </div>

                                    <div class="flex items-center p-4 bg-indigo-50 rounded-2xl border border-indigo-100 mt-2">
                                        <input id="is_available" name="is_available" type="checkbox" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" value="1" @checked(old('is_available',$menu->is_available)) />
                                        <label for="is_available" class="ms-3 text-sm font-bold text-indigo-900">
                                            Tandai sebagai menu tersedia saat ini
                                        </label>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <x-input-label for="image" :value="__('Foto Menu')" class="font-bold mb-2" />
                                    <div class="flex items-center space-x-6">
                                        <div class="shrink-0">
                                            @if($menu->image)
                                                <img src="{{ asset('storage/'.$menu->image) }}" class="h-24 w-24 object-cover rounded-2xl border-2 border-indigo-100 shadow-sm" />
                                            @else
                                                <div class="h-24 w-24 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400 italic text-[10px] border-2 border-dashed border-gray-300">No Image</div>
                                            @endif
                                        </div>
                                        <label class="block flex-1">
                                            <span class="sr-only">Pilih foto</span>
                                            <input id="image" name="image" type="file" class="block w-full text-sm text-gray-500
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-full file:border-0
                                                file:text-sm file:font-semibold
                                                file:bg-indigo-50 file:text-indigo-700
                                                hover:file:bg-indigo-100 transition-all cursor-pointer" />
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t pt-8 mt-4">
                            <a href="{{ route('menus.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors uppercase tracking-widest">
                                Batal
                            </a>
                            <button type="submit" class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl transition-all shadow-lg shadow-indigo-100 uppercase tracking-widest text-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>