@extends('layouts.app')

@section('title', 'Reservasi')

@section('content')
    <section class="">
        <div class="py-12">
            <!-- Elegant Header -->
            <div class="text-center mb-16">
                <h2 class="text-5xl font-serif italic mb-6 text-slate-50">Reservasi</h2>
                <div class="flex justify-center items-center">
                    <div class="h-px w-16 bg-[#e6dbd1]"></div>
                    <span class="mx-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#e6dbd1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 8h1a4 4 0 1 1 0 8h-1"></path>
                            <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"></path>
                            <line x1="6" y1="2" x2="6" y2="4"></line>
                            <line x1="10" y1="2" x2="10" y2="4"></line>
                            <line x1="14" y1="2" x2="14" y2="4"></line>
                        </svg>
                    </span>
                    <div class="h-px w-16 bg-[#e6dbd1]"></div>
                </div>
                <p class="text-xl font-light text-slate-50 max-w-3xl mx-auto mt-8">
                    Jadwalkan pengalaman kopi spesial Anda dengan reservasi meja di <span
                        class="font-serif italic text-[#e6dbd1]">Coffee Shop</span>
                </p>
            </div>

            {{-- Menampilkan notifikasi sukses atau error --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Terjadi Kesalahan!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Denah Meja Section -->
                <div class="w-full lg:w-1/2">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-[#d7cdc3]">
                        <h3 class="text-2xl font-serif text-[#3a2a1d] mb-4">Denah Meja</h3>
                        <div class="bg-[#f5f1ec] p-4 rounded-lg border border-dashed border-[#d7cdc3]">
                            <img src="{{ asset('images/image.png') }}" alt="Denah Meja" class="w-full rounded-lg shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Sidebar Reservation -->
                <div class="w-full lg:w-1/2" x-data="{ selectedTable: '{{ old('nomor_meja') }}' }">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-[#d7cdc3]">
                        <h3 class="text-2xl font-serif text-[#3a2a1d] mb-6">Pilih Meja</h3>

                        <!-- Grid Meja Dinamis dari Model -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                            @php
                                $tables = $mejas->map(function ($meja) {
                                    $color = 'red'; // Default untuk 'Perbaikan'
                                    if ($meja->status === 'kosong') {
                                        $color = 'green';
                                    } elseif ($meja->status === 'dipesan') {
                                        $color = 'yellow';
                                    }
                                    return [
                                        'name' => $meja->nomor_meja,
                                        'status' => $meja->status,
                                        'color' => $color,
                                    ];
                                });
                            @endphp
                            <template x-for="table in {{ $tables->toJson() }}" :key="table.name">
                                <div class="relative p-4 rounded-lg text-center cursor-pointer transition transform duration-200 border"
                                    :class="{
                                        'bg-green-50 border-green-200 hover:shadow-md hover:scale-105': table
                                            .color === 'green',
                                        'bg-yellow-50 border-yellow-200 opacity-75 cursor-not-allowed': table
                                            .color === 'yellow',
                                        'bg-red-50 border-red-200 opacity-75 cursor-not-allowed': table
                                            .color === 'red',
                                        'ring-2 ring-[#6f4e37] ring-offset-2': selectedTable === table.name
                                    }"
                                    @click="if(table.color === 'green') selectedTable = table.name">
                                    <div class="flex justify-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            viewBox="0 0 24 24" fill="none"
                                            :stroke="table.color === 'green' ? '#16a34a' : table.color === 'yellow' ?
                                                '#ca8a04' : '#dc2626'"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="4" y="8" width="16" height="12" rx="2"></rect>
                                            <path d="M6 4h12"></path>
                                            <path d="M8 4v4"></path>
                                            <path d="M16 4v4"></path>
                                        </svg>
                                    </div>
                                    <div x-text="table.name" class="font-medium"
                                        :class="{
                                            'text-green-700': table.color === 'green',
                                            'text-yellow-700': table.color === 'yellow',
                                            'text-red-700': table.color === 'red'
                                        }">
                                    </div>
                                    <div x-text="table.status" class="text-sm mt-1"
                                        :class="{
                                            'text-green-600': table.color === 'green',
                                            'text-yellow-600': table.color === 'yellow',
                                            'text-red-600': table.color === 'red'
                                        }">
                                    </div>
                                </div>
                            </template>
                        </div>

                        <template x-if="!selectedTable">
                            <div class="bg-[#f8f5f2] p-4 rounded-lg border border-[#d7cdc3] flex items-start mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="#6f4e37" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="mr-3 mt-1">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                                <p class="text-sm text-gray-700">
                                    Silakan pilih meja yang berstatus <span
                                        class="text-green-600 font-medium">Tersedia</span> untuk melakukan reservasi.
                                </p>
                            </div>
                        </template>

                        <!-- Form Reservasi -->
                        <div x-show="selectedTable" x-transition class="mt-6 border-t border-[#d7cdc3] pt-6">
                            <h3 class="text-xl font-serif text-[#3a2a1d] mb-4">Detail Reservasi</h3>
                            <form action="{{ route('reservasi.store') }}" method="POST" class="space-y-5">
                                @csrf
                                <div>
                                    <label for="nomor_meja" class="block text-sm font-medium text-gray-700 mb-1">Meja yang
                                        Dipilih</label>
                                    <div class="flex">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-[#d7cdc3] bg-gray-50 text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="4" y="8" width="16" height="12" rx="2"></rect>
                                                <path d="M6 4h12"></path>
                                                <path d="M8 4v4"></path>
                                                <path d="M16 4v4"></path>
                                            </svg>
                                        </span>
                                        <input type="text" name="nomor_meja" x-model="selectedTable"
                                            class="flex-1 rounded-r-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]"
                                            readonly>
                                    </div>
                                </div>

                                <div>
                                    <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                        Pemesan</label>
                                    <div class="flex">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-[#d7cdc3] bg-gray-50 text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </span>
                                        <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}"
                                            required
                                            class="flex-1 rounded-r-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]">
                                    </div>
                                </div>

                                <div>
                                    <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">Nomor
                                        Telepon</label>
                                    <div class="flex">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-[#d7cdc3] bg-gray-50 text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path
                                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                </path>
                                            </svg>
                                        </span>
                                        <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required
                                            class="flex-1 rounded-r-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="tanggal_reservasi"
                                            class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                        <div class="flex">
                                            <span
                                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-[#d7cdc3] bg-gray-50 text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="3" y="4" width="18" height="18" rx="2"
                                                        ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6">
                                                    </line>
                                                    <line x1="8" y1="2" x2="8" y2="6">
                                                    </line>
                                                    <line x1="3" y1="10" x2="21" y2="10">
                                                    </line>
                                                </svg>
                                            </span>
                                            <input type="date" name="tanggal_reservasi"
                                                value="{{ old('tanggal_reservasi') }}" required
                                                class="flex-1 rounded-r-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="jam_reservasi"
                                            class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
                                        <div class="flex">
                                            <span
                                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-[#d7cdc3] bg-gray-50 text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <polyline points="12 6 12 12 16 14"></polyline>
                                                </svg>
                                            </span>
                                            <input type="time" name="jam_reservasi"
                                                value="{{ old('jam_reservasi') }}" required
                                                class="flex-1 rounded-r-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Catatan
                                        Tambahan</label>
                                    <textarea name="catatan" rows="3"
                                        class="w-full rounded-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]"
                                        placeholder="Masukkan permintaan khusus atau catatan tambahan di sini...">{{ old('catatan') }}</textarea>
                                </div>

                                <div class="pt-2">
                                    <button type="submit"
                                        class="w-full bg-[#6f4e37] text-white py-3 px-6 rounded-lg font-medium hover:bg-[#5d4130] transition duration-300 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5l7 7-7 7"></path>
                                        </svg>
                                        <span>Konfirmasi Reservasi</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
