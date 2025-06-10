@extends('layouts.app')

@section('title', 'Reservasi')

@section('content')
    <section class="">
        <div class="py-12">
            <!-- Elegant Header -->
            <div class="text-center mb-16">
                <h2 class="text-5xl font-serif italic mb-6  text-[#e6dbd1]">Reservasi</h2>
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
                <div class="w-full lg:w-1/2" x-data="{ selectedTable: '' }">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-[#d7cdc3]">
                        <h3 class="text-2xl font-serif text-[#3a2a1d] mb-6">Pilih Meja</h3>

                        <!-- Grid Meja -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                            <template
                                x-for="table in [
                                { name: 'T-01', status: 'Tersedia', color: 'green' },
                                { name: 'T-02', status: 'Dipesan', color: 'yellow' },
                                { name: 'T-03', status: 'Dipesan', color: 'yellow' },
                                { name: 'T-04', status: 'Tersedia', color: 'green' },
                                { name: 'T-05', status: 'Tersedia', color: 'green' },
                                { name: 'T-06', status: 'Tersedia', color: 'green' }
                            ]"
                                :key="table.name">
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
                            <form action="#" method="POST" class="space-y-5">
                                @csrf
                                <div>
                                    <label for="table" class="block text-sm font-medium text-gray-700 mb-1">Meja yang
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
                                        <input type="text" name="table" x-model="selectedTable"
                                            class="flex-1 rounded-r-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]"
                                            readonly>
                                    </div>
                                </div>

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama
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
                                        <input type="text" name="name" required
                                            class="flex-1 rounded-r-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]">
                                    </div>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor
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
                                        <input type="tel" name="phone" required
                                            class="flex-1 rounded-r-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="date"
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
                                            <input type="date" name="date" required
                                                class="flex-1 rounded-r-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="time"
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
                                            <input type="time" name="time" required
                                                class="flex-1 rounded-r-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="guests" class="block text-sm font-medium text-gray-700 mb-1">Jumlah
                                        Tamu</label>
                                    <div class="flex">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-[#d7cdc3] bg-gray-50 text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                        </span>
                                        <select name="guests" required
                                            class="flex-1 rounded-r-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]">
                                            <option value="">Pilih jumlah tamu</option>
                                            <option value="1">1 orang</option>
                                            <option value="2">2 orang</option>
                                            <option value="3">3 orang</option>
                                            <option value="4">4 orang</option>
                                            <option value="5">5 orang</option>
                                            <option value="6">6 orang</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan
                                        Tambahan</label>
                                    <textarea name="notes" rows="3"
                                        class="w-full rounded-md border border-[#d7cdc3] px-4 py-3 focus:ring-[#6f4e37] focus:border-[#6f4e37]"
                                        placeholder="Masukkan permintaan khusus atau catatan tambahan di sini..."></textarea>
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

            <!-- Reservation Information -->
            <div class="mt-12 bg-white p-8 rounded-xl shadow-sm border border-[#d7cdc3]">
                <h3 class="text-2xl font-serif text-[#3a2a1d] mb-6">Informasi Reservasi</h3>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="flex">
                        <div class="w-12 h-12 rounded-full bg-[#f8f5f2] flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="#6f4e37" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 2v1"></path>
                                <path d="M12 21v1"></path>
                                <path d="M4.22 4.22l.77.77"></path>
                                <path d="M19.02 19.02l.77.77"></path>
                                <path d="M2 12h1"></path>
                                <path d="M21 12h1"></path>
                                <path d="M4.22 19.78l.77-.77"></path>
                                <path d="M19.02 4.93l.77-.77"></path>
                                <circle cx="12" cy="12" r="9"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-[#3a2a1d]">Jam Operasional</h4>
                            <p class="text-gray-600 text-sm mt-1">Senin - Jumat: 08:00 - 22:00</p>
                            <p class="text-gray-600 text-sm">Sabtu - Minggu: 09:00 - 23:00</p>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-12 h-12 rounded-full bg-[#f8f5f2] flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="#6f4e37" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-[#3a2a1d]">Kebijakan Reservasi</h4>
                            <p class="text-gray-600 text-sm mt-1">Reservasi dapat dilakukan 3 jam sebelumnya</p>
                            <p class="text-gray-600 text-sm">Maksimal durasi reservasi 3 jam</p>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-12 h-12 rounded-full bg-[#f8f5f2] flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="#6f4e37" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-[#3a2a1d]">Konfirmasi</h4>
                            <p class="text-gray-600 text-sm mt-1">Konfirmasi akan dikirim melalui platform ini</p>
                            <p class="text-gray-600 text-sm">Harap tiba 15 menit sebelum jadwal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
