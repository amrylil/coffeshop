<script setup lang="ts">
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { PageProps, User } from "@/types";

const isDropdownOpen = ref(false);

const currentUrl = computed(() => usePage().url);

const page = usePage<PageProps>();
const user = computed<User | null>(() => page.props.auth.user);

const userInitials = computed(() => {
    if (!user.value?.name) return "";
    const nameParts = user.value.name.split(" ");
    const firstNameInitial = nameParts[0] ? nameParts[0][0] : "";
    const lastNameInitial =
        nameParts.length > 1 ? nameParts[nameParts.length - 1][0] : "";
    return `${firstNameInitial}${lastNameInitial}`.toUpperCase();
});

const isActive = (linkUrl: string) => {
    return currentUrl.value.startsWith(linkUrl);
};
</script>

<template>
    <div class="font-jost bg-gray-50">
        <!-- Simplified Coffee Shop Sidebar -->
        <aside
            id="default-sidebar"
            class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform sm:translate-x-0"
            aria-label="Main navigation"
        >
            <div
                class="h-full px-3 py-4 overflow-y-auto bg-white text-amber-900 shadow-md flex flex-col"
            >
                <!-- Logo Header -->
                <div
                    class="bg-[#6F4E37] rounded-lg flex justify-center items-center p-3 mb-6"
                >
                    <h1 class="font-jost text-2xl font-bold text-white">
                        COFFEESHOP
                    </h1>
                </div>

                <!-- Navigation Menu -->
                <nav aria-label="Main menu" class="flex-grow">
                    <ul class="space-y-1 font-medium px-1">
                        <li class="pt-3 pb-1">
                            <div
                                class="text-xs uppercase font-semibold text-amber-600 px-2"
                            >
                                Management
                            </div>
                        </li>
                        <!-- Menu -->
                        <li>
                            <Link
                                :href="route('admin.menu.index')"
                                class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                                :class="
                                    isActive('/admin/menu')
                                        ? 'bg-[#6F4E37] text-white'
                                        : 'text-amber-800 hover:bg-amber-100'
                                "
                            >
                                <svg
                                    class="w-5 h-5 transition-colors duration-200"
                                    :class="
                                        isActive('/admin/menu')
                                            ? 'stroke-white'
                                            : 'stroke-amber-900'
                                    "
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                                    <path
                                        d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"
                                    ></path>
                                    <line x1="6" y1="1" x2="6" y2="4"></line>
                                    <line x1="10" y1="1" x2="10" y2="4"></line>
                                    <line x1="14" y1="1" x2="14" y2="4"></line>
                                </svg>
                                <span class="ml-3">Menu</span>
                            </Link>
                        </li>
                        <!-- Kategori -->
                        <li>
                            <Link
                                :href="route('admin.kategori.index')"
                                class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                                :class="
                                    isActive('/admin/kategori')
                                        ? 'bg-[#6F4E37] text-white'
                                        : 'text-amber-800 hover:bg-amber-100'
                                "
                            >
                                <svg
                                    class="w-5 h-5 transition-colors duration-200"
                                    :class="
                                        isActive('/admin/kategori')
                                            ? 'stroke-white'
                                            : 'stroke-amber-900'
                                    "
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <rect
                                        x="3"
                                        y="3"
                                        width="7"
                                        height="7"
                                        rx="1"
                                    ></rect>
                                    <rect
                                        x="14"
                                        y="3"
                                        width="7"
                                        height="7"
                                        rx="1"
                                    ></rect>
                                    <rect
                                        x="3"
                                        y="14"
                                        width="7"
                                        height="7"
                                        rx="1"
                                    ></rect>
                                    <rect
                                        x="14"
                                        y="14"
                                        width="7"
                                        height="7"
                                        rx="1"
                                    ></rect>
                                </svg>
                                <span class="ml-3">Kategori</span>
                            </Link>
                        </li>
                        <!-- Users -->
                        <li>
                            <Link
                                :href="route('admin.users.index')"
                                class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                                :class="
                                    isActive('/admin/users')
                                        ? 'bg-[#6F4E37] text-white'
                                        : 'text-amber-800 hover:bg-amber-100'
                                "
                            >
                                <svg
                                    class="w-5 h-5 transition-colors duration-200"
                                    :class="
                                        isActive('/admin/users')
                                            ? 'stroke-white'
                                            : 'stroke-amber-900'
                                    "
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
                                    ></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="ml-3">Users</span>
                            </Link>
                        </li>
                        <!-- Meja -->
                        <li>
                            <Link
                                :href="route('admin.meja.index')"
                                class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                                :class="
                                    isActive('/admin/meja')
                                        ? 'bg-[#6F4E37] text-white'
                                        : 'text-amber-800 hover:bg-amber-100'
                                "
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="w-5 h-5 transition-colors duration-200"
                                    :class="
                                        isActive('/admin/meja')
                                            ? 'stroke-white'
                                            : 'stroke-amber-900'
                                    "
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 10h18M3 14h18M5 6h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2z"
                                    />
                                </svg>
                                <span class="ml-3">Meja</span>
                            </Link>
                        </li>
                        <!-- Reservasi -->
                        <li>
                            <Link
                                :href="route('admin.reservasi.index')"
                                class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                                :class="
                                    isActive('/admin/reservasi')
                                        ? 'bg-[#6F4E37] text-white'
                                        : 'text-amber-800 hover:bg-amber-100'
                                "
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="w-5 h-5 transition-colors duration-200"
                                    :class="
                                        isActive('/admin/reservasi')
                                            ? 'stroke-white'
                                            : 'stroke-amber-900'
                                    "
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-5a2 2 0 00-2-2H5a2 2 0 00-2 2v5a2 2 0 002 2z"
                                    ></path>
                                </svg>
                                <span class="ml-3">Reservasi</span>
                            </Link>
                        </li>
                        <!-- Transaksi -->
                        <li>
                            <Link
                                :href="route('admin.transaksi.index')"
                                class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                                :class="
                                    isActive('/admin/transaksi')
                                        ? 'bg-[#6F4E37] text-white'
                                        : 'text-amber-800 hover:bg-amber-100'
                                "
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="w-5 h-5 transition-colors duration-200"
                                    :class="
                                        isActive('/admin/transaksi')
                                            ? 'stroke-white'
                                            : 'stroke-amber-900'
                                    "
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 10h1M3 14h1M7 10h10M7 14h10M7 18h10M3 18h1"
                                    ></path>
                                </svg>
                                <span class="ml-3">Transaksi</span>
                            </Link>
                        </li>
                        <!-- Laporan -->
                        <li>
                            <Link
                                :href="route('admin.transaksi.report')"
                                class="flex items-center p-2.5 rounded-lg transition-all duration-200 group"
                                :class="
                                    isActive('/admin/transaksi/report')
                                        ? 'bg-[#6F4E37] text-white'
                                        : 'text-amber-800 hover:bg-amber-100'
                                "
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="w-5 h-5 transition-colors duration-200"
                                    :class="
                                        isActive('/admin/transaksi/report')
                                            ? 'stroke-white'
                                            : 'stroke-amber-900'
                                    "
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 17v-6a2 2 0 012-2h4a2 2 0 012 2v6m-6 0h6"
                                    ></path>
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M13 7h-2a2 2 0 00-2 2v6"
                                    ></path>
                                </svg>
                                <span class="ml-3">Laporan</span>
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Header -->
        <header
            class="fixed top-0 right-0 left-0 sm:left-64 py-10 flex items-center justify-between p-4 bg-white shadow-md z-30 px-9 pl-6 h-16"
        >
            <div class="flex flex-col">
                <h1 class="font-semibold text-2xl text-amber-900">
                    Administrator
                </h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="flex gap-3 items-center">
                        <div class="text-amber-800 font-medium">
                            {{ user?.name }}
                        </div>
                        <div
                            @click="isDropdownOpen = !isDropdownOpen"
                            tabindex="0"
                            role="button"
                            class="relative flex items-center justify-center w-10 h-10 rounded-full bg-gray-600 text-white cursor-pointer hover:shadow-md transition-all duration-200"
                        >
                            <div
                                class="relative w-10 h-10 overflow-hidden rounded-full border-2 border-white bg-[#422424] shadow-lg flex items-center justify-center"
                            >
                                <span class="text-white font-bold text-lg">{{
                                    userInitials
                                }}</span>
                                <div
                                    class="absolute inset-0 bg-white opacity-10 rounded-full mix-blend-overlay"
                                ></div>
                            </div>
                        </div>
                    </div>
                    <ul
                        v-show="isDropdownOpen"
                        @click.outside="isDropdownOpen = false"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-lg z-[100] p-2 shadow-lg border border-amber-100"
                    >
                        <div class="border-t border-amber-100 my-1"></div>
                        <li>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="flex items-center w-full text-left text-amber-900 hover:bg-amber-50 rounded-md px-4 py-2 transition-colors duration-150"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                    />
                                </svg>
                                Logout
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="py-2 px-3 pt-20 sm:ml-64 shadow-md min-h-screen">
            <div class="p-3">
                <slot />
            </div>
        </main>
    </div>
</template>
