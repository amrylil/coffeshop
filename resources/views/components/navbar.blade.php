<header x-data="{
    scrolled: false,
    isHome: window.location.pathname === '/',
    cartOpen: false,
    profileDrawerOpen: false
}" @scroll.window="scrolled = (window.scrollY > window.innerHeight * 0.1)"
    :class="isHome && scrolled ? 'bg-[#e6dbd1] transition-all duration-200' : ''"
    class="flex {{ Request::is('/') ? '' : 'bg-[#e6dbd1]' }} top-0 justify-between items-center py-4 px-24  z-50  w-full fixed font-jost">
    {{-- logo --}}
    <div x-data="{
        scrolled: false,
        isHome: window.location.pathname === '/'
    }" @scroll.window="scrolled = (window.scrollY > window.innerHeight * 0.1)"
        :class="scrolled ? 'text-slate-950' : 'text-slate-50'"
        class="text-2xl font-semibold  {{ Request::is('/') ? '' : 'text-slate-950' }}">
        Coffee Shop
    </div>

    {{-- menu --}}
    <nav class="space-x-5 flex">
        <a href="/" x-data="{
            scrolled: false,
            isHome: window.location.pathname === '/'
        }" @scroll.window="scrolled = (window.scrollY > window.innerHeight * 0.1)"
            :class="isHome && scrolled ? 'text-slate-950' : 'text-slate-50'"
            class="rounded text-slate-50 hover:text-white {{ Request::is('/') ? 'bg-[#422424] text-white' : 'text-slate-950 ' }} px-4 py-2 hover:bg-[#422424]"
            style="transition: background-color 0.3s;">Beranda</a>

        <a href="/menu" x-data="{
            scrolled: false,
            isHome: window.location.pathname === '/'
        }"
            @scroll.window="scrolled = (window.scrollY > window.innerHeight * 0.1)"
            :class="isHome && scrolled ? 'text-slate-950' : 'text-slate-50'"
            class="rounded hover:bg-[#422424] hover:text-white {{ Request::is('/') ? 'text-slate-50' : (Request::is('menu') ? 'text-white bg-[#422424]' : 'text-slate-950') }} px-4 py-2 "
            style="transition: background-color 0.3s;">Menu</a>

        <a href="/reservasi" x-data="{
            scrolled: false,
            isHome: window.location.pathname === '/'
        }"
            @scroll.window="scrolled = (window.scrollY > window.innerHeight * 0.1)"
            :class="isHome && scrolled ? 'text-slate-950' : 'text-slate-50'"
            class="rounded hover:bg-[#422424] text-slate-50 hover:text-white {{ Request::is('/') ? 'text-slate-50' : (Request::is('reservasi') ? 'text-white bg-[#422424]' : 'text-slate-950') }}  px-4 py-2 "
            style="transition: background-color 0.3s;">Reservasi</a>

        <a href="/about"
            class="rounded hover:bg-[#422424] text-gray-900 hover:text-white {{ Request::is('about') ? 'bg-[#422424] text-white' : '' }} px-4 py-2 "
            style="transition: background-color 0.3s;">Tentang Kami</a>

        <a href="/contact-us"
            class="rounded hover:bg-[#422424] text-gray-900 hover:text-white {{ Request::is('contact-us') ? 'bg-[#422424] text-white' : '' }} px-4 py-2 "
            style="transition: background-color 0.3s;">Kontak</a>
    </nav>

    {{-- auth --}}
    @if (Auth::check())
        {{-- Jika pengguna sudah login --}}
        <div class="flex gap-2 justify-center items-center">
            <!-- Cart Button -->
            <div @click="cartOpen = !cartOpen" class="cursor-pointer">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <div class="indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cart Drawer -->
            <div x-show="cartOpen" @click.away="cartOpen = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform translate-x-full"
                class="fixed inset-y-0 right-0 w-96 bg-white shadow-xl z-50 overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Keranjang</h2>
                        <button @click="cartOpen = false" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Cart Items -->
                    <div class="space-y-4">
                        <!-- Cart item examples here -->
                        <div class="flex items-center justify-between border-b pb-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset('images/produk.png') }}" alt="Product"
                                    class="w-16 h-16 object-cover rounded">
                                <div>
                                    <h3 class="font-medium">Cappuccino</h3>
                                    <p class="text-sm text-gray-500">Rp 25.000</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button
                                    class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center">-</button>
                                <span>1</span>
                                <button
                                    class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center">+</button>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Total -->
                    <div class="mt-6 border-t pt-4">
                        <div class="flex justify-between mb-2">
                            <span>Subtotal</span>
                            <span>Rp 25.000</span>
                        </div>
                        <button
                            class="w-full bg-[#422424] text-white py-3 rounded-lg mt-4 hover:bg-[#593131] transition-colors">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>

            <!-- Profile Drawer Button -->
            <div @click="profileDrawerOpen = !profileDrawerOpen" class="cursor-pointer">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div
                        class="relative w-10 h-10 overflow-hidden  rounded-full border-2 border-white bg-[#422424] shadow-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">
                            {{ strtoupper(substr(Auth::user()->name_222297, 0, 1)) }}{{ strpos(Auth::user()->name_222297, ' ') ? strtoupper(substr(Auth::user()->name_222297, strpos(Auth::user()->name_222297, ' ') + 1, 1)) : '' }}
                        </span>
                        <div class="absolute inset-0 bg-white opacity-10 rounded-full mix-blend-overlay"></div>
                    </div>
                </div>
            </div>

            <!-- Profile Drawer -->
            <div x-show="profileDrawerOpen" @click.away="profileDrawerOpen = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform translate-x-full"
                class="fixed inset-y-0 right-0 w-96 bg-white shadow-xl z-50 overflow-hidden">

                <!-- Profile content -->
                <div class="flex flex-col items-center bg-white w-full h-screen">
                    <!-- Profile Section -->
                    <div class="rounded-lg w-full max-w-md p-6 text-center bg-white shadow-md">
                        <div class="flex justify-center">
                            <div class="w-32 h-32 rounded-full border-4 border-green-600 flex items-center justify-center"
                                style="background-color: #422424;">
                                <span class="text-white text-4xl font-bold">
                                    {{ strtoupper(substr(session('name'), 0, 1)) }}{{ strpos(session('name'), ' ') ? strtoupper(substr(session('name'), strpos(session('name'), ' ') + 1, 1)) : '' }}
                                </span>
                            </div>
                        </div>
                        <h2 class="mt-4 text-2xl font-semibold text-gray-800">{{ session('name') }}</h2>
                        <p class="text-gray-500 text-sm">{{ session('email') }}</p>
                    </div>

                    <div class="w-full max-w-md h-[60vh] bg-gray-100 rounded-t-3xl shadow-lg p-6">
                        <h3 class="text-gray-700 font-semibold mb-2">Preferences</h3>
                        <a href="#" class="flex items-center justify-between py-3 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <svg class="group-hover:stroke-black stroke-black" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" height="20" width="20">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4Z" />
                                </svg>
                                <p class="text-gray-700">Profile Saya</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center justify-between py-3 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    height="16" width="16">
                                    <path d="M6 6h15l-1.5 9H7.5L6 6z" />
                                    <circle cx="9" cy="20" r="1" />
                                    <circle cx="18" cy="20" r="1" />
                                    <path d="M6 6l-2 0" />
                                </svg>
                                <p class="text-gray-700">Pesanan Saya</p>
                            </div>
                        </a>
                        <a href="#" class="flex items-center justify-between py-3 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-0.5 -0.5 16 16" fill="none"
                                    stroke="#000000" stroke-linecap="round" stroke-linejoin="round"
                                    id="History--Streamline-Tabler" height="16" width="16">
                                    <desc>History Streamline Icon: https://streamlinehq.com</desc>
                                    <path d="m7.5 5 0 2.5 1.25 1.25" stroke-width="1"></path>
                                    <path d="M1.90625 6.875a5.625 5.625 0 1 1 0.3125 2.5m-0.3125 3.125v-3.125h3.125"
                                        stroke-width="1"></path>
                                </svg>
                                <p class="text-gray-700">Riwayat Transaksi</p>
                            </div>
                        </a>
                        <a href="#" class="flex items-center justify-between py-3 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-0.5 -0.5 16 16" fill="none"
                                    stroke="#000000" stroke-linecap="round" stroke-linejoin="round"
                                    id="Shopping-Cart--Streamline-Tabler" height="16" width="16">
                                    <desc>Shopping Cart Streamline Icon: https://streamlinehq.com</desc>
                                    <path d="M2.5 11.875a1.25 1.25 0 1 0 2.5 0 1.25 1.25 0 1 0 -2.5 0"
                                        stroke-width="1"></path>
                                    <path d="M9.375 11.875a1.25 1.25 0 1 0 2.5 0 1.25 1.25 0 1 0 -2.5 0"
                                        stroke-width="1"></path>
                                    <path d="M10.625 10.625H3.75V1.875H2.5" stroke-width="1"></path>
                                    <path d="m3.75 3.125 8.75 0.625 -0.625 4.375H3.75" stroke-width="1"></path>
                                </svg>
                                <p class="text-gray-700">Keranjang</p>
                            </div>
                        </a>

                        <div class="flex items-center justify-between py-3">
                            <div class="flex items-center space-x-3 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-0.5 -0.5 16 16" fill="none"
                                    stroke="#dc2626" stroke-linecap="round" stroke-linejoin="round"
                                    id="Logout-2--Streamline-Tabler" height="16" width="16">
                                    <desc>Logout 2 Streamline Icon: https://streamlinehq.com</desc>
                                    <path
                                        d="M6.25 5V3.75a1.25 1.25 0 0 1 1.25 -1.25h4.375a1.25 1.25 0 0 1 1.25 1.25v7.5a1.25 1.25 0 0 1 -1.25 1.25h-4.375a1.25 1.25 0 0 1 -1.25 -1.25v-1.25"
                                        stroke-width="1"></path>
                                    <path d="M9.375 7.5H1.875l1.875 -1.875" stroke-width="1"></path>
                                    <path d="m3.75 9.375 -1.875 -1.875" stroke-width="1"></path>
                                </svg>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Jika pengguna belum login --}}
        <div class="space-x-2">
            <a href="/login"
                class="border rounded hover:bg-[#422424] hover:text-slate-50  py-2 px-4 -lg text-slate-950 ">Masuk</a>
        </div>
    @endif
</header>
