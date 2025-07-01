<header x-data="{
    scrolled: false,
    isHome: window.location.pathname === '/',
    cartOpen: false,
    profileDrawerOpen: false,
    mobileMenuOpen: false
}" @scroll.window="scrolled = (window.scrollY > 50)" @click.away="mobileMenuOpen = false"
    :class="{ 'bg-[#e6dbd1] shadow-md': scrolled || !isHome }"
    class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between w-full px-6 py-4 transition-all duration-300 md:px-12 lg:px-24 font-jost"
    :style="{ color: (scrolled || !isHome) ? '#0f172a' : '#f8fafc' }">

    {{-- Logo --}}
    <a href="/" class="text-2xl font-semibold shrink-0">
        Coffee Shop
    </a>

    {{-- Desktop Menu --}}
    <nav class="hidden md:flex items-center gap-x-3 lg:gap-x-5 md:-translate-x-14">
        <a href="/"
            class="px-4 py-2 text-sm rounded-md transition-colors duration-300 {{ Request::is('/') ? 'bg-[#422424] text-white' : 'hover:bg-[#422424]/10' }}">
            Beranda
        </a>
        <a href="{{ route('menu.index') }}"
            class="px-4 py-2 text-sm rounded-md transition-colors duration-300 {{ Request::is('menu') ? 'bg-[#422424] text-white' : 'hover:bg-[#422424]/10' }}">
            Menu
        </a>
        <a href="{{ route('reservasi.index') }}"
            class="px-4 py-2 text-sm rounded-md transition-colors duration-300 {{ Request::is('reservasi*') ? 'bg-[#422424] text-white' : 'hover:bg-[#422424]/10' }}">
            Reservasi
        </a>
        <a href="{{ route('about-us') }}"
            class="px-4 py-2 text-sm rounded-md transition-colors duration-300 text-slate-950 {{ Request::is('about') ? 'bg-[#422424] text-white' : 'hover:bg-[#422424]/10' }}">
            Tentang Kami
        </a>
        <a href="{{ route('kontak') }}"
            class="px-4 py-2 text-sm rounded-md transition-colors duration-300 text-slate-950 {{ Request::is('contact-us') ? 'bg-[#422424] text-white' : 'hover:bg-[#422424]/10' }}">
            Kontak
        </a>
    </nav>

    {{-- Right-side Icons & Auth --}}
    <div class="flex items-center gap-x-2 md:gap-x-4">
        @auth
            {{-- Cart Icon --}}
            <a href="{{ route('keranjang.index') }}"
                class="relative p-2 rounded-full hover:bg-[#422424]/10 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </a>

            {{-- Profile Avatar --}}
            <div @click="profileDrawerOpen = !profileDrawerOpen" class="cursor-pointer">
                @if (Auth::user()->profile_photo)
                    <div class="w-10 h-10 rounded-full overflow-hidden border-2"
                        :class="(scrolled || !isHome) ? 'border-gray-700' : 'border-white/50'">
                        <img alt="{{ Auth::user()->name }}" src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                            class="object-cover w-full h-full" />
                    </div>
                @else
                    <div
                        class="relative flex items-center justify-center w-10 h-10 overflow-hidden bg-[#422424] rounded-full shadow-lg">
                        <span class="text-lg font-bold text-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strpos(Auth::user()->name, ' ') ? strtoupper(substr(Auth::user()->name, strpos(Auth::user()->name, ' ') + 1, 1)) : '' }}
                        </span>
                    </div>
                @endif
            </div>
        @else
            {{-- Login Button for Guests --}}
            <div class="hidden md:block">
                <a href="/login"
                    class="px-4 py-2 text-sm transition-colors duration-300 border rounded-md border-slate-950 text-slate-950"
                    :class="(scrolled || !isHome) ? 'border-slate-800 hover:bg-slate-800 hover:text-white' :
                    ' hover:bg-white hover:text-slate-800'">
                    Masuk
                </a>
            </div>
        @endguest

        {{-- Mobile Menu Hamburger Button --}}
        <div class="md:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-inset"
                :class="(scrolled || !isHome) ? 'focus:ring-slate-800' : 'focus:ring-white'">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-4"
        class="absolute top-full left-0 w-full bg-[#e6dbd1] shadow-lg md:hidden">
        <nav class="flex flex-col px-6 pt-2 pb-4 space-y-2 text-slate-950">
            <a href="/" class="block px-4 py-3 rounded-md hover:bg-[#422424]/10">Beranda</a>
            <a href="{{ route('menu.index') }}" class="block px-4 py-3 rounded-md hover:bg-[#422424]/10">Menu</a>
            <a href="{{ route('reservasi.index') }}"
                class="block px-4 py-3 rounded-md hover:bg-[#422424]/10">Reservasi</a>
            <a href="{{ route('about-us') }}" class="block px-4 py-3 rounded-md hover:bg-[#422424]/10">Tentang Kami</a>
            <a href="{{ route('kontak') }}" class="block px-4 py-3 rounded-md hover:bg-[#422424]/10">Kontak</a>
            @guest
                <a href="/login"
                    class="block px-4 py-3 border-t border-gray-300/50 rounded-md hover:bg-[#422424]/10">Masuk</a>
            @endguest
        </nav>
    </div>

    {{-- Profile Drawer --}}
    @auth
        <div x-show="profileDrawerOpen" @click.away="profileDrawerOpen = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-full"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-full"
            class="fixed inset-y-0 right-0 w-full max-w-sm bg-white shadow-xl z-50 overflow-y-auto text-slate-950"
            style="display: none;">

            <div class="flex flex-col items-center p-6 text-center border-b">
                @if (Auth::user()->profile_photo)
                    <img class="object-cover w-24 h-24 border-4 rounded-full border-green-500"
                        src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}">
                @else
                    <div
                        class="flex items-center justify-center w-24 h-24 bg-[#422424] border-4 rounded-full border-green-500">
                        <span
                            class="text-4xl font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strpos(Auth::user()->name, ' ') ? strtoupper(substr(Auth::user()->name, strpos(Auth::user()->name, ' ') + 1, 1)) : '' }}</span>
                    </div>
                @endif
                <h2 class="mt-4 text-xl font-semibold">{{ Auth::user()->name }}</h2>
                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
            </div>

            <div class="p-4">
                <a href="{{ route('user.transaksi.index') }}"
                    class="flex items-center justify-between w-full px-4 py-3 text-left rounded-md hover:bg-gray-100">
                    <span>Pesanan Saya</span>
                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </a>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center justify-between w-full px-4 py-3 text-left rounded-md hover:bg-gray-100">
                    <span>Profile Saya</span>
                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </a>
                <a href="{{ route('reservasi.history') }}"
                    class="flex items-center justify-between w-full px-4 py-3 text-left rounded-md hover:bg-gray-100">
                    <span>Riwayat Reservasi</span>
                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </a>
                <div class="pt-2 mt-2 border-t">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-3 text-left text-red-600 rounded-md hover:bg-gray-100">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</header>
