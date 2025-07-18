<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Statistik Toko</h3>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Total Produk</h4>
                            <p class="text-2xl font-bold text-blue-600">{{ $totalProducts }}</p>
                        </div>

                        <div class="bg-green-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800">Total Transaksi</h4>
                            <p class="text-2xl font-bold text-green-600">{{ $totalTransactions }}</p>
                        </div>

                        <div class="bg-purple-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800">Total User</h4>
                            <p class="text-2xl font-bold text-purple-600">{{ $totalUsers }}</p>
                        </div>

                        <div class="bg-yellow-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800">Total Pendapatan</h4>
                            <p class="text-2xl font-bold text-yellow-600">Rp. {{ number_format($totalRevenue) }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('products.index') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Kelola Produk
                        </a>
                        <a href="{{ route('admin.reports') }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Lihat Laporan
                        </a>
                        <a href="{{ route('admin.users') }}"
                            class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Kelola User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>