<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header dengan tombol aksi -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Detail Produk: {{ $product->name }}</h3>
                        <div class="space-x-2">
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            <a href="{{ route('products.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Detail produk dalam format card -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kolom kiri -->
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                                    <p class="text-lg font-semibold">{{ $product->name }}</p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                                    <p class="text-xl font-bold text-green-600">Rp. {{ number_format($product->price) }}
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Barcode</label>
                                    <p class="font-mono text-lg">{{ $product->barcode }}</p>
                                </div>
                            </div>
                            <!-- Kolom kanan -->
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                                    <p class="text-lg">
                                        <span class="font-semibold">{{ $product->stock }}</span>
                                        <span class="text-sm text-gray-500">unit</span>
                                        @if($product->stock <= 10)
                                            <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 text-xs rounded">Stok
                                                Menipis</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Dibuat pada</label>
                                    <p>{{ $product->created_at->format('d F Y, H:i') }}</p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Terakhir
                                        diupdate</label>
                                    <p>{{ $product->updated_at->format('d F Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi produk -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <p class="text-gray-800 leading-relaxed">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>