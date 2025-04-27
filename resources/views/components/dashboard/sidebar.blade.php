<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
    type="button"
    class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-amber-900 rounded-lg sm:hidden hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-300 dark:text-amber-200 dark:hover:bg-amber-900 dark:focus:ring-amber-700">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
        </path>
    </svg>
</button>

<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar" x-data="{ activeLink: window.location.pathname }">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white text-amber-900 shadow-md">
        <div class="bg-amber-800 rounded-lg flex justify-center items-center p-3 mb-4">
            <div class="text-2xl">
                <h1 class="font-jost text-2xl font-bold text-white">COFFESHOP</>
                </h1>
            </div>
        </div>
        <ul class="space-y-2 font-medium mt-4 px-2">
            <li>
                <a href="/dashboard" class="flex items-center p-2 rounded-lg group transition-colors duration-200"
                    :class="activeLink === '/dashboard' ? 'bg-amber-800 text-white font-bold' :
                        'text-amber-800 hover:bg-amber-50'"
                    @click="activeLink = '/dashboard'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-colors duration-200"
                        :class="activeLink === '/dashboard' ? 'stroke-white' : 'stroke-amber-900'"
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
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/pages/admin/profile"
                    class="flex items-center p-2 rounded-lg group transition-colors duration-200"
                    :class="activeLink === '/pages/admin/profile' ? 'bg-amber-800 text-white font-bold' :
                        'text-amber-800 hover:bg-amber-50'"
                    @click="activeLink = '/pages/admin/profile'">
                    <svg class="w-5 h-5 transition-colors duration-200"
                        :class="activeLink === '/pages/admin/profile' ? 'stroke-white' : 'stroke-amber-900'"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="ms-3">Users</span>
                </a>
            </li>
            <li>
                <a href="/admin/produk" class="flex items-center p-2 rounded-lg group transition-colors duration-200"
                    :class="activeLink === '/admin/produk' ? 'bg-amber-800 text-white font-bold' :
                        'text-amber-800 hover:bg-amber-50'"
                    @click="activeLink = '/admin/produk'">
                    <svg class="w-5 h-5 transition-colors duration-200"
                        :class="activeLink === '/admin/produk' ? 'stroke-white' : 'stroke-amber-900'"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                        <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                        <line x1="6" y1="1" x2="6" y2="4"></line>
                        <line x1="10" y1="1" x2="10" y2="4"></line>
                        <line x1="14" y1="1" x2="14" y2="4"></line>
                    </svg>
                    <span class="ms-3">Menu</span>
                </a>
            </li>
            <li>
                <a href="/admin/reservasi" class="flex items-center p-2 rounded-lg group transition-colors duration-200"
                    :class="activeLink === '/admin/reservasi' ? 'bg-amber-800 text-white font-bold' :
                        'text-amber-800 hover:bg-amber-50'"
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
                    <span class="ms-3">Reservasi</span>
                </a>
            </li>
            <li>
                <a href="/admin/kategori" class="flex items-center p-2 rounded-lg group transition-colors duration-200"
                    :class="activeLink === '/dashboard/kategori' ? 'bg-amber-800 text-white font-bold' :
                        'text-amber-800 hover:bg-amber-50'"
                    @click="activeLink = '/dashboard/kategori'">
                    <svg class="w-5 h-5 transition-colors duration-200"
                        :class="activeLink === '/dashboard/kategori' ? 'stroke-white' : 'stroke-amber-900'"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                        <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                        <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                        <rect x="14" y="14" width="7" height="7" rx="1"></rect>
                    </svg>
                    <span class="ms-3">Kategori</span>
                </a>
            </li>
            <li>
                <a href="/transaksi" class="flex items-center p-2 rounded-lg group transition-colors duration-200"
                    :class="activeLink === '/transaksi' ? 'bg-amber-800 text-white font-bold' :
                        'text-amber-800 hover:bg-amber-50'"
                    @click="activeLink = '/transaksi'">
                    <svg class="w-5 h-5 transition-colors duration-200"
                        :class="activeLink === '/transaksi' ? 'stroke-white' : 'stroke-amber-900'"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                    <span class="ms-3">Transaksi</span>
                </a>
            </li>
            <li>
                <a href="/transaksi/laporan"
                    class="flex items-center p-2 rounded-lg group transition-colors duration-200"
                    :class="activeLink === '/transaksi/laporan' ? 'bg-amber-800 text-white font-bold' :
                        'text-amber-800 hover:bg-amber-50'"
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
                    <span class="ms-3">Laporan</span>
                </a>
            </li>

            <!-- Separator Line -->
            <div class="my-3 border-t border-amber-200"></div>

            <!-- Logout Button -->
            <li>
                <a href="/logout"
                    class="flex items-center p-2 rounded-lg text-red-600 hover:bg-red-50 group transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-red-600" viewBox="0 0 24 24"
                        fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="ms-3 font-medium">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
