@extends('layouts.app')

@section('title', 'Kontak Kami')

@section('content')
    <section class="py-12">
        <div class="">
            <!-- Elegant Header -->
            <div class="text-center mb-16">
                <h2 class="text-5xl font-serif italic mb-6  text-[#e6dbd1]">Kontak Kami</h2>
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
                    Kami senang mendengar dari Anda. Jangan ragu untuk menghubungi kami dengan pertanyaan, saran, atau untuk
                    memesan kopi favorit Anda.
                </p>
            </div>

            <!-- Contact & Map Section -->
            <div class="grid md:grid-cols-2 gap-12 mb-20">
                <!-- Contact Form -->
                <div class="bg-slate-50 p-8 rounded-xl shadow-sm border border-[#d7cdc3]">
                    <h3 class="text-2xl font-serif text-[#3a2a1d] mb-6">Kirim Pesan</h3>

                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" name="name" id="name" required
                                class="w-full px-4 py-3 rounded-lg border border-[#d7cdc3] focus:ring-[#6f4e37] focus:border-[#6f4e37] transition">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" required
                                class="w-full px-4 py-3 rounded-lg border border-[#d7cdc3] focus:ring-[#6f4e37] focus:border-[#6f4e37] transition">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                            <input type="text" name="subject" id="subject"
                                class="w-full px-4 py-3 rounded-lg border border-[#d7cdc3] focus:ring-[#6f4e37] focus:border-[#6f4e37] transition">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea name="message" id="message" rows="5" required
                                class="w-full px-4 py-3 rounded-lg border border-[#d7cdc3] focus:ring-[#6f4e37] focus:border-[#6f4e37] transition"></textarea>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full bg-[#6f4e37] text-white py-3 px-6 rounded-lg font-medium hover:bg-[#5d4130] transition duration-300 flex items-center justify-center">
                                <span>Kirim Pesan</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="ml-2">
                                    <path d="m22 2-7 20-4-9-9-4Z"></path>
                                    <path d="M22 2 11 13"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="space-y-8">
                    <!-- Map -->
                    <div
                        class="bg-slate-50 p-6 rounded-xl shadow-sm border border-[#d7cdc3] h-64 flex items-center justify-center">
                        <!-- Placeholder for map - in real implementation, replace with actual map embed -->
                        <div class="text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round" class="mx-auto mb-3">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <p class="text-sm">Peta Lokasi</p>
                            <p class="text-xs mt-1">Di sini akan ditampilkan peta Google Maps</p>
                        </div>
                    </div>

                    <!-- Direct Contact -->
                    <div class="bg-slate-50 p-6 rounded-xl shadow-sm border border-[#d7cdc3]">
                        <h4 class="text-xl font-serif text-[#3a2a1d] mb-4">Hubungi Kami Langsung</h4>

                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div
                                    class="w-10 h-10 rounded-full bg-[#6f4e37] bg-opacity-10 flex items-center justify-center mr-4 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="#6f4e37" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="text-sm font-medium text-[#6f4e37]">Telepon</h5>
                                    <p class="text-gray-700">+62 812-3456-789</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-10 h-10 rounded-full bg-[#6f4e37] bg-opacity-10 flex items-center justify-center mr-4 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="#6f4e37" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="text-sm font-medium text-[#6f4e37]">Email</h5>
                                    <p class="text-gray-700">hello@namacoffeeshop.com</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-10 h-10 rounded-full bg-[#6f4e37] bg-opacity-10 flex items-center justify-center mr-4 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="#6f4e37" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="text-sm font-medium text-[#6f4e37]">Alamat</h5>
                                    <p class="text-gray-700">Jl. Kopi Hangat No. 1, <br>Makassar, Indonesia</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div class="bg-slate-50 p-6 rounded-xl shadow-sm border border-[#d7cdc3]">
                        <h4 class="text-xl font-serif text-[#3a2a1d] mb-4">Jam Operasional</h4>

                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-700">Senin - Jumat</span>
                                <span class="text-[#6f4e37] font-medium">08:00 - 22:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Sabtu</span>
                                <span class="text-[#6f4e37] font-medium">09:00 - 23:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Minggu</span>
                                <span class="text-[#6f4e37] font-medium">10:00 - 21:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="bg-[#422424] text-white p-10 rounded-2xl shadow-xl">
                <h3 class="text-2xl font-serif text-center mb-8">Temukan Kami di Media Sosial</h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <a href="#" class="group">
                        <div
                            class="w-16 h-16 rounded-full bg-slate-50 bg-opacity-10 flex items-center justify-center mx-auto mb-3 text-slate-950 group-hover:bg-[#6f4e37] group-hover:text-slate-50 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect width="20" height="20" x="2" y="2" rx="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </div>
                        <h4 class="font-medium">Instagram</h4>
                        <p class="text-gray-300 text-sm">@namacoffeeshop</p>
                    </a>

                    <a href="#" class="group">
                        <div
                            class="w-16 h-16 text-slate-950 rounded-full bg-slate-50 bg-opacity-10 flex items-center justify-center mx-auto mb-3 group-hover:bg-[#6f4e37] group-hover:text-slate-50 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-1-4.8 4-8.3 7.9-4.9 1.2-1.2 2-2.5 2.1-4z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="font-medium">Twitter</h4>
                        <p class="text-gray-300 text-sm">@namacoffeeshop</p>
                    </a>

                    <a href="#" class="group">
                        <div
                            class="w-16 h-16 text-slate-950 rounded-full bg-slate-50 bg-opacity-10 flex items-center justify-center mx-auto mb-3 group-hover:bg-[#6f4e37] group-hover:text-slate-50 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </div>
                        <h4 class="font-medium">Facebook</h4>
                        <p class="text-gray-300 text-sm">Nama Coffee Shop</p>
                    </a>

                    <a href="#" class="group">
                        <div
                            class="w-16 h-16 text-slate-950 rounded-full bg-slate-50 bg-opacity-10 flex items-center justify-center mx-auto mb-3  group-hover:bg-[#6f4e37] group-hover:text-slate-50 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17">
                                </path>
                                <path d="m10 15 5-3-5-3z"></path>
                            </svg>
                        </div>
                        <h4 class="font-medium">YouTube</h4>
                        <p class="text-gray-300 text-sm">Nama Coffee Shop</p>
                    </a>
                </div>
            </div>



            <!-- Small FAQ -->
            <div class="mt-16 p-6 bg-[#e6dbd1] rounded-xl">
                <h3 class="text-2xl font-serif text-[#3a2a1d] mb-6 text-center">Pertanyaan Umum</h3>

                <div class="space-y-4">
                    <div class="bg-slate-50 p-6 rounded-xl shadow-sm border border-[#d7cdc3]">
                        <button class="flex justify-between items-center w-full text-left">
                            <h4 class="text-lg font-medium text-[#3a2a1d]">Apakah kalian menyediakan layanan antar?</h4>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="#6f4e37" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg>
                        </button>
                        <div class="mt-2 text-gray-700">
                            <p>Ya, kami menyediakan layanan pengantaran untuk area tertentu di Makassar. Silakan hubungi
                                kami untuk informasi lebih lanjut.</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-6 rounded-xl shadow-sm border border-[#d7cdc3]">
                        <button class="flex justify-between items-center w-full text-left">
                            <h4 class="text-lg font-medium text-[#3a2a1d]">Apakah tersedia ruangan untuk acara privat?</h4>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="#6f4e37" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg>
                        </button>
                        <div class="mt-2 text-gray-700">
                            <p>Ya, kami memiliki ruangan khusus yang dapat digunakan untuk acara privat, meeting, atau
                                gathering. Silakan kontak kami untuk reservasi dan informasi harga.</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-6 rounded-xl shadow-sm border border-[#d7cdc3]">
                        <button class="flex justify-between items-center w-full text-left">
                            <h4 class="text-lg font-medium text-[#3a2a1d]">Apakah kalian menawarkan pilihan makanan
                                vegetarian?</h4>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="#6f4e37" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg>
                        </button>
                        <div class="mt-2 text-gray-700">
                            <p>Tentu, kami menyediakan berbagai pilihan menu vegetarian dan vegan. Anda dapat melihat menu
                                lengkap kami di halaman Menu atau menanyakan langsung kepada staff kami.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
