@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
    <section class="py-12 bg-gradient-to-br from-amber-50 to-orange-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-10">
                <h2 class="text-4xl font-extrabold text-gray-800 tracking-tight sm:text-5xl">
                    Detail Transaksi
                </h2>
                <p class="mt-4 max-w-xl mx-auto text-lg text-gray-500">
                    Berikut adalah rincian lengkap untuk transaksi Anda.
                </p>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Header Kartu -->
                <div class="bg-[#6F4E37] p-5 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-300">Kode Transaksi</p>
                            <p class="text-xl font-mono font-semibold">{{ $transaksi->kode_transaksi_222297 }}</p>
                        </div>
                        <div>
                            @php
                                $status = $transaksi->status_222297;
                                $statusClass = 'bg-yellow-400 text-yellow-800'; // Default untuk 'Pending'
                                if ($status === 'Selesai') {
                                    $statusClass = 'bg-green-400 text-green-800';
                                } elseif ($status === 'Dibatalkan') {
                                    $statusClass = 'bg-red-400 text-red-800';
                                } elseif ($status === 'Diproses') {
                                    $statusClass = 'bg-blue-400 text-blue-800';
                                }
                            @endphp
                            <span class="px-3 py-1 text-sm font-bold rounded-full {{ $statusClass }}">
                                {{ $status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Detail Pesanan -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Rincian Pesanan</h3>
                    <div class="flex items-center space-x-4">
                        @if ($transaksi->menu->gambar_menu_222297)
                            <img src="{{ asset('storage/' . $transaksi->menu->gambar_menu_222297) }}"
                                alt="{{ $transaksi->menu->nama_menu_222297 }}" class="w-24 h-24 rounded-md object-cover">
                        @endif
                        <div class="flex-grow">
                            <p class="font-bold text-gray-800 text-xl">{{ $transaksi->menu->nama_menu_222297 }}</p>
                            <p class="text-gray-500">{{ $transaksi->jumlah_222297 }} x Rp
                                {{ number_format($transaksi->menu->harga_222297, 0, ',', '.') }}</p>
                            <p class="text-lg font-semibold text-gray-900 mt-2">
                                Total: Rp {{ number_format($transaksi->harga_total_222297, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pengiriman -->
                @if ($transaksi->delivery)
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Pengiriman</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $transaksi->delivery->alamat_222297 }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kurir</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $transaksi->delivery->kurir_222297 }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status Pengiriman</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $transaksi->delivery->status_222297 }}</dd>
                            </div>
                        </dl>
                    </div>
                @endif

                <!-- Bukti Transfer -->
                @if ($transaksi->bukti_tf_222297)
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Bukti Pembayaran</h3>
                        <a href="{{ asset('storage/' . $transaksi->bukti_tf_222297) }}" target="_blank">
                            <img src="{{ asset('storage/' . $transaksi->bukti_tf_222297) }}" alt="Bukti Transfer"
                                class="rounded-lg max-w-sm mx-auto shadow-lg hover:opacity-90 transition-opacity">
                        </a>
                    </div>
                @endif
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-8 text-center">
                <a href="{{ route('user.transaksi.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Kembali ke Daftar Transaksi
                </a>
            </div>
        </div>
    </section>
@endsection
