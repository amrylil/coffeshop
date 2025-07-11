@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class=" mx-auto">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-[#6F4E37] mb-2">Detail Transaksi</h1>
                        <p class="text-gray-600">Kode Transaksi: {{ $transaksi->kode_transaksi }}</p>
                    </div>
                    <div class="text-right">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'dikonfirmasi' => 'bg-blue-100 text-blue-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                                'selesai' => 'bg-green-100 text-green-800',
                            ];
                            $statusColor = $statusColors[$transaksi->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                            {{ ucfirst($transaksi->status) }}
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
                        <p class="text-lg text-gray-900 font-medium">{{ $transaksi->email }}</p>
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
                                <p class="text-lg text-gray-900 font-medium">{{ $transaksi->menu->nama ?? '-' }}
                                </p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Jumlah</label>
                                <p class="text-lg text-gray-900 font-medium">{{ $transaksi->jumlah }} item</p>
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
                                    {{ number_format($transaksi->harga_total, 0, ',', '.') }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Tanggal
                                    Transaksi</label>
                                <p class="text-lg text-gray-900 font-medium">{{ $transaksi->tanggal_transaksi }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bukti Transfer Section -->
                <div class="border-t border-gray-200">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">Bukti Transfer</h2>
                    </div>
                    <div class="p-6">
                        @if ($transaksi->bukti_tf)
                            <div class="space-y-4">
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">File Bukti
                                        Transfer</label>
                                    <p class="text-lg text-gray-900 font-medium">{{ basename($transaksi->bukti_tf) }}
                                    </p>
                                </div>

                                <div class="border rounded-lg p-4 bg-gray-50">
                                    @php
                                        $fileExtension = strtolower(pathinfo($transaksi->bukti_tf, PATHINFO_EXTENSION));
                                        $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    @endphp

                                    @if ($isImage)
                                        <div class="max-w-md mx-auto">
                                            <img src="{{ asset('storage/' . $transaksi->bukti_tf) }}" alt="Bukti Transfer"
                                                class="w-full h-auto rounded-lg shadow-sm border border-gray-200">
                                        </div>
                                    @else
                                        <div class="text-center py-8">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-500">File dokumen bukti transfer</p>
                                        </div>
                                    @endif

                                    <div class="mt-4 text-center">
                                        <a href="{{ asset('storage/' . $transaksi->bukti_tf) }}" target="_blank"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37]">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat File
                                        </a>
                                        <a href="{{ asset('storage/' . $transaksi->bukti_tf) }}" download
                                            class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37]">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Belum ada bukti transfer yang diupload</p>
                            </div>
                        @endif
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
                                @if ($transaksi->status == 'pending')
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                    <span class="text-yellow-700 font-medium">Transaksi sedang menunggu konfirmasi</span>
                                @elseif($transaksi->status == 'dikonfirmasi')
                                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                    <span class="text-blue-700 font-medium">Transaksi telah dikonfirmasi dan sedang
                                        diproses</span>
                                @elseif($transaksi->status == 'dikirim')
                                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                    <span class="text-blue-700 font-medium">Pesanan dalam pengiriman</span>
                                @elseif($transaksi->status == 'ditolak')
                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                    <span class="text-red-700 font-medium">Transaksi ditolak</span>
                                @elseif($transaksi->status == 'selesai')
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
                    <a href="{{ route('admin.transaksi.edit', $transaksi->kode_transaksi) }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm bg-[#6F4E37] text-sm font-medium text-white hover:bg-[#5a3e2e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37]">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.transaksi.destroy', $transaksi->kode_transaksi) }}" method="POST"
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
