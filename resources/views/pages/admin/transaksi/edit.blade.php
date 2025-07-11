@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class=" mx-auto">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-[#6F4E37] rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-[#6F4E37]">Edit Transaksi</h1>
                        <p class="text-gray-600">Kode Transaksi: {{ $transaksi->kode_transaksi }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Transaksi</h2>
                </div>

                <form action="{{ route('admin.transaksi.update', $transaksi->kode_transaksi) }}" method="POST"
                    class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Email User -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Email User</span>
                                </span>
                            </label>
                            <select name="email" id="email"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring-[#6F4E37] focus:ring-opacity-50 transition duration-150 ease-in-out"
                                required>
                                <option value="">Pilih User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->email }}"
                                        {{ old('email', $transaksi->email) == $user->email ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('email')
                                <p class="text-red-600 text-sm flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Menu -->
                        <div class="space-y-2">
                            <label for="kode_menu" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span>Menu</span>
                                </span>
                            </label>
                            <select name="kode_menu" id="kode_menu"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring-[#6F4E37] focus:ring-opacity-50 transition duration-150 ease-in-out"
                                required>
                                <option value="">Pilih Menu</option>
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->kode_menu }}" data-harga="{{ $menu->harga }}"
                                        {{ old('kode_menu', $transaksi->kode_menu) == $menu->kode_menu ? 'selected' : '' }}>
                                        {{-- [DIPERBAIKI] Menggunakan nama sesuai model Menu --}}
                                        {{ $menu->nama }} - Rp
                                        {{ number_format($menu->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kode_menu')
                                <p class="text-red-600 text-sm flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Grid untuk Jumlah dan Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Jumlah -->
                            <div class="space-y-2">
                                <label for="jumlah" class="block text-sm font-medium text-gray-700">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                        <span>Jumlah</span>
                                    </span>
                                </label>
                                <input type="number" name="jumlah" id="jumlah" min="1"
                                    value="{{ old('jumlah', $transaksi->jumlah) }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring-[#6F4E37] focus:ring-opacity-50 transition duration-150 ease-in-out"
                                    required>
                                @error('jumlah')
                                    <p class="text-red-600 text-sm flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="space-y-2">
                                <label for="status" class="block text-sm font-medium text-gray-700">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Status</span>
                                    </span>
                                </label>
                                <select name="status" id="status"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring-[#6F4E37] focus:ring-opacity-50 transition duration-150 ease-in-out"
                                    required>
                                    <option value="pending"
                                        {{ old('status', $transaksi->status) == 'pending' ? 'selected' : '' }}>
                                        🟡 Pending
                                    </option>
                                    <option value="dikonfirmasi"
                                        {{ old('status', $transaksi->status) == 'dikonfirmasi' ? 'selected' : '' }}>
                                        🔵 Dikonfirmasi
                                    </option>
                                    <option value="dikirim"
                                        {{ old('status', $transaksi->status) == 'dikirim' ? 'selected' : '' }}>
                                        🔵 Dikirim
                                    </option>
                                    <option value="ditolak"
                                        {{ old('status', $transaksi->status) == 'ditolak' ? 'selected' : '' }}>
                                        🔴 Ditolak
                                    </option>
                                    <option value="selesai"
                                        {{ old('status', $transaksi->status) == 'selesai' ? 'selected' : '' }}>
                                        🟢 Selesai
                                    </option>
                                </select>
                                @error('status')
                                    <p class="text-red-600 text-sm flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Transaksi -->
                        <div class="space-y-2">
                            <label for="tanggal_transaksi" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>Tanggal Transaksi</span>
                                </span>
                            </label>
                            <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"
                                value="{{ old('tanggal_transaksi', $transaksi->tanggal_transaksi->format('Y-m-d')) }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring-[#6F4E37] focus:ring-opacity-50 transition duration-150 ease-in-out"
                                required>
                            @error('tanggal_transaksi')
                                <p class="text-red-600 text-sm flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Harga Total (Read Only) -->
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                        </svg>
                                        <span>Harga Total Saat Ini</span>
                                    </span>
                                </label>
                                <p class="text-2xl font-bold text-[#6F4E37]">
                                    Rp {{ number_format($transaksi->harga_total, 0, ',', '.') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Harga total akan diperbarui otomatis berdasarkan menu dan jumlah yang dipilih
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                            <a href="{{ route('admin.transaksi.show', $transaksi->kode_transaksi) }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37] transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm bg-[#6F4E37] text-sm font-medium text-slate-950 hover:bg-[#5a3e2e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37] transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto calculate total price when menu or quantity changes
        document.addEventListener('DOMContentLoaded', function() {
            const menuSelect = document.getElementById('kode_menu');
            const quantityInput = document.getElementById('jumlah');
            const totalDisplay = document.getElementById('harga_total_display'); // Tambahkan ID ini ke elemen harga

            // Fungsi untuk kalkulasi
            const calculateTotal = () => {
                const selectedOption = menuSelect.options[menuSelect.selectedIndex];
                const price = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
                const quantity = parseInt(quantityInput.value) || 0;
                const total = price * quantity;

                totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
            };

            // Tambahkan event listener
            menuSelect.addEventListener('change', calculateTotal);
            quantityInput.addEventListener('input', calculateTotal);

            // Panggil saat halaman dimuat pertama kali
            calculateTotal();
        });
    </script>
@endsection
