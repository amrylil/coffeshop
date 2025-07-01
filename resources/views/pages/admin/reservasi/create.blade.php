@extends('layouts.dashboard-layout')

@section('content')
    <div class="min-h-screen  py-12 px-4 sm:px-6 lg:px-8 pt-24">
        <div class=" mx-auto">


            <!-- Form Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl border border-white/20 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-slate-950 text-xl font-semibold">Informasi Reservasi</h2>
                    </div>
                </div>

                <form action="{{ route('admin.reservasi.store') }}" method="POST" class="p-8 space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Nama Pelanggan -->
                        <div class="space-y-2">
                            <label for="nama_pelanggan" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Nama Pelanggan</span>
                                </span>
                            </label>
                            <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                                value="{{ old('nama_pelanggan') }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all duration-200 bg-gray-50/50 hover:bg-white"
                                placeholder="Masukkan nama lengkap pelanggan" required>
                            @error('nama_pelanggan')
                                <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- No Telepon -->
                        <div class="space-y-2">
                            <label for="no_telepon" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <span>No Telepon</span>
                                </span>
                            </label>
                            <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all duration-200 bg-gray-50/50 hover:bg-white"
                                placeholder="Contoh: 08123456789" required>
                            @error('no_telepon')
                                <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Tanggal Reservasi -->
                        <div class="space-y-2">
                            <label for="tanggal_reservasi" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span>Tanggal Reservasi</span>
                                </span>
                            </label>
                            <input type="date" name="tanggal_reservasi" id="tanggal_reservasi"
                                value="{{ old('tanggal_reservasi') }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all duration-200 bg-gray-50/50 hover:bg-white"
                                required>
                            @error('tanggal_reservasi')
                                <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Jam Reservasi -->
                        <div class="space-y-2">
                            <label for="jam_reservasi" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Jam Reservasi</span>
                                </span>
                            </label>
                            <input type="time" name="jam_reservasi" id="jam_reservasi"
                                value="{{ old('jam_reservasi') }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all duration-200 bg-gray-50/50 hover:bg-white"
                                required>
                            @error('jam_reservasi')
                                <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nomor Meja -->
                    <div class="space-y-2">
                        <label for="nomor_meja" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </span>
                            </svg>
                            <span>Nomor Meja</span>
                            </span>
                        </label>
                        <select name="nomor_meja" id="nomor_meja"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all duration-200 bg-gray-50/50 hover:bg-white"
                            required>
                            <option value="" class="text-gray-500">Pilih meja yang tersedia</option>
                            @foreach ($mejas as $meja)
                                <option value="{{ $meja->nomor_meja }}"
                                    {{ old('nomor_meja') == $meja->nomor_meja ? 'selected' : '' }}>
                                    Meja {{ $meja->nomor_meja }} - Kapasitas {{ $meja->kapasitas }} orang
                                </option>
                            @endforeach
                        </select>
                        @error('nomor_meja')
                            <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div class="space-y-2">
                        <label for="catatan" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                <span>Catatan Khusus</span>
                                <span class="text-gray-400 text-xs">(Opsional)</span>
                            </span>
                        </label>
                        <textarea name="catatan" id="catatan" rows="4"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all duration-200 bg-gray-50/50 hover:bg-white resize-none"
                            placeholder="Tambahkan catatan khusus untuk reservasi ini (contoh: alergi makanan, permintaan khusus, dll.)">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div
                        class="flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4 pt-8 border-t border-gray-200">
                        <a href="{{ route('admin.reservasi.index') }}"
                            class="px-8 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition-all duration-200 text-center border-2 border-gray-200 hover:border-gray-300">
                            <span class="flex items-center justify-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                <span>Batal</span>
                            </span>
                        </a>
                        <button type="submit"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-slate-950 font-semibold transition-all duration-200 shadow-lg hover:shadow-xl">
                            <span class="flex items-center justify-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan Reservasi</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
