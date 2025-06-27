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
    <nav class="space-x-5 flex -translate-x-14">
        <a href="/" x-data="{
            scrolled: false,
            isHome: window.location.pathname === '/'
        }" @scroll.window="scrolled = (window.scrollY > window.innerHeight * 0.1)"
            :class="isHome && scrolled ? 'text-slate-950' : 'text-slate-50'"
            class="rounded text-slate-50 hover:text-white {{ Request::is('/') ? 'bg-[#422424] text-white' : 'text-slate-950 ' }} px-4 py-2 hover:bg-[#422424]"
            style="transition: background-color 0.3s;">Beranda</a>

        <a href="{{ route('menu.index') }}" x-data="{
            scrolled: false,
            isHome: window.location.pathname === '/'
        }"
            @scroll.window="scrolled = (window.scrollY > window.innerHeight * 0.1)"
            :class="isHome && scrolled ? 'text-slate-950' : 'text-slate-50'"
            class="rounded hover:bg-[#422424] hover:text-white {{ Request::is('/') ? 'text-slate-50' : (Request::is('menu') ? 'text-white bg-[#422424]' : 'text-slate-950') }} px-4 py-2 "
            style="transition: background-color 0.3s;">Menu</a>

        <a href="{{ route('reservasi.index') }}" x-data="{
            scrolled: false,
            isHome: window.location.pathname === '/'
        }"
            @scroll.window="scrolled = (window.scrollY > window.innerHeight * 0.1)"
            :class="isHome && scrolled ? 'text-slate-950' : 'text-slate-50'"
            class="rounded hover:bg-[#422424] text-slate-50 hover:text-white {{ Request::is('/') ? 'text-slate-50' : (Request::is('reservasi.index') ? 'text-white bg-[#422424]' : 'text-slate-950') }}  px-4 py-2 "
            style="transition: background-color 0.3s;">Reservasi</a>

        <a href="{{ route('about-us') }}"
            class="rounded hover:bg-[#422424] text-gray-900 hover:text-white {{ Request::is('about') ? 'bg-[#422424] text-white' : '' }} px-4 py-2 "
            style="transition: background-color 0.3s;">Tentang Kami</a>

        <a href="{{ route('kontak') }}"
            class="rounded hover:bg-[#422424] text-gray-900 hover:text-white {{ Request::is('contact-us') ? 'bg-[#422424] text-white' : '' }} px-4 py-2 "
            style="transition: background-color 0.3s;">Kontak</a>
    </nav>

    {{-- auth --}}
    @if (Auth::check())
        {{-- Jika pengguna sudah login --}}
        <div class="flex gap-2 justify-center items-center">
            <!-- Cart Button -->
            <div class="cursor-pointer">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <a href="{{ route('keranjang.index') }}">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </a>
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



                </div>
            </div>

            <!-- Profile Drawer Button -->
            <div @click="profileDrawerOpen = !profileDrawerOpen" class="cursor-pointer">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">

                    {{-- Cek apakah user memiliki foto profil --}}
                    @if (Auth::user()->profile_photo_222297)
                        {{-- JIKA ADA: Tampilkan gambar dari storage --}}
                        <div class="w-10 h-10  rounded-full overflow-hidden border border-green-600">
                            <img alt="{{ Auth::user()->name_222297 }}"
                                src="{{ asset('storage/' . Auth::user()->profile_photo_222297) }}"
                                class="w-full h-full object-cover" />
                        </div>
                    @else
                        {{-- JIKA TIDAK ADA: Tampilkan inisial nama (kode asli Anda) --}}
                        <div
                            class="relative w-10 h-10 overflow-hidden rounded-full border-2 border-white bg-[#422424] shadow-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">
                                {{-- Logika untuk mendapatkan 1 atau 2 huruf inisial --}}
                                {{ strtoupper(substr(Auth::user()->name_222297, 0, 1)) }}{{ strpos(Auth::user()->name_222297, ' ') ? strtoupper(substr(Auth::user()->name_222297, strpos(Auth::user()->name_222297, ' ') + 1, 1)) : '' }}
                            </span>
                            <div class="absolute inset-0 bg-white opacity-10 rounded-full mix-blend-overlay"></div>
                        </div>
                    @endif

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

                            {{-- Cek apakah user yang login memiliki foto profil --}}
                            @if (Auth::user() && Auth::user()->profile_photo_222297)
                                {{-- JIKA ADA: Tampilkan gambar profil --}}
                                <img class="w-32 h-32 rounded-full border-4 border-green-600 object-cover"
                                    src="{{ asset('storage/' . Auth::user()->profile_photo_222297) }}"
                                    alt="{{ Auth::user()->name_222297 }}">
                            @else
                                {{-- JIKA TIDAK ADA: Tampilkan inisial nama (kode asli Anda) --}}
                                <div class="w-32 h-32 rounded-full border-4 border-green-600 flex items-center justify-center"
                                    style="background-color: #422424;">
                                    <span class="text-white text-4xl font-bold">
                                        {{ strtoupper(substr(session('name'), 0, 1)) }}{{ strpos(session('name'), ' ') ? strtoupper(substr(session('name'), strpos(session('name'), ' ') + 1, 1)) : '' }}
                                    </span>
                                </div>
                            @endif

                        </div>

                        <h2 class="mt-4 text-2xl font-semibold text-gray-800">{{ session('name') }}</h2>
                        <p class="text-gray-500 text-sm">{{ session('email') }}</p>
                    </div>
                    <div
                        class="w-full max-w-md h-[60vh] bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl p-6 border border-white/20">
                        <a href="{{ route('user.transaksi.index') }}" class="block">
                            <div
                                class="flex items-center justify-between py-4 px-4 rounded-2xl menu-item border-b border-gray-100">
                                <div class="flex font-semibold items-center space-x-3 text-slate-800 menu-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                    <span class="ml-1">Pesanan Saya</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </div>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block">
                            <div
                                class="flex items-center justify-between py-4 px-4 rounded-2xl menu-item border-b border-gray-100">
                                <div class="flex font-semibold items-center space-x-3 text-slate-800 menu-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                    <span class="ml-1">Profile Saya</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </div>
                        </a>

                        <a href="{{ route('reservasi.history') }}" class="block">
                            <div
                                class="flex items-center justify-between py-4 px-4 rounded-2xl menu-item border-b border-gray-100">
                                <div class="flex font-semibold items-center space-x-3 text-slate-800 menu-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2"
                                            ry="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    <span class="ml-1">Riwayat Reservasi</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </div>
                        </a>

                        <a href="{{ route('keranjang.index') }}" class="block">
                            <div
                                class="flex items-center justify-between py-4 px-4 rounded-2xl menu-item border-b border-gray-100">
                                <div class="flex font-semibold items-center space-x-3 text-slate-800 menu-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="8" cy="21" r="1" />
                                        <circle cx="19" cy="21" r="1" />
                                        <path
                                            d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                                    </svg>
                                    <span class="ml-1">Keranjang</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </div>
                        </a>

                        <div class="flex items-center justify-between py-3">
                            <div class="flex items-center space-x-3 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-0.5 -0.5 16 16" fill="none"
                                    stroke="
#dc2626" stroke-linecap="round" stroke-linejoin="round"
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
