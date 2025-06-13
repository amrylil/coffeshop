@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-[#6F4E37]">Transaksi Management</h1>
                <a href="{{ route('admin.transaksi.create') }}"
                    class="px-4 py-2 rounded-md bg-[#6F4E37] hover:bg-[#5a3e2e] text-white">Tambah Transaksi</a>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Transaksi Table -->
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#6F4E37] text-white">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Kode Transaksi
                                </th>

                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Menu
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Jumlah
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Harga Total
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Tanggal Transaksi
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transaksi as $trans)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $trans->kode_transaksi_222297 }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $trans->menu->nama_menu_222297 ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $trans->jumlah_222297 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Rp {{ number_format($trans->harga_total_222297, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ucfirst($trans->status_222297) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($trans->tanggal_transaksi_222297)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.transaksi.show', $trans->kode_transaksi_222297) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                <span class="px-2 py-1 bg-blue-100 rounded-md">View</span>
                                            </a>
                                            <a href="{{ route('admin.transaksi.edit', $trans->kode_transaksi_222297) }}"
                                                class="text-yellow-600 hover:text-yellow-800">
                                                <span class="px-2 py-1 bg-yellow-100 rounded-md">Edit</span>
                                            </a>
                                            <form
                                                action="{{ route('admin.transaksi.destroy', $trans->kode_transaksi_222297) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 px-2 py-1 bg-red-100 rounded-md">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        No transaksi found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $transaksi->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
