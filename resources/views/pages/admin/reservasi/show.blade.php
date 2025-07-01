@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class=" mx-auto">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-[#6F4E37] mb-2">Detail Reservasi</h1>
                        <p class="text-gray-600">Kode Reservasi: {{ $reservasi->kode_reservasi }}</p>
                    </div>
                    <div class="text-right">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Aktif
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Nama Pelanggan</label>
                            <p class="text-lg text-gray-900 font-medium">{{ $reservasi->nama_pelanggan }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">No Telepon</label>
                            <p class="text-lg text-gray-900">{{ $reservasi->no_telepon }}</p>
                        </div>
                    </div>
                </div>

                <!-- Reservation Details Section -->
                <div class="border-t border-gray-200">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">Detail Reservasi</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Tanggal</label>
                                <p class="text-lg text-gray-900 font-medium">{{ $reservasi->tanggal_reservasi }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Jam</label>
                                <p class="text-lg text-gray-900 font-medium">{{ $reservasi->jam_reservasi }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Nomor Meja</label>
                                <p class="text-lg text-gray-900 font-medium">Meja {{ $reservasi->nomor_meja }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="border-t border-gray-200">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">Catatan</h2>
                    </div>
                    <div class="p-6">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-gray-700 leading-relaxed">
                                {{ $reservasi->catatan ?? 'Tidak ada catatan khusus' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <a href="{{ route('admin.reservasi.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37]">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('admin.reservasi.edit', $reservasi->kode_reservasi) }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm bg-[#6F4E37] text-sm font-medium text-white hover:bg-[#5a3e2e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37]">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.reservasi.destroy', $reservasi->kode_reservasi) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')" class="inline-block">
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
