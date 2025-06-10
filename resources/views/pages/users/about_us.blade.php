@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
    <section class=" text-gray-800 py-24 ">
        <div class="">
            <!-- Elegant Header -->
            <div class="text-center mb-16">
                <h2 class="text-5xl font-serif italic mb-6  text-[#e6dbd1]">Tentang Kami</h2>
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
                    Selamat datang di <span class="font-serif italic text-[#e6dbd1]">Coffee Shop</span>, tempat di mana
                    kopi berkualitas, cerita inspiratif, dan kehangatan berpadu dalam setiap cangkir yang kami sajikan.
                </p>
            </div>

            <!-- Story & Vision Section -->
            <div class="grid md:grid-cols-2 gap-16 mb-24">
                <div class="bg-[#e6dbd1] bg-opacity-70 p-8 rounded-xl shadow-sm border border-[#d7cdc3]">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full bg-[#6f4e37] flex items-center justify-center text-white mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"></path>
                                <path d="M7 2v20"></path>
                                <path d="M21 15c0 2.8-2.2 5-5 5h-4"></path>
                                <path d="M16 10a4 4 0 0 0-4 4v6"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-serif text-[#3a2a1d]">Cerita Kami</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed">
                        Dirintis pada tahun <span class="font-medium">2020</span>, kami memulai perjalanan ini dengan satu
                        tujuan sederhana:
                        menghadirkan cita rasa kopi terbaik dari petani-petani lokal Indonesia yang penuh dedikasi.
                    </p>
                    <p class="text-gray-700 leading-relaxed mt-4">
                        Kami meyakini bahwa secangkir kopi bukan sekadar minuman, melainkan sebuah karya seni, momen
                        berharga,
                        dan bagian dari gaya hidup yang memperkaya jiwa.
                    </p>
                </div>

                <div class="bg-[#e6dbd1] bg-opacity-70 p-8 rounded-xl shadow-sm border border-[#d7cdc3]">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full bg-[#6f4e37] flex items-center justify-center text-white mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="10" r="3"></circle>
                                <path d="M7 16.3c0-1 1.2-2.1 2.7-2.6a9 9 0 0 1 8.6 0c1.5.5 2.7 1.6 2.7 2.6"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-serif text-[#3a2a1d]">Visi & Misi</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <span class="text-[#6f4e37] mr-3">◆</span>
                            <p class="text-gray-700">Menjadi pelopor gaya hidup kopi lokal berkualitas yang menginspirasi
                            </p>
                        </div>
                        <div class="flex items-start">
                            <span class="text-[#6f4e37] mr-3">◆</span>
                            <p class="text-gray-700">Membangun ekosistem berkelanjutan yang mendukung petani kopi lokal</p>
                        </div>
                        <div class="flex items-start">
                            <span class="text-[#6f4e37] mr-3">◆</span>
                            <p class="text-gray-700">Menciptakan ruang yang memikat, nyaman, dan menginspirasi kreativitas
                            </p>
                        </div>
                        <div class="flex items-start">
                            <span class="text-[#6f4e37] mr-3">◆</span>
                            <p class="text-gray-700">Menghadirkan pengalaman kopi yang otentik dan berkesan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What Makes Us Different -->
            <div class="bg-[#422424] text-white p-12 rounded-2xl shadow-xl mb-24 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-48 h-48 bg-[#6f4e37] opacity-10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#6f4e37] opacity-10 rounded-full -ml-32 -mb-32"></div>

                <h3 class="text-3xl font-serif mb-10 text-center relative z-10">Apa yang Membuat Kami Berbeda</h3>

                <div class="grid md:grid-cols-3 gap-8 relative z-10">
                    <div class="bg-[#e6dbd1] bg-opacity-10 p-6 rounded-xl backdrop-filter backdrop-blur-sm">
                        <div class="w-16 h-16 bg-[#6f4e37] rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M7 13a3 3 0 0 0 3-3V4a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v6a3 3 0 0 0 3 3"></path>
                                <path d="M19 11h-8v2a3 3 0 0 0 6 0"></path>
                                <path d="M12 19a2 2 0 0 1-2-2v-2a2 2 0 1 1 4 0v2a2 2 0 0 1-2 2"></path>
                            </svg>
                        </div>
                        <h4 class="font-serif text-slate-950 text-xl text-center mb-2">Kopi dari Hati</h4>
                        <p class="text-slate-950 text-center text-sm">Biji kopi pilihan dari petani lokal terbaik yang
                            diproses dengan penuh dedikasi.</p>
                    </div>

                    <div class="bg-[#e6dbd1] bg-opacity-10 p-6 rounded-xl backdrop-filter backdrop-blur-sm">
                        <div class="w-16 h-16 bg-[#6f4e37] rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                        <h4 class="font-serif text-slate-950 text-xl text-center mb-2">Suasana Elegan</h4>
                        <p class="text-slate-950 text-center text-sm">Ruang yang dirancang dengan perhatian pada detail,
                            kenyamanan, dan estetika.</p>
                    </div>

                    <div class="bg-[#e6dbd1] bg-opacity-10 p-6 rounded-xl backdrop-filter backdrop-blur-sm">
                        <div class="w-16 h-16 bg-[#6f4e37] rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M19 9V8a1 1 0 0 0-1-1h-1"></path>
                                <path d="M6 8h8"></path>
                                <path d="M6 12h8"></path>
                                <path d="M9 16h5"></path>
                                <path d="M4 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"></path>
                            </svg>
                        </div>
                        <h4 class="font-serif text-slate-950 text-xl text-center mb-2">Barista Ahli</h4>
                        <p class="text-slate-950 text-center text-sm">Tim profesional yang mengolah kopi dengan keahlian,
                            seni, dan dedikasi tinggi.</p>
                    </div>
                </div>
            </div>

            <!-- Location & Contact -->
            <div class="grid md:grid-cols-2 gap-12 mb-16">
                <div
                    class="bg-[#e6dbd1] bg-opacity-70 p-8 rounded-xl shadow-sm border border-[#d7cdc3] flex flex-col items-center">
                    <div class="w-16 h-16 bg-[#6f4e37] rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                            fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-serif text-[#3a2a1d] mb-4">Lokasi Kami</h3>
                    <address class="text-gray-700 text-center not-italic">
                        <p class="text-lg mb-1">Jl. Kopi Hangat No. 1</p>
                        <p class="text-lg">Makassar, Indonesia</p>
                    </address>
                    <div class="mt-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="#6f4e37" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M3 12a9 9 0 1 0 18 0 9 9 0 0 0-18 0"></path>
                            <path d="M12 7v5l2.5 2.5"></path>
                        </svg>
                        <span class="ml-2 text-gray-700">Buka setiap hari, 08:00 - 22:00</span>
                    </div>
                </div>

                <div
                    class="bg-[#e6dbd1] bg-opacity-70 p-8 rounded-xl shadow-sm border border-[#d7cdc3] flex flex-col items-center">
                    <div class="w-16 h-16 bg-[#6f4e37] rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                            fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2v5Z"></path>
                            <path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-serif text-[#3a2a1d] mb-4">Mari Terhubung</h3>
                    <div class="space-y-3 text-center">
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="#6f4e37" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                            <a href="mailto:hello@namacoffeeshop.com"
                                class="ml-2 text-[#6f4e37] hover:underline">hello@namacoffeeshop.com</a>
                        </div>
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="#6f4e37" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect width="20" height="20" x="2" y="2" rx="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                            <a href="#" class="ml-2 text-[#6f4e37] hover:underline">@namacoffeeshop</a>
                        </div>
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="#6f4e37" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                            <a href="tel:+628123456789" class="ml-2 text-[#6f4e37] hover:underline">+62 812-3456-789</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quote -->
            <div class="text-center mt-16 mb-8">
                <div class=" inline-block mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"
                        fill="none" stroke="#e6dbd1" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z">
                        </path>
                        <path
                            d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z">
                        </path>
                    </svg>
                </div>
                <blockquote class="text-2xl italic font-serif text-slate-50 max-w-3xl mx-auto">
                    Lebih dari sekadar kopi, ini tentang kenangan yang terukir dalam setiap tegukan.
                </blockquote>
                <div class=" inline-block mt-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"
                        fill="none" stroke="#e6dbd1" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z">
                        </path>
                        <path
                            d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </section>
@endsection
