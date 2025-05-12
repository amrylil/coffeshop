@extends('layouts.dashboard-layout')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-7xl mx-auto">
            <!-- Judul Halaman -->
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-[#6F4E37]">Dashboard</h1>
            </div>

            <!-- Baris Konten - Kartu Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Kartu Jumlah Menu -->
                <div class="bg-white rounded-lg shadow overflow-hidden border-l-4 border-blue-500">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <div class="text-xs font-semibold text-blue-500 uppercase tracking-wider mb-1">
                                    Total Item Menu
                                </div>
                                <div class="text-2xl font-bold text-gray-800">
                                    {{ \App\Models\Menu::count() }}
                                </div>
                            </div>
                            <div class="text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kartu Jumlah Kategori -->
                <div class="bg-white rounded-lg shadow overflow-hidden border-l-4 border-green-500">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <div class="text-xs font-semibold text-green-500 uppercase tracking-wider mb-1">
                                    Kategori
                                </div>
                                <div class="text-2xl font-bold text-gray-800">
                                    {{ \App\Models\KategoriProduk::count() }}
                                </div>
                            </div>
                            <div class="text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kartu Peringatan Stok Habis -->
                <div class="bg-white rounded-lg shadow overflow-hidden border-l-4 border-yellow-500">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <div class="text-xs font-semibold text-yellow-500 uppercase tracking-wider mb-1">
                                    Item Stok Habis
                                </div>
                                <div class="text-2xl font-bold text-gray-800">
                                    {{ \App\Models\Menu::where('jumlah_222297', 0)->count() }}
                                </div>
                            </div>
                            <div class="text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kartu Total Transaksi -->
                <div class="bg-white rounded-lg shadow overflow-hidden border-l-4 border-[#6F4E37]">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <div class="text-xs font-semibold text-[#6F4E37] uppercase tracking-wider mb-1">
                                    Total Transaksi
                                </div>
                                <div class="text-2xl font-bold text-gray-800">
                                    {{ \App\Models\Transaksi::count() }}
                                </div>
                            </div>
                            <div class="text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris Konten - Tabel -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kartu Menu Terbaru -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-[#6F4E37]">Item Menu Terbaru</h3>
                            <a href="{{ route('admin.menu.index') }}"
                                class="px-3 py-1 bg-[#6F4E37] text-white text-sm rounded hover:bg-[#5D4037] transition">
                                Lihat Semua
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kode
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kategori
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Stok
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse(\App\Models\Menu::with('kategori')->orderBy('created_at_222297', 'desc')->take(5)->get() as $menu)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $menu->kode_menu_222297 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#6F4E37]">
                                                {{ $menu->nama_222297 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $menu->kategori ? $menu->kategori->nama_222297 : 'Tidak Diketahui' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Rp {{ number_format($menu->harga_222297, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($menu->jumlah_222297 > 0)
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        {{ $menu->jumlah_222297 }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Stok Habis
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Tidak ada item menu yang ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Kartu Item Stok Menipis -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow overflow-hidden h-full">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg font-medium text-[#6F4E37]">Item Stok Menipis</h3>
                        </div>
                        <div class="p-4">
                            <div class="space-y-2">
                                @forelse(\App\Models\Menu::where('jumlah_222297', '<=', 5)->where('jumlah_222297', '>', 0)->orderBy('jumlah_222297', 'asc')->take(5)->get() as $menu)
                                    <a href="{{ route('admin.menu.edit', $menu->kode_menu_222297) }}"
                                        class="block p-3 rounded-md border border-gray-200 hover:bg-[#F5E6DD] transition flex justify-between items-center">
                                        <span class="text-sm text-gray-800">{{ $menu->nama_222297 }}</span>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $menu->jumlah_222297 }}
                                        </span>
                                    </a>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="mt-2 text-gray-500">Tidak ada item stok menipis.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
