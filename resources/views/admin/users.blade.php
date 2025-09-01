<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('👥 Manajemen Pengguna') }}
            </h2>
            <a href="{{ route('register') }}"
                class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-md transition shadow-sm">
                + Tambah Pengguna
            </a>
        </div>
    </x-slot>

    <div class="py-10 mt-6">
        <div class="w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-md shadow">
                ✅ {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-md shadow">
                ❌ {{ session('error') }}
            </div>
            @endif

            {{-- Tabel Pengguna --}}
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b bg-blue-200">
                    <h3 class="text-xl font-semibold text-gray-700">📋 Daftar Pengguna</h3>
                </div>

                <div class="overflow-x-auto w-full">
                    <table class="w-full divide-y divide-gray-100">
                        <thead class="border-b text-sm text-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium">Nama</th>
                                <th class="px-6 py-3 text-left font-medium">Email</th>
                                <th class="px-6 py-3 text-center font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                                {{-- Kolom tambahan bisa ditambah di sini --}}
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white text-xs px-4 py-2 rounded-md transition shadow-sm">
                                            Hapus
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-2 rounded-md transition shadow-sm">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>