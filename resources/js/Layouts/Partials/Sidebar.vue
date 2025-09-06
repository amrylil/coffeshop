<script setup lang="ts">
import SidebarLink from "./SidebarLink.vue";

// TAMBAHKAN: Terima prop dan definisikan emit
const props = defineProps<{
    isMinimized: boolean;
}>();
const emit = defineEmits(["toggle"]);

const navLinks = [
    { name: "Menu", href: "/admin/menu", icon: { type: "coffee" } },
    { name: "Kategori", href: "/admin/kategori", icon: { type: "grid" } },
    { name: "Users", href: "/admin/users", icon: { type: "users" } },
    { name: "Meja", href: "/admin/meja", icon: { type: "table" } },
    { name: "Reservasi", href: "/admin/reservasi", icon: { type: "calendar" } },
    { name: "Transaksi", href: "/admin/transaksi", icon: { type: "receipt" } },
    {
        name: "Laporan",
        href: "/admin/transaksi/report",
        icon: { type: "report" },
    },
] as const;
</script>

<template>
    <aside
        id="default-sidebar"
        class="fixed top-0 left-0 z-40 h-screen transition-all duration-300 ease-in-out"
        :class="isMinimized ? 'w-20' : 'w-64'"
        aria-label="Main navigation"
    >
        <div
            class="flex h-full flex-col overflow-y-auto px-3 py-4 text-amber-900 shadow-md"
        >
            <div class="py-6 flex items-center gap-2">
                <img
                    src="/images/logo.png"
                    alt="Logo"
                    class="w-10 h-10 transition-all duration-300 ease-in-out"
                    :class="isMinimized ? 'w-8 h-8 mx-auto' : 'w-10 h-10'"
                />

                <transition name="fade" mode="out-in">
                    <h1
                        v-if="!isMinimized"
                        key="full"
                        class="font-jost text-2xl font-bold text-white tracking-wide"
                    >
                        SRUPUT
                    </h1>
                </transition>
            </div>

            <nav aria-label="Main menu" class="flex-grow mt-10">
                <ul class="space-y-1 px-1 font-medium">
                    <li v-for="link in navLinks" :key="link.name">
                        <SidebarLink
                            :href="link.href"
                            :iconType="link.icon.type"
                            :is-minimized="isMinimized"
                        >
                            {{ link.name }}
                        </SidebarLink>
                    </li>
                </ul>
            </nav>

            <div class="mt-auto flex justify-center border-t pt-4">
                <button
                    @click="emit('toggle')"
                    class="flex h-10 w-full items-center justify-center rounded-lg text-amber-800 hover:bg-amber-100"
                    aria-label="Toggle Sidebar"
                >
                    <svg
                        v-if="!isMinimized"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7"
                        />
                    </svg>
                    <svg
                        v-else
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13 5l7 7-7 7M5 5l7 7-7 7"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </aside>
</template>
