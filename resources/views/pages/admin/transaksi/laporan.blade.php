@extends('layouts.dashboard-layout')

@section('content')
    <div class="container pt-24">
        <h1 class="mb-4 text-3xl font-bold">Laporan Transaksi</h1>

        <form action="{{ route('transaksi.showAllLaporan') }}" method="GET" class="flex flex-wrap justify-evenly items-center gap-6 mb-8 p-6 bg-white shadow-md rounded-lg">
            <div class="w-full md:w-1/3">
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" class="form-control border border-gray-300 rounded-md p-2 w-full focus:ring-2 focus:ring-indigo-500"
                    value="{{ request('start_date') }}">
            </div>
        
            <div class="w-full md:w-1/3">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date" class="form-control border border-gray-300 rounded-md p-2 w-full focus:ring-2 focus:ring-indigo-500"
                    value="{{ request('end_date') }}">
            </div>
        
            <div class="w-full md:w-auto mt-4 md:mt-0">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out mt-7">
                    Terapkan Filter
                </button>
            </div>
        </form>
        
        <!-- Total Transaksi -->
        <div class="bg-white shadow rounded-lg p-6 mb-8 flex justify-between">
            <div>
                <strong class="text-xl text-gray-900">Total Transaksi:</strong>
            <span class="text-3xl font-bold text-green-600">Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</span>
            </div>
            <div class="">
                <a href="{{ route('transaksi.exportPdf', ['filter' => 'laporan', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                    class="bg-green-600 text-white px-6 py-3 rounded-md shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300 ease-in-out">
                    Unduh Laporan PDF
                </a>
            </div>
        </div>
        
        <!-- PDF Export Button -->
        
        
        <!-- Transaction Table -->
        @if ($transaksi->isEmpty())
            <p class="text-gray-500">Tidak ada transaksi yang sesuai dengan filter.</p>
        @else
        <div class="overflow-x-auto bg-slate-50 p-4 rounded-lg shadow-lg">
            <table class="table-auto w-full border-collapse rounded-xl overflow-hidden shadow-lg">
                <thead class="bg-gray-200 text-gray-800 text-lg">
                    <tr>
                        <th class="px-5 py-3 text-left">No</th>
                        <th class="px-5 py-3 text-left">Pelanggan</th>
                        <th class="px-5 py-3 text-left">Produk</th>
                        <th class="px-5 py-3 text-left">Jumlah</th>
                        <th class="px-5 py-3 text-left">Harga</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Tanggal</th>
                        <th class="px-5 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody id="product-table" class="text-gray-700">
                    <tr class="odd:bg-gray-50 even:bg-gray-100 hover:bg-linen">
                        <td class="py-4 px-6">1</td>
                        <td class="py-4 px-6 font-semibold">John Doe</td>
                        <td class="py-4 px-6">Celana</td>
                        <td class="py-4 px-6">2</td>
                        <td class="py-4 px-6">Rp 500.000</td>
                        <td class="py-4 px-6">pending</td>
                        <td class="py-4 px-6">08-04-2025</td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="#" class="btn btn-warning p-2 rounded-lg">Edit</a>
                                <button onclick="confirmDelete()" class="btn btn-error p-2 rounded-lg">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="odd:bg-gray-50 even:bg-gray-100 hover:bg-linen">
                        <td class="py-4 px-6">1</td>
                        <td class="py-4 px-6 font-semibold">John Doe</td>
                        <td class="py-4 px-6">Celana</td>
                        <td class="py-4 px-6">2</td>
                        <td class="py-4 px-6">Rp 500.000</td>
                        <td class="py-4 px-6">pending</td>
                        <td class="py-4 px-6">08-04-2025</td>

                        <td class="py-4 px-6 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="#" class="btn btn-warning p-2 rounded-lg">Edit</a>
                                <button onclick="confirmDelete()" class="btn btn-error p-2 rounded-lg">Hapus</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem;
            width: 100%;
        }

        .form-control:focus {
            outline: none;
            border-color: #4c51bf;
            box-shadow: 0 0 0 1px #4c51bf;
        }

        .btn {
            background-color: #4c51bf;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
        }

        .btn:hover {
            background-color: #434190;
        }
    </style>
@endpush
