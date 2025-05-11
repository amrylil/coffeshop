<!-- Improved Coffee Shop Sidebar -->
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
                <!-- Dashboard -->
                <li>
                    <a href="/admin" class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                        :class="activeLink === '/admin' ? 'bg-[#6F4E37] text-white' : 'text-amber-800 hover:bg-amber-100'"
                        @click="activeLink = '/admin'" aria-current="page">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-colors duration-200"
                            :class="activeLink === '/admin' ? 'stroke-white' : 'stroke-amber-900'"
                            viewBox="-0.5 -0.5 16 16" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M2.5 3.125a0.625 0.625 0 0 1 0.625 -0.625h2.5a0.625 0.625 0 0 1 0.625 0.625v2.5a0.625 0.625 0 0 1 -0.625 0.625H3.125a0.625 0.625 0 0 1 -0.625 -0.625V3.125z"
                                stroke-width="1"></path>
                            <path
                                d="M8.75 3.125a0.625 0.625 0 0 1 0.625 -0.625h2.5a0.625 0.625 0 0 1 0.625 0.625v2.5a0.625 0.625 0 0 1 -0.625 0.625h-2.5a0.625 0.625 0 0 1 -0.625 -0.625V3.125z"
                                stroke-width="1"></path>
                            <path
                                d="M2.5 9.375a0.625 0.625 0 0 1 0.625 -0.625h2.5a0.625 0.625 0 0 1 0.625 0.625v2.5a0.625 0.625 0 0 1 -0.625 0.625H3.125a0.625 0.625 0 0 1 -0.625 -0.625v-2.5z"
                                stroke-width="1"></path>
                            <path d="M8.75 10.625h3.75" stroke-width="1"></path>
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>

                <!-- Management Section -->
                <li class="pt-3 pb-1">
                    <div class="text-xs uppercase font-semibold text-amber-600 px-2">Management</div>
                </li>

                <!-- Users -->
                <li>
                    <a href="/admin/users" class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
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

                <!-- Menu -->
                <li>
                    <a href="/admin/menu" class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
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
                    <a href="/admin/kategori"
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

                <!-- Reservations Section -->
                <li class="pt-3 pb-1">
                    <div class="text-xs uppercase font-semibold text-amber-600 px-2">Reservations</div>
                </li>

                <!-- Reservasi -->
                <li>
                    <a href="/admin/reservasi"
                        class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                        :class="activeLink === '/admin/reservasi' ? 'bg-[#6F4E37] text-white' :
                            'text-amber-800 hover:bg-amber-100'"
                        @click="activeLink = '/admin/reservasi'">
                        <svg class="w-5 h-5 transition-colors duration-200"
                            :class="activeLink === '/admin/reservasi' ? 'stroke-white' : 'stroke-amber-900'"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <path d="M12 11.15l.01-.1"></path>
                            <path d="M8 7l.01-.1"></path>
                            <path d="M16 7l.01-.1"></path>
                            <path d="M3.5 8.5c1.5-1 3-1.5 4.5-1.5"></path>
                            <path d="M20.5 8.5c-1.5-1-3-1.5-4.5-1.5"></path>
                            <rect x="4" y="12" width="16" height="3" rx="1"></rect>
                        </svg>
                        <span class="ml-3">Reservasi</span>
                    </a>
                </li>

                <!-- Finance Section -->
                <li class="pt-3 pb-1">
                    <div class="text-xs uppercase font-semibold text-amber-600 px-2">Finance</div>
                </li>

                <!-- Transaksi -->
                <li>
                    <a href="/transaksi" class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                        :class="activeLink === '/transaksi' ? 'bg-[#6F4E37] text-white' : 'text-amber-800 hover:bg-amber-100'"
                        @click="activeLink = '/transaksi'">
                        <svg class="w-5 h-5 transition-colors duration-200"
                            :class="activeLink === '/transaksi' ? 'stroke-white' : 'stroke-amber-900'"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                        <span class="ml-3">Transaksi</span>
                    </a>
                </li>

                <!-- Laporan -->
                <li>
                    <a href="/transaksi/laporan"
                        class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                        :class="activeLink === '/transaksi/laporan' ? 'bg-[#6F4E37] text-white' :
                            'text-amber-800 hover:bg-amber-100'"
                        @click="activeLink = '/transaksi/laporan'">
                        <svg class="w-5 h-5 transition-colors duration-200"
                            :class="activeLink === '/transaksi/laporan' ? 'stroke-white' : 'stroke-amber-900'"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <path d="M14 2v6h6"></path>
                            <path d="M16 13H8"></path>
                            <path d="M16 17H8"></path>
                            <path d="M10 9H8"></path>
                        </svg>
                        <span class="ml-3">Laporan</span>
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
