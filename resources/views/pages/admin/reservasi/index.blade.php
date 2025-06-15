@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-gradient-to-br from-amber-50 to-orange-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="bg-[#6F4E37] rounded-t-lg px-6 py-4 shadow-lg">
                    <h1 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                        Daftar Reservasi
                    </h1>
                    <p class="text-amber-100 mt-1">Kelola semua reservasi pelanggan</p>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="bg-white rounded-lg shadow-sm mb-6 p-4 border-l-4 border-[#6F4E37]">
                <div class="flex justify-between items-center">
                    <div class="text-gray-600">
                        <span class="font-medium">Total Reservasi: </span>
                        <span
                            class="bg-[#6F4E37] text-white px-2 py-1 rounded-full text-sm">{{ $reservasis->total() }}</span>
                    </div>
                    <a href="{{ route('admin.reservasi.create') }}"
                        class="bg-[#6F4E37] hover:bg-[#5d3e2a] text-white px-4 py-2 rounded-lg transition duration-200 flex items-center shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Reservasi
                    </a>
                </div>
            </div>

            <!-- Table Container -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-[#6F4E37] to-[#8B5A3C]">
                            <tr>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-950 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Nama Pelanggan
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-950 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Tanggal
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-950 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Jam
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-950 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        No. Meja
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-slate-950 uppercase tracking-wider">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                        </svg>
                                        Aksi
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($reservasis as $index => $reservasi)
                                <tr
                                    class="hover:bg-amber-50 transition-colors duration-200 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-[#6F4E37] to-[#8B5A3C] rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                                {{ strtoupper(substr($reservasi->nama_pelanggan_222297, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $reservasi->nama_pelanggan_222297 }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="bg-amber-100 text-amber-800 px-3 py-1 rounded-lg text-sm font-medium">
                                                {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi_222297)->format('d M Y') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-lg text-sm font-medium">
                                                {{ \Carbon\Carbon::parse($reservasi->jam_reservasi_222297)->format('H:i') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="bg-green-100 text-green-800 px-3 py-1 rounded-lg text-sm font-medium">
                                                Meja {{ $reservasi->nomor_meja_222297 }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.reservasi.show', $reservasi->kode_reservasi_222297) }}"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm transition duration-200 flex items-center shadow-sm">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Show
                                            </a>
                                            <a href="{{ route('admin.reservasi.edit', $reservasi->kode_reservasi_222297) }}"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm transition duration-200 flex items-center shadow-sm">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form
                                                action="{{ route('admin.reservasi.destroy', $reservasi->kode_reservasi_222297) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus reservasi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm transition duration-200 flex items-center shadow-sm">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada reservasi</h3>
                                            <p class="text-gray-500 mb-4">Belum ada reservasi yang dibuat.</p>
                                            <a href="{{ route('admin.reservasi.create') }}"
                                                class="bg-[#6F4E37] hover:bg-[#5d3e2a] text-white px-4 py-2 rounded-lg transition duration-200">
                                                Buat Reservasi Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($reservasis->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Menampilkan {{ $reservasis->firstItem() }} sampai {{ $reservasis->lastItem() }}
                                dari {{ $reservasis->total() }} reservasi
                            </div>
                            <div class="pagination-wrapper">
                                {{ $reservasis->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .pagination-wrapper .pagination {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pagination-wrapper .page-item {
            margin: 0 2px;
        }

        .pagination-wrapper .page-link {
            display: block;
            padding: 8px 12px;
            color: #6F4E37;
            text-decoration: none;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .pagination-wrapper .page-link:hover {
            background-color: #6F4E37;
            color: white;
            border-color: #6F4E37;
        }

        .pagination-wrapper .page-item.active .page-link {
            background-color: #6F4E37;
            color: white;
            border-color: #6F4E37;
        }

        .pagination-wrapper .page-item.disabled .page-link {
            color: #9ca3af;
            cursor: not-allowed;
        }
    </style>
@endsection
