<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kasir Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Selamat datang, {{ auth()->user()->name }}!</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Transaksi Hari Ini</h4>
                            <p class="text-2xl font-bold text-blue-600">{{ $todayTransactions }}</p>
                        </div>

                        <div class="bg-green-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800">Pendapatan Hari Ini</h4>
                            <p class="text-2xl font-bold text-green-600">Rp. {{ number_format($todayRevenue) }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('kasir.pos') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Mulai Transaksi
                        </a>
                        <a href="{{ route('kasir.sales') }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Riwayat Penjualan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>