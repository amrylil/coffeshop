<template>
    <Transition name="fade">
        <div
            v-if="isOpen"
            @click="closeSidebar"
            class="fixed inset-0 bg-gradient-to-br from-amber-900/40 to-stone-900/60 backdrop-blur-sm z-50 transition-opacity"
        ></div>
    </Transition>

    <Transition name="slide-in">
        <aside
            v-if="isOpen"
            ref="sidebarPanel"
            class="fixed top-0 right-0 h-full w-80 bg-gradient-to-br from-amber-50 via-orange-50 to-stone-50 shadow-2xl z-50 flex flex-col border-l-2 border-amber-200/50"
        >
            <!-- Coffee-themed pattern overlay -->
            <div class="absolute inset-0 opacity-5 pointer-events-none">
                <div class="w-full h-full bg-repeat"></div>
            </div>

            <header
                class="relative flex items-center justify-between p-6 border-b border-amber-200/30 bg-gradient-to-r from-amber-100/80 to-orange-100/80 backdrop-blur-sm"
            >
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-coklat rounded-full flex items-center justify-center shadow-lg"
                    >
                        <i class="fas fa-coffee text-amber-100 text-sm"></i>
                    </div>
                    <h3
                        class="text-xl font-bold font-playfair bg-gradient-to-r from-amber-800 to-amber-900 bg-clip-text text-transparent"
                    >
                        Profil & Pengaturan
                    </h3>
                </div>
            </header>

            <div class="flex-grow p-6 overflow-y-auto">
                <!-- User Profile Section -->
                <div
                    class="bg-white/70 backdrop-blur-sm rounded-2xl p-5 mb-6 shadow-lg border border-amber-200/50"
                >
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <img
                                v-if="user.profile_photo"
                                :src="user.profile_photo"
                                :alt="user.name"
                                class="w-16 h-16 rounded-full object-cover border-3 border-amber-300 shadow-lg"
                            />
                            <div
                                v-else
                                class="w-16 h-16 rounded-full bg-gradient-to-br from-amber-600 to-amber-800 flex items-center justify-center text-white text-xl font-bold shadow-lg border-3 border-amber-300"
                            >
                                {{ userInitials }}
                            </div>
                            <!-- Coffee bean accent -->
                            <div
                                class="absolute -bottom-1 -right-1 w-6 h-6 bg-amber-600 rounded-full flex items-center justify-center shadow-md"
                            >
                                <i class="fas fa-coffee text-white text-xs"></i>
                            </div>
                        </div>
                        <div class="font-montserrat flex-1 min-w-0">
                            <p
                                class="font-bold text-amber-900 truncate text-lg"
                            >
                                {{ user.name }}
                            </p>
                            <p class="text-sm text-amber-700/80 truncate">
                                {{ user.email }}
                            </p>
                            <div class="flex items-center gap-1 mt-1">
                                <i
                                    class="fas fa-star text-amber-400 text-xs"
                                ></i>
                                <span class="text-xs text-amber-600 font-medium"
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
                        class="group flex items-center gap-4 px-4 py-4 text-sm text-amber-800 rounded-2xl bg-white/60 hover:bg-white/90 transition-all duration-200 shadow-md hover:shadow-lg border border-amber-200/50 hover:border-amber-300"
                    >
                        <div
                            class="w-10 h-10 bg-coklat rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all duration-200"
                        >
                            <i class="fas fa-user-edit text-white text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <span
                                class="font-semibold group-hover:text-amber-900 transition-colors"
                                >Edit Profil</span
                            >
                            <p class="text-xs text-amber-600/70 mt-0.5">
                                Kelola informasi pribadi
                            </p>
                        </div>
                        <i
                            class="fas fa-chevron-right text-amber-400 group-hover:text-amber-600 group-hover:translate-x-1 transition-all duration-200"
                        ></i>
                    </Link>

                    <Link
                        href="#"
                        class="group flex items-center gap-4 px-4 py-4 text-sm text-amber-800 rounded-2xl bg-white/60 hover:bg-white/90 transition-all duration-200 shadow-md hover:shadow-lg border border-amber-200/50 hover:border-amber-300"
                    >
                        <div
                            class="w-10 h-10 bg-coklat rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all duration-200"
                        >
                            <i class="fas fa-receipt text-white text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <span
                                class="font-semibold group-hover:text-amber-900 transition-colors"
                                >Riwayat Pesanan</span
                            >
                            <p class="text-xs text-amber-600/70 mt-0.5">
                                Lihat pesanan kopi Anda
                            </p>
                        </div>
                        <i
                            class="fas fa-chevron-right text-amber-400 group-hover:text-amber-600 group-hover:translate-x-1 transition-all duration-200"
                        ></i>
                    </Link>

                    <Link
                        href="#"
                        class="group flex items-center gap-4 px-4 py-4 text-sm text-amber-800 rounded-2xl bg-white/60 hover:bg-white/90 transition-all duration-200 shadow-md hover:shadow-lg border border-amber-200/50 hover:border-amber-300"
                    >
                        <div
                            class="w-10 h-10 bg-coklat rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all duration-200"
                        >
                            <i class="fas fa-cog text-white text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <span
                                class="font-semibold group-hover:text-amber-900 transition-colors"
                                >Pengaturan Akun</span
                            >
                            <p class="text-xs text-amber-600/70 mt-0.5">
                                Preferensi & keamanan
                            </p>
                        </div>
                        <i
                            class="fas fa-chevron-right text-amber-400 group-hover:text-amber-600 group-hover:translate-x-1 transition-all duration-200"
                        ></i>
                    </Link>
                </nav>

                <!-- Coffee Quote -->
                <div
                    class="mt-8 p-4 bg-gradient-to-r from-amber-100/80 to-orange-100/80 rounded-2xl border border-amber-200/50"
                >
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-quote-left text-amber-600 text-xs"></i>
                        <span class="text-xs font-semibold text-amber-800"
                            >Coffee Quote</span
                        >
                    </div>
                    <p
                        class="text-xs text-amber-700 italic font-medium leading-relaxed"
                    >
                        "Life is too short for bad coffee. Enjoy every sip,
                        every moment."
                    </p>
                </div>
            </div>

            <footer
                class="p-6 border-t border-amber-200/30 bg-gradient-to-r from-amber-50/80 to-orange-50/80 backdrop-blur-sm"
            >
                <Link
                    as="button"
                    method="post"
                    :href="route('logout')"
                    class="w-full flex items-center justify-center gap-3 px-4 py-4 text-sm font-bold text-slate-50 bg-coklat rounded-2xl transition-all duration-200 shadow-lg hover:shadow-xl border border-red-300/50 group"
                >
                    <div
                        class="w-8 h-8 bg-slate-50 rounded-full flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-200"
                    >
                        <i class="fas fa-sign-out-alt text-coklat text-xs"></i>
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
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: rgba(245, 158, 11, 0.1);
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(245, 158, 11, 0.3);
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(245, 158, 11, 0.5);
}
</style>
