@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-100">
        <div class="container mx-auto px-4 py-8 pt-20">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-amber-900 mb-2">Detail Transaksi</h1>
                <p class="text-amber-700">Rincian lengkap transaksi pembelian kopi Anda</p>
                <div class="w-24 h-1 bg-amber-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="max-w-4xl mx-auto">
                <!-- Main Transaction Card -->
                <div
                    class="bg-gradient-to-r from-white via-white to-amber-50 rounded-3xl shadow-2xl border border-amber-100 overflow-hidden mb-6">
                    <!-- Header Card dengan Gradient -->
                    <div class="bg-gradient-to-r from-amber-600 to-orange-500 h-3"></div>

                    <!-- Transaction Header -->
                    <div class="bg-gradient-to-r from-amber-800 to-orange-700 p-8 text-white">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-amber-100 text-sm font-medium">Kode Transaksi</p>
                                    <p class="text-2xl font-black font-mono">{{ $transaksi->kode_transaksi }}</p>
                                    <p class="text-amber-200 text-sm mt-1">
                                        {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->isoFormat('dddd, D MMMM YYYY - HH:mm') }}
                                    </p>
                                </div>
                            </div>

                            <div class="text-right">
                                @php
                                    $status = $transaksi->status;
                                    $statusClass = 'bg-gradient-to-r from-yellow-400 to-orange-400'; // Default untuk 'pending'
                                    if ($status === 'selesai') {
                                        $statusClass = 'bg-gradient-to-r from-green-400 to-emerald-500';
                                    } elseif ($status === 'dibatalkan') {
                                        $statusClass = 'bg-gradient-to-r from-red-400 to-red-500';
                                    } elseif ($status === 'dikonfirmasi') {
                                        $statusClass = 'bg-gradient-to-r from-blue-400 to-indigo-500';
                                    } elseif ($status === 'dikirim') {
                                        $statusClass = 'bg-gradient-to-r from-indigo-500 to-purple-600';
                                    } elseif ($status === 'ditolak') {
                                        $statusClass = 'bg-gradient-to-r from-red-400 to-red-500';
                                    }
                                @endphp
                                <div
                                    class="inline-flex items-center px-6 py-3 rounded-2xl font-bold text-white shadow-lg {{ $statusClass }}">
                                    <div class="w-3 h-3 rounded-full bg-white opacity-80 mr-3"></div>
                                    {{ ucfirst($status) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="p-8">
                        <h3 class="text-2xl font-black text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-amber-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Rincian Pesanan
                        </h3>

                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-200">
                            <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                                @if ($transaksi->menu->gambar_menu)
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/' . $transaksi->menu->gambar_menu) }}"
                                            alt="{{ $transaksi->menu->nama }}"
                                            class="w-32 h-32 rounded-2xl object-cover shadow-lg border-4 border-white">
                                    </div>
                                @endif

                                <div class="flex-grow">
                                    <h4 class="font-black text-2xl text-gray-900 mb-2">{{ $transaksi->menu->nama }}
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="bg-white rounded-xl p-4 border border-amber-200">
                                            <p class="text-amber-700 text-sm font-semibold">Jumlah Pesanan</p>
                                            <p class="text-2xl font-bold text-gray-900">{{ $transaksi->jumlah }} Item
                                            </p>
                                        </div>
                                        <div class="bg-white rounded-xl p-4 border border-amber-200">
                                            <p class="text-amber-700 text-sm font-semibold">Harga per Item</p>
                                            <p class="text-2xl font-bold text-gray-900">Rp
                                                {{ number_format($transaksi->menu->harga, 0, ',', '.') }}</p>
                                        </div>
                                    </div>

                                    <!-- Order Type Badge -->
                                    @if ($transaksi->jenis_pesanan == 'delivery')
                                        <div
                                            class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-full text-sm font-bold shadow-lg mb-4">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0">
                                                </path>
                                            </svg>
                                            Pesan Antar (Delivery)
                                        </div>
                                    @else
                                        <div
                                            class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full text-sm font-bold shadow-lg mb-4">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                            Ambil di Lokasi
                                        </div>
                                    @endif

                                    <!-- Total Price -->
                                    <div class="bg-gradient-to-r from-amber-600 to-orange-600 rounded-2xl p-6 shadow-lg">
                                        <p class="text-amber-100 text-sm font-semibold">Total Pembayaran</p>
                                        <p class="text-3xl font-black text-white">Rp
                                            {{ number_format($transaksi->harga_total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                @if ($transaksi->delivery)
                    <div
                        class="bg-gradient-to-r from-white via-white to-blue-50 rounded-3xl shadow-xl border border-blue-100 overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-blue-600 to-cyan-500 h-3"></div>
                        <div class="p-8">
                            <h3 class="text-2xl font-black text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Informasi Pengiriman
                            </h3>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div
                                    class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl p-6 border border-blue-200">
                                    <dt class="text-blue-700 text-sm font-bold mb-2">Alamat Pengiriman</dt>
                                    <dd class="text-gray-900 font-semibold text-lg">
                                        {{ $transaksi->delivery->alamat }}</dd>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="bg-white rounded-xl p-4 border border-blue-200">
                                        <dt class="text-blue-700 text-sm font-bold">Kurir</dt>
                                        <dd class="text-gray-900 font-semibold text-lg">
                                            {{ $transaksi->delivery->kurir }}</dd>
                                    </div>
                                    <div class="bg-white rounded-xl p-4 border border-blue-200">
                                        <dt class="text-blue-700 text-sm font-bold">Status Pengiriman</dt>
                                        <dd class="text-gray-900 font-semibold text-lg">
                                            {{ $transaksi->delivery->status }}</dd>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Payment Proof -->
                @if ($transaksi->bukti_tf)
                    <div
                        class="bg-gradient-to-r from-white via-white to-green-50 rounded-3xl shadow-xl border border-green-100 overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-green-600 to-emerald-500 h-3"></div>
                        <div class="p-8">
                            <h3 class="text-2xl font-black text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Bukti Pembayaran
                            </h3>

                            <div class="text-center">
                                <div class="inline-block bg-white rounded-2xl p-4 shadow-lg border border-green-200">
                                    <a href="{{ asset('storage/' . $transaksi->bukti_tf) }}" target="_blank"
                                        class="block">
                                        <img src="{{ asset('storage/' . $transaksi->bukti_tf) }}" alt="Bukti Transfer"
                                            class="rounded-xl max-w-sm mx-auto shadow-md hover:shadow-lg">
                                    </a>
                                    <p class="text-green-700 text-sm font-semibold mt-3">Klik untuk memperbesar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="text-center">
                    <a href="{{ route('user.transaksi.index') }}"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-amber-600 to-orange-600 text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-xl hover:from-amber-700 hover:to-orange-700">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        Kembali ke Daftar Transaksi
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
