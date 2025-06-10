@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-100">
        <div class=" mx-auto px-4 py-8 pt-20">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-amber-900 mb-2">Transaksi Saya</h1>
                <p class="text-amber-700">Riwayat transaksi pembelian kopi</p>
                <div class="w-24 h-1 bg-amber-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="max-w-6xl mx-auto">
                @if ($transaksi->count() > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
                        <!-- Transaction Items -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                                <div class="bg-[#422424] text-white p-6">
                                    <h2 class="text-2xl font-semibold flex items-center">
                                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 114 0 2 2 0 01-4 0zm8 0a2 2 0 114 0 2 2 0 01-4 0z" />
                                        </svg>
                                        Riwayat Transaksi ({{ $transaksi->count() }})
                                    </h2>
                                </div>

                                <div class="p-6 space-y-4">
                                    @foreach ($transaksi as $item)
                                        <div
                                            class="flex items-center space-x-4 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200 hover:shadow-md transition-all duration-300">
                                            <!-- Coffee Icon -->
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-16 h-16 bg-gradient-to-r from-amber-700 to-orange-700 rounded-xl flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Item Details -->
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-amber-900 text-lg">
                                                    {{ $item->menu->nama_222297 ?? 'Menu Item' }}</h3>
                                                <p class="text-amber-600 text-sm">
                                                    {{ $item->tanggal_transaksi_222297 ?? 'Tanggal Transaksi' }}</p>
                                                <div class="flex items-center mt-2">
                                                    <span class="text-amber-800 font-medium">Rp
                                                        {{ number_format($item->harga_total_222297, 0, ',', '.') }}</span>
                                                    <span class="text-amber-600 text-sm ml-2">Total Harga</span>
                                                </div>
                                            </div>

                                            <!-- Status -->
                                            <div class="text-right">
                                                <div class="font-bold text-amber-900 text-lg">
                                                    {{ $item->status_222297 }}
                                                </div>
                                                <a href="{{ route('user.transaksi.show', $item->kode_transaksi_222297) }}"
                                                    class="text-amber-500 hover:text-amber-700 text-sm mt-1 transition-colors duration-200">
                                                    Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $transaksi->links() }}
                    </div>
                @else
                    <!-- Empty Transaction -->
                    <div class="max-w-md mx-auto text-center">
                        <div class="bg-white rounded-2xl shadow-lg p-12">
                            <div class="w-24 h-24 bg-[#422424] rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6.5-5v5a2 2 0 01-2 2H9a2 2 0 01-2-2v-5m6.5-5H15a2 2 0 012 2v3" />
                                </svg>
                            </div>

                            <h2 class="text-2xl font-bold text-amber-900 mb-4">Tidak Ada Transaksi</h2>
                            <p class="text-amber-600 mb-8">Sepertinya Anda belum melakukan transaksi apapun.
                            </p>

                            <a href="{{ route('menu.index') }}"
                                class="inline-block bg-[#422424] hover:bg-amber-700 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Jelajahi Menu Kopi
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
