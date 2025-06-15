@extends('layouts.dashboard-layout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-20">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Transaksi</h1>
                <p class="text-gray-600">Kelola dan pantau semua transaksi sistem</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                    </svg>
                    Total: {{ $transaksi->total() ?? 0 }} transaksi
                </span>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
            <div class="bg-[#6F4E37] text-white px-6 py-4 rounded-t-xl">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                            clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-lg font-semibold">Filter & Export Data</h3>
                </div>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.transaksi.report') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status
                                Transaksi</label>
                            <select name="status" id="status"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">🔍 Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                    ⏳ Pending
                                </option>
                                <option value="dikonfirmasi" {{ request('status') == 'dikonfirmasi' ? 'selected' : '' }}>
                                    ✅ Dikonfirmasi
                                </option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                    🎉 Selesai
                                </option>
                                <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>
                                    🚚 Dikirim
                                </option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                    ❌ Ditolak
                                </option>
                            </select>
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                                Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                value="{{ request('tanggal_mulai') }}">
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                                Akhir</label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                value="{{ request('tanggal_akhir') }}">
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col gap-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Aksi</label>
                            <button type="submit"
                                class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                                Filter Data
                            </button>
                            <button type="submit" form="exportForm"
                                class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                Export CSV
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Hidden Export Form -->
                <form id="exportForm" action="{{ route('admin.transaksi.export') }}" method="GET" class="hidden">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                    <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                </form>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z"
                                clip-rule="evenodd" />
                        </svg>
                        Data Transaksi
                    </h3>
                    @if (request()->hasAny(['status', 'tanggal_mulai', 'tanggal_akhir']))
                        <a href="{{ route('admin.transaksi.report') }}"
                            class="mt-2 sm:mt-0 inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Reset Filter
                        </a>
                    @endif
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a1 1 0 011-1h14a1 1 0 110 2H3a1 1 0 01-1-1zM2 15a1 1 0 011-1h14a1 1 0 110 2H3a1 1 0 01-1-1z" />
                                    </svg>
                                    Kode Transaksi
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Email User
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Menu
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 16a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                                    </svg>
                                    Jumlah
                                </div>
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center justify-end">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Harga Total
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Status
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Tanggal
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($transaksi as $t)
                            <tr class="hover:bg-blue-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 font-mono">
                                        {{ $t->kode_transaksi_222297 }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-blue-600" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $t->email_222297 }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $t->menu->nama_222297 ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $t->jumlah_222297 }}x
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-bold text-green-600">
                                        Rp {{ number_format($t->harga_total_222297, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                                            'dikonfirmasi' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                                            'selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                                            'dikirim' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
                                            'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                        ];
                                        $config = $statusConfig[$t->status_222297] ?? [
                                            'bg' => 'bg-gray-100',
                                            'text' => 'text-gray-800',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                        {{ ucfirst($t->status_222297) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">
                                        {{ $t->tanggal_transaksi_222297->format('d M Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $t->tanggal_transaksi_222297->format('H:i') }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data transaksi</h3>
                                        <p class="text-gray-500">Belum ada transaksi yang sesuai dengan filter yang
                                            dipilih.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($transaksi->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center">
                        <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                            Menampilkan <span class="font-medium">{{ $transaksi->firstItem() ?? 0 }}</span> sampai
                            <span class="font-medium">{{ $transaksi->lastItem() ?? 0 }}</span> dari
                            <span class="font-medium">{{ $transaksi->total() }}</span> data
                        </div>
                        <div>
                            {{ $transaksi->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
