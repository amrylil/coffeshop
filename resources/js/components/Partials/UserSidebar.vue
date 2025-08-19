<template>
    <Transition name="fade">
        <div
            v-if="isOpen"
            @click="closeSidebar"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 transition-opacity"
        ></div>
    </Transition>

    <Transition name="slide-in">
        <aside
            v-if="isOpen"
            ref="sidebarPanel"
            class="fixed top-0 right-0 h-full w-80 shadow-2xl z-50 flex flex-col bg-lunen"
        >
            <!-- Wood texture pattern overlay -->
            <div class="absolute inset-0 opacity-8 pointer-events-none">
                <div class="w-full h-full"></div>
            </div>

            <header
                class="relative flex items-center justify-between p-6 bg-coklat"
            >
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-full flex items-center justify-center bg-lunen"
                    >
                        <i class="fas fa-coffee text-coklat text-sm"></i>
                    </div>
                    <h3 class="text-xl font-bold font-playfair text-lunen">
                        Profil Saya
                    </h3>
                </div>
            </header>

            <div class="flex-grow p-6 overflow-y-auto">
                <!-- User Profile Section -->
                <div
                    class="p-5 mb-6 shadow-md border-2"
                    style="background-color: #faf0e6; border-color: #8b4513"
                >
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <img
                                v-if="user.profile_photo"
                                :src="user.profile_photo"
                                :alt="user.name"
                                class="w-16 h-16 rounded-full object-cover border-3 shadow-md"
                                style="border-color: #654321"
                            />
                            <div
                                v-else
                                class="w-16 h-16 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-md border-3"
                                style="
                                    background-color: #654321;
                                    border-color: #5d2f02;
                                "
                            >
                                {{ userInitials }}
                            </div>
                            <!-- Coffee bean accent -->
                            <div
                                class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full flex items-center justify-center shadow-md border"
                                style="
                                    background-color: #8b4513;
                                    border-color: #654321;
                                "
                            >
                                <i class="fas fa-coffee text-lunen text-xs"></i>
                            </div>
                        </div>
                        <div class="font-montserrat flex-1 min-w-0">
                            <p
                                class="font-bold truncate text-lg"
                                style="color: #654321"
                            >
                                {{ user.name }}
                            </p>
                            <p class="text-sm truncate" style="color: #8b4513">
                                {{ user.email }}
                            </p>
                            <div class="flex items-center gap-1 mt-1">
                                <i
                                    class="fas fa-star text-xs"
                                    style="color: #daa520"
                                ></i>
                                <span
                                    class="text-xs font-medium"
                                    style="color: #654321"
                                    >Coffee Lover</span
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="space-y-3 font-montserrat">
                    <Link
                        :href="route('profile.edit')"
                        class="group flex items-center gap-4 px-4 py-4 text-sm transition-all duration-200 shadow-md hover:shadow-lg border-2 border-coklat"
                    >
                        <div
                            class="w-10 h-10 flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all duration-200 border-coklat border"
                        >
                            <i class="fas fa-user-edit text-coklat text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <span
                                class="font-semibold group-hover:opacity-80 transition-"
                                >Edit Profil</span
                            >
                            <p class="text-xs mt-0.5" style="color: #8b4513">
                                Kelola informasi pribadi
                            </p>
                        </div>
                        <i
                            class="fas fa-chevron-right group-hover:translate-x-1 transition-all duration-200"
                            style="color: #8b4513"
                        ></i>
                    </Link>

                    <Link
                        :href="route('transaksi.index')"
                        class="group flex items-center gap-4 px-4 py-4 text-sm transition-all duration-200 shadow-md hover:shadow-lg border-2 border-coklat"
                    >
                        <div
                            class="w-10 h-10 flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all duration-200 border-coklat border"
                        >
                            <i class="fas fa-receipt text-coklat text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <span
                                class="font-semibold group-hover:opacity-80 transition-"
                                >Riwayat Pesanan</span
                            >
                            <p class="text-xs mt-0.5" style="color: #8b4513">
                                Lihat riwayat pesanan anda
                            </p>
                        </div>
                        <i
                            class="fas fa-chevron-right group-hover:translate-x-1 transition-all duration-200"
                            style="color: #8b4513"
                        ></i>
                    </Link>
                </nav>

                <!-- Coffee Quote -->
                <div
                    class="mt-8 p-4 border-2 shadow-inner"
                    style="background-color: #f5deb3"
                >
                    <div class="flex items-center gap-2 mb-2">
                        <i
                            class="fas fa-quote-left text-xs"
                            style="color: #654321"
                        ></i>
                        <span
                            class="text-xs font-semibold"
                            style="color: #654321"
                            >Coffee Quote</span
                        >
                    </div>
                    <p
                        class="text-xs italic font-medium leading-relaxed"
                        style="color: #8b4513"
                    >
                        "Life is too short for bad coffee. Enjoy every sip,
                        every moment."
                    </p>
                </div>
            </div>

            <footer class="p-6 border-t-2 bg-coklat">
                <Link
                    as="button"
                    method="post"
                    :href="route('logout')"
                    class="w-full flex items-center justify-center gap-3 px-4 py-4 text-sm font-bold text-lunen transition-all duration-200 shadow-lg hover:shadow-xl border-2 group"
                >
                    <div
                        class="w-8 h-8 rounded-full flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-200 border"
                        style="background-color: #f5f5dc; border-color: #d2b48c"
                    >
                        <i
                            class="fas fa-sign-out-alt text-xs"
                            style="color: #654321"
                        ></i>
                    </div>
                    <span class="transition-colors">Logout</span>
                </Link>
            </footer>
        </aside>
    </Transition>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted, watch } from "vue";
import { Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { User } from "@/types";

const props = defineProps<{
    isOpen: boolean;
    user: User;
}>();

const emit = defineEmits<{
    (e: "close"): void;
}>();

const sidebarPanel = ref<HTMLElement | null>(null);

const closeSidebar = () => {
    emit("close");
};

const userInitials = computed(() => {
    if (!props.user?.name) return "?";
    return props.user.name
        .split(" ")
        .map((n) => n[0])
        .join("")
        .substring(0, 2)
        .toUpperCase();
});

const handleKeydown = (event: KeyboardEvent) => {
    if (event.key === "Escape") {
        closeSidebar();
    }
};

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            document.addEventListener("keydown", handleKeydown);
        } else {
            document.removeEventListener("keydown", handleKeydown);
        }
    }
);

onUnmounted(() => {
    document.removeEventListener("keydown", handleKeydown);
});
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-in-enter-active,
.slide-in-leave-active {
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.slide-in-enter-from,
.slide-in-leave-to {
    transform: translateX(100%);
}

/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #fef3c7;
    border-radius: 4px;
    border: 1px solid #d97706;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #d97706;
    border-radius: 4px;
    border: 1px solid #92400e;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #92400e;
}
</style>
