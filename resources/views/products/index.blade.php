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

                    <!-- Form Pencarian dan Filter -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <form method="GET" action="{{ route('products.index') }}"
                            class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Input Pencarian -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                                    Cari Produk
                                </label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Cari nama, deskripsi, atau barcode..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- Filter Stok -->
                            <div>
                                <label for="stock_filter" class="block text-sm font-medium text-gray-700 mb-1">
                                    Filter Stok
                                </label>
                                <select name="stock_filter" id="stock_filter"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua Stok</option>
                                    <option value="available" {{ request('stock_filter') == 'available' ? 'selected' : '' }}>
                                        Stok Tersedia
                                    </option>
                                    <option value="low" {{ request('stock_filter') == 'low' ? 'selected' : '' }}>
                                        Stok Menipis (≤10)
                                    </option>
                                    <option value="empty" {{ request('stock_filter') == 'empty' ? 'selected' : '' }}>
                                        Stok Habis
                                    </option>
                                </select>
                            </div>

                            <!-- Tombol Action -->
                            <div class="flex items-end space-x-2">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                                    Cari
                                </button>
                                <a href="{{ route('products.index') }}"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Info hasil pencarian -->
                    @if(request('search') || request('stock_filter'))
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                            <p class="text-blue-700">
                                Menampilkan hasil 
                                @if(request('search'))
                                    pencarian "<strong>{{ request('search') }}</strong>"
                                @endif
                                @if(request('stock_filter'))
                                    dengan filter: <strong>
                                        @switch(request('stock_filter'))
                                            @case('available') Stok Tersedia @break
                                            @case('low') Stok Menipis @break
                                            @case('empty') Stok Habis @break
                                        @endswitch
                                    </strong>
                                @endif
                                | Total: <strong>{{ $products->total() }}</strong> produk
                            </p>
                        </div>
                    @endif

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
                                            @if($product->stock <= 10 && $product->stock > 0)
                                                <span class="ml-1 text-orange-500 text-xs">(Menipis)</span>
                                            @elseif($product->stock == 0)
                                                <span class="ml-1 text-red-500 text-xs">(Habis)</span>
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
                                        <td colspan="5" class="px-4 py-2 border text-center">
                                            @if(request('search') || request('stock_filter'))
                                                Tidak ada produk yang sesuai dengan kriteria pencarian
                                            @else
                                                Belum ada produk
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>