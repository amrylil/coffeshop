<!-- Simplified Coffee Shop Sidebar -->
<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Main navigation" x-data="{ activeLink: window.location.pathname }">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white text-amber-900 shadow-md flex flex-col">
        <!-- Logo Header -->
        <div class="bg-[#6F4E37] rounded-lg flex justify-center items-center p-3 mb-6">
            <h1 class="font-jost text-2xl font-bold text-white">COFFEESHOP</h1>
        </div>

        <!-- Navigation Menu -->
        <nav aria-label="Main menu" class="flex-grow">
            <ul class="space-y-1 font-medium px-1">
                <!-- Management Section -->
                <li class="pt-3 pb-1">
                    <div class="text-xs uppercase font-semibold text-amber-600 px-2">Management</div>
                </li>

                <!-- Menu -->
                <li>
                    <a href="{{ route('admin.menu.index') }}"
                        class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                        :class="activeLink === '/admin/menu' ? 'bg-[#6F4E37] text-white' : 'text-amber-800 hover:bg-amber-100'"
                        @click="activeLink = '/admin/menu'">
                        <svg class="w-5 h-5 transition-colors duration-200"
                            :class="activeLink === '/admin/menu' ? 'stroke-white' : 'stroke-amber-900'"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                            <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                            <line x1="6" y1="1" x2="6" y2="4"></line>
                            <line x1="10" y1="1" x2="10" y2="4"></line>
                            <line x1="14" y1="1" x2="14" y2="4"></line>
                        </svg>
                        <span class="ml-3">Menu</span>
                    </a>
                </li>

                <!-- Kategori -->
                <li>
                    <a href="{{ route('admin.kategori.index') }}"
                        class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                        :class="activeLink === '/admin/kategori' ? 'bg-[#6F4E37] text-white' :
                            'text-amber-800 hover:bg-amber-100'"
                        @click="activeLink = '/admin/kategori'">
                        <svg class="w-5 h-5 transition-colors duration-200"
                            :class="activeLink === '/admin/kategori' ? 'stroke-white' : 'stroke-amber-900'"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                            <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                            <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                            <rect x="14" y="14" width="7" height="7" rx="1"></rect>
                        </svg>
                        <span class="ml-3">Kategori</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                        :class="activeLink === '/admin/users' ? 'bg-[#6F4E37] text-white' :
                            'text-amber-800 hover:bg-amber-100'"
                        @click="activeLink = '/admin/users'">
                        <svg class="w-5 h-5 transition-colors duration-200"
                            :class="activeLink === '/admin/users' ? 'stroke-white' : 'stroke-amber-900'"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="ml-3">Users</span>
                    </a>
                </li>

                <!-- Meja -->
                <li>
                    <a href="{{ route('admin.meja.index') }}"
                        class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                        :class="activeLink === '/admin/meja' ? 'bg-[#6F4E37] text-white' :
                            'text-amber-800 hover:bg-amber-100'"
                        @click="activeLink = '/admin/meja'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 transition-colors duration-200"
                            :class="activeLink === '/admin/meja' ? 'stroke-white' : 'stroke-amber-900'">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h18M3 14h18M5 6h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2z" />
                        </svg>
                        <span class="ml-3">Meja</span>
                    </a>
                </li>

                <!-- Reservasi -->
                <li>
                    <a href="{{ route('admin.reservasi.index') }}"
                        class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                        :class="activeLink === '/admin/reservasi' ? 'bg-[#6F4E37] text-white' :
                            'text-amber-800 hover:bg-amber-100'"
                        @click="activeLink = '/admin/reservasi'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 transition-colors duration-200"
                            :class="activeLink === '/admin/reservasi' ? 'stroke-white' : 'stroke-amber-900'">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-5a2 2 0 00-2-2H5a2 2 0 00-2 2v5a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="ml-3">Reservasi</span>
                    </a>
                </li>

                <!-- Transaksi -->
                <li>
                    <a href="{{ route('admin.transaksi.index') }}"
                        class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                        :class="activeLink === '/admin/transaksi' ? 'bg-[#6F4E37] text-white' :
                            'text-amber-800 hover:bg-amber-100'"
                        @click="activeLink = '/admin/transaksi'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 transition-colors duration-200"
                            :class="activeLink === '/admin/transaksi' ? 'stroke-white' : 'stroke-amber-900'">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h1M3 14h1M7 10h10M7 14h10M7 18h10M3 18h1"></path>
                        </svg>
                        <span class="ml-3">Transaksi</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Logout Section - Fixed at bottom -->
        <div class="mt-auto pt-4 border-t border-amber-200">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                    class="flex w-full items-center p-2.5 rounded-lg text-red-600 hover:bg-red-50 transition-all duration-200 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-red-600" viewBox="0 0 24 24"
                        fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="ml-3 font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile Menu Toggle Button -->
<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
    type="button"
    class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-amber-900 rounded-lg sm:hidden hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-300 dark:text-amber-200 dark:hover:bg-amber-900 dark:focus:ring-amber-700 fixed top-0 left-0 z-50">
    <span class="sr-only">Toggle sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
        </path>
    </svg>
</button>
