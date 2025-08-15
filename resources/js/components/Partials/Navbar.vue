<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { PageProps, User } from "@/types";
const page = usePage<PageProps>();
const authUser = computed<User | null>(() => page.props.auth.user);

const scrolled = ref<boolean>(false);
const isHome = ref<boolean>(window.location.pathname === "/");
const mobileMenuOpen = ref<boolean>(false);

const handleScroll = (): void => {
    scrolled.value = window.scrollY > 30;
};

const emit = defineEmits<{
    (e: "toggle-sidebar"): void;
}>();

const userInitials = computed(() => {
    if (!authUser.value?.name) {
        return "?";
    }
    const words = authUser.value.name.split(" ");

    const initials = words.map((word) => word[0]).join("");

    return initials.substring(0, 2).toUpperCase();
});

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});
</script>

<template>
    <header
        :class="{ 'bg-[#e6dbd1] shadow-md': scrolled || !isHome }"
        class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between w-full px-6 py-4 transition-all duration-300 md:px-12 lg:px-24 font-jost"
        :style="{ color: scrolled || !isHome ? '#0f172a' : '#f8fafc' }"
    >
        <Link href="/" class="text-2xl font-semibold shrink-0">
            Coffee Shop
        </Link>

        <nav
            class="hidden md:flex items-center gap-x-3 lg:gap-x-5"
            :class="{
                'md:-translate-x-[50px]': authUser,
                'md:-translate-x-[65px]': !authUser,
            }"
        >
            <Link
                :href="route('beranda')"
                :class="{
                    'bg-[#422424] py-1 px-3 rounded text-white':
                        $page.url === '/',
                }"
                >Beranda</Link
            >
            <Link
                :href="route('menu.index')"
                :class="{
                    'bg-[#422424] py-1 px-3 rounded text-white':
                        $page.url.startsWith('/menu'),
                }"
                >Menu</Link
            >
            <Link
                :href="route('reservasi.meja')"
                :class="{
                    'bg-[#422424] py-1 px-3 rounded text-white':
                        $page.url.startsWith('/reservasi'),
                }"
                >Reservasi</Link
            >
            <Link
                :href="route('about-us')"
                :class="{
                    'bg-[#422424] py-1 px-3 rounded ':
                        $page.url.startsWith('/about'),
                }"
                ><span class="text-slate-950">Tentang Kami</span></Link
            >
            <Link
                :href="route('kontak')"
                :class="{
                    'bg-[#422424] py-1 px-3 rounded text-white':
                        $page.url.startsWith('/contact'),
                }"
                ><span class="text-slate-950">Kontak</span></Link
            >
        </nav>

        <div class="flex items-center gap-x-2 md:gap-x-4">
            <template v-if="authUser">
                <Link
                    :href="route('keranjang.index')"
                    class="relative p-2 rounded-full hover:bg-[#422424]/10 transition-colors"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                        />
                    </svg>
                </Link>

                <div @click="emit('toggle-sidebar')" class="cursor-pointer">
                    <div
                        v-if="authUser.profile_photo"
                        class="w-10 h-10 rounded-full overflow-hidden border-2"
                        :class="
                            scrolled || !isHome
                                ? 'border-gray-700'
                                : 'border-white/50'
                        "
                    >
                        <img
                            :alt="authUser.name"
                            :src="authUser.profile_photo"
                            class="object-cover w-full h-full"
                        />
                    </div>
                    <div
                        v-else
                        class="relative flex items-center justify-center w-10 h-10 overflow-hidden bg-[#422424] rounded-full shadow-lg"
                    >
                        <span class="text-lg font-bold text-white">{{
                            userInitials
                        }}</span>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="hidden md:block">
                    <Link
                        href="/login"
                        class="px-4 py-2 text-sm transition-colors duration-300 border rounded-md border-black text-slate-950 hover:bg-coklat hover:text-white"
                    >
                        Masuk
                    </Link>
                </div>
            </template>

            <div class="md:hidden">
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-inset"
                    :class="
                        scrolled || !isHome
                            ? 'focus:ring-slate-800'
                            : 'focus:ring-white'
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </header>
</template>
