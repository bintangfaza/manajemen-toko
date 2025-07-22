<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Point of Sale') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Daftar Produk</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($products as $product)
                            <div class="border rounded-lg p-4">
                                <h4 class="font-semibold">{{ $product->name }}</h4>
                                <p class="text-gray-600">{{ $product->description }}</p>
                                <p class="text-lg font-bold text-green-600">Rp. {{ number_format($product->price) }}</p>
                                <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                                <button class="mt-2 bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-8">
                                <p class="text-gray-500">Belum ada produk tersedia</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>