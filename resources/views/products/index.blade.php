<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Message untuk notifikasi sukses -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Daftar Produk</h3>
                        <a href="{{ route('products.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Produk
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 border">Nama</th>
                                    <th class="px-4 py-2 border">Harga</th>
                                    <th class="px-4 py-2 border">Stok</th>
                                    <th class="px-4 py-2 border">Barcode</th>
                                    <th class="px-4 py-2 border">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td class="px-4 py-2 border">{{ $product->name }}</td>
                                        <td class="px-4 py-2 border">Rp. {{ number_format($product->price) }}</td>
                                        <td class="px-4 py-2 border">
                                            {{ $product->stock }}
                                            @if($product->stock <= 10)
                                                <span class="ml-1 text-red-500 text-xs">(Menipis)</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 border">{{ $product->barcode }}</td>
                                        <td class="px-4 py-2 border">
                                            <a href="{{ route('products.show', $product->id) }}"
                                                class="text-blue-600 hover:text-blue-800 mr-2">
                                                Lihat
                                            </a>
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="text-green-600 hover:text-green-800 mr-2">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('products.destroy', $product->id) }}"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800"
                                                    onclick="return confirm('Yakin ingin menghapus produk {{ $product->name }}?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-2 border text-center">Belum ada produk</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>