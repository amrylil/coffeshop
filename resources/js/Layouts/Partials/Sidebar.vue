<script setup lang="ts">
import { computed } from "vue";
import { User } from "@/types";
import SidebarLink from "./SidebarLink.vue";
import UserMenu from "./UserMenu.vue";

const props = defineProps<{
    isMinimized: boolean;
    user: User | null;
}>();
const emit = defineEmits(["toggle"]);

// Computed property untuk memfilter link navigasi berdasarkan peran pengguna
const navLinks = computed(() => {
    // Daftar semua link dengan path statis dan peran yang diperbarui
    const allLinks = [
        {
            name: "Dashboard",
            href: "/admin/dashboard",
            iconType: "grid",
            roles: ["admin", "cashier"],
        },
        {
            name: "Menu",
            href: "/admin/menu",
            iconType: "coffee",
            roles: ["admin", "cashier"],
        },
        {
            name: "Inventory",
            href: "/admin/inventory",
            iconType: "box",
            roles: ["admin"],
        },
        {
            name: "Kategori",
            href: "/admin/kategori",
            iconType: "tag",
            roles: ["admin"],
        },
        {
            name: "Users",
            href: "/admin/users",
            iconType: "users",
            roles: ["admin"],
        },
        {
            name: "Meja",
            href: "/admin/meja",
            iconType: "table",
            roles: ["admin", "cashier"],
        },
        {
            name: "Reservasi",
            href: "/admin/reservasi",
            iconType: "calendar",
            roles: ["admin", "cashier"],
        },
        {
            name: "Transaksi",
            href: "/admin/cashier",
            iconType: "receipt",
            roles: ["admin", "cashier"],
        },
        {
            name: "Laporan",
            href: "/admin/laporan",
            iconType: "report",
            roles: ["admin", "cashier"],
        },
    ] as const;

    if (!props.user || !props.user.role) {
        return [];
    }

    const userRole = props.user.role;

    // Filter link berdasarkan peran user
    return allLinks.filter((link) =>
        (link.roles as readonly string[]).includes(userRole)
    );
});
</script>

<template>
    <aside
        id="default-sidebar"
        class="fixed top-0 left-0 z-40 h-screen transition-all duration-300 ease-in-out"
        :class="isMinimized ? 'w-20' : 'w-64'"
        aria-label="Main navigation"
    >
        <div
            class="absolute right-2 top-10 py-2 transition-all duration-300 ease-in-out"
            @click="emit('toggle')"
            :class="
                isMinimized && 'bg-[#6F4E37]  absolute translate-x-5 rounded  '
            "
        >
            <button
                class="rounded-lg text-slate-50 flex justify-center"
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
                        d="M15 19l-7-7 7-7"
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
                        d="M9 5l7 7-7 7"
                    />
                </svg>
            </button>
        </div>

        <div
            class="flex h-full flex-col bg-[#6F4E37] px-3 py-4 text-amber-900 shadow-md"
        >
            <div class="py-6 flex items-center gap-2 flex-shrink-0">
                <img
                    src="/images/logo.png"
                    alt="Logo"
                    class="transition-all duration-300 ease-in-out"
                    :class="isMinimized ? 'w-8 h-8 mx-auto' : 'w-10 h-10 ml-2'"
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

            <div class="flex-grow overflow-y-auto">
                <nav aria-label="Main menu" class="mt-10">
                    <ul class="space-y-1 px-1 font-medium">
                        <li v-for="link in navLinks" :key="link.name">
                            <SidebarLink
                                :href="link.href"
                                :iconType="link.iconType"
                                :is-minimized="isMinimized"
                            >
                                {{ link.name }}
                            </SidebarLink>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="p-2 flex-shrink-0">
                <UserMenu :user="user" :is-minimized="isMinimized" />
            </div>
        </div>
    </aside>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
