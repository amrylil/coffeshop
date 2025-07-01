@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-100">
        <div class="container mx-auto px-4 py-8 pt-20">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-amber-900 mb-2">Transaksi Saya</h1>
                <p class="text-amber-700">Riwayat transaksi pembelian kopi</p>
                <div class="w-24 h-1 bg-amber-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="max-w-6xl mx-auto">
                <!-- Filter Buttons -->
                <div class="mb-8 p-6 bg-white rounded-2xl shadow-lg">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <span class="text-amber-800 font-bold text-lg">Filter Pesanan:</span>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('user.transaksi.index') }}"
                                class="px-6 py-3 rounded-xl font-semibold text-sm border-2 {{ !request('jenis_pesanan') ? 'bg-amber-600 text-white border-amber-600' : 'bg-white text-amber-600 border-amber-300 hover:border-amber-500' }}">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                Semua
                            </a>
                            <a href="{{ route('user.transaksi.index', ['jenis_pesanan' => 'delivery']) }}"
                                class="px-6 py-3 rounded-xl font-semibold text-sm border-2 {{ request('jenis_pesanan') == 'delivery' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-blue-600 border-blue-300 hover:border-blue-500' }}">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Pesan Antar
                            </a>
                            <a href="{{ route('user.transaksi.index', ['jenis_pesanan' => 'di_lokasi']) }}"
                                class="px-6 py-3 rounded-xl font-semibold text-sm border-2 {{ request('jenis_pesanan') == 'di_lokasi' ? 'bg-purple-600 text-white border-purple-600' : 'bg-white text-purple-600 border-purple-300 hover:border-purple-500' }}">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Ambil di Lokasi
                            </a>
                        </div>
                    </div>
                </div>

                @if ($transaksi->count() > 0)
                    <div class="space-y-6">
                        @foreach ($transaksi as $item)
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl">
                                <div class="flex items-center p-6">
                                    <div class="flex-shrink-0 mr-6">
                                        <div
                                            class="w-20 h-20 bg-gradient-to-br from-amber-600 to-orange-500 rounded-2xl flex items-center justify-center shadow-inner">
                                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="flex-grow">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-grow">
                                                <h3 class="font-bold text-amber-900 text-xl mb-2">
                                                    {{ $item->menu->nama ?? 'Menu Tidak Ditemukan' }}
                                                </h3>
                                                <p class="text-gray-600 text-sm mb-3">
                                                    {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->isoFormat('dddd, D MMMM YYYY - HH:mm') }}
                                                </p>

                                                @if ($item->jenis_pesanan == 'delivery')
                                                    <div
                                                        class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                        </svg>
                                                        Delivery
                                                    </div>
                                                @else
                                                    <div
                                                        class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-bold">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                            </path>
                                                        </svg>
                                                        Ambil di Lokasi
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="text-right flex-shrink-0 ml-6">
                                                <div
                                                    class="px-4 py-2 rounded-xl font-bold text-sm mb-3
                                                    @switch($item->status)
                                                        @case('pending') bg-yellow-100 text-yellow-800 @break
                                                        @case('dikonfirmasi') bg-blue-100 text-blue-800 @break
                                                        @case('dikirim') bg-indigo-100 text-indigo-800 @break
                                                        @case('selesai') bg-green-100 text-green-800 @break
                                                        @case('dibatalkan') bg-gray-100 text-gray-800 @break
                                                        @case('ditolak') bg-red-100 text-red-800 @break
                                                        @default bg-gray-100 text-gray-800
                                                    @endswitch">
                                                    {{ ucfirst($item->status) }}
                                                </div>
                                                <div class="text-amber-800 font-bold text-xl mb-3">
                                                    Rp {{ number_format($item->harga_total, 0, ',', '.') }}
                                                </div>
                                                <a href="{{ route('user.transaksi.show', $item->kode_transaksi) }}"
                                                    class="inline-flex items-center px-4 py-2 bg-amber-600 text-white font-semibold text-sm rounded-lg hover:bg-amber-700">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                    Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $transaksi->links() }}
                    </div>
                @else
                    <div class="max-w-md mx-auto text-center">
                        <div class="bg-white rounded-2xl shadow-lg p-12">
                            <div class="w-24 h-24 bg-amber-600 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-amber-900 mb-4">Tidak Ada Transaksi</h2>
                            <p class="text-amber-700 mb-8">
                                Sepertinya tidak ada transaksi yang cocok dengan filter Anda, atau Anda belum pernah
                                bertransaksi.
                            </p>
                            <a href="{{ route('menu.index') }}"
                                class="inline-flex items-center px-8 py-4 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Jelajahi Menu Kopi
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
