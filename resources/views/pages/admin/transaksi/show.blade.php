@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-[#6F4E37] mb-2">Detail Transaksi</h1>
                        <p class="text-gray-600">Kode Transaksi: {{ $transaksi->kode_transaksi_222297 }}</p>
                    </div>
                    <div class="text-right">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'dikonfirmasi' => 'bg-blue-100 text-blue-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                                'selesai' => 'bg-green-100 text-green-800',
                            ];
                            $statusColor = $statusColors[$transaksi->status_222297] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                            {{ ucfirst($transaksi->status_222297) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <!-- Customer Information Section -->
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Pelanggan</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Email User</label>
                        <p class="text-lg text-gray-900 font-medium">{{ $transaksi->email_222297 }}</p>
                    </div>
                </div>

                <!-- Order Details Section -->
                <div class="border-t border-gray-200">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">Detail Pesanan</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Menu</label>
                                <p class="text-lg text-gray-900 font-medium">{{ $transaksi->menu->nama_menu_222297 ?? '-' }}
                                </p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Jumlah</label>
                                <p class="text-lg text-gray-900 font-medium">{{ $transaksi->jumlah_222297 }} item</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information Section -->
                <div class="border-t border-gray-200">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">Informasi Pembayaran</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Harga Total</label>
                                <p class="text-2xl text-[#6F4E37] font-bold">Rp
                                    {{ number_format($transaksi->harga_total_222297, 0, ',', '.') }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Tanggal
                                    Transaksi</label>
                                <p class="text-lg text-gray-900 font-medium">{{ $transaksi->tanggal_transaksi_222297 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Timeline Section -->
                <div class="border-t border-gray-200">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">Status Transaksi</h2>
                    </div>
                    <div class="p-6">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center space-x-3">
                                @if ($transaksi->status_222297 == 'pending')
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                                    <span class="text-yellow-700 font-medium">Transaksi sedang menunggu konfirmasi</span>
                                @elseif($transaksi->status_222297 == 'dikonfirmasi')
                                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                    <span class="text-blue-700 font-medium">Transaksi telah dikonfirmasi dan sedang
                                        diproses</span>
                                @elseif($transaksi->status_222297 == 'ditolak')
                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                    <span class="text-red-700 font-medium">Transaksi ditolak</span>
                                @elseif($transaksi->status_222297 == 'selesai')
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-green-700 font-medium">Transaksi telah selesai</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <a href="{{ route('admin.transaksi.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37]">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('admin.transaksi.edit', $transaksi->kode_transaksi_222297) }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm bg-[#6F4E37] text-sm font-medium text-white hover:bg-[#5a3e2e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37]">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.transaksi.destroy', $transaksi->kode_transaksi_222297) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm bg-red-600 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
