<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from "vue";
import { Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { User } from "@/types";

const props = defineProps<{
    user: User | null;
    isMinimized: boolean;
}>();

const isDropdownOpen = ref(false);
const menuRef = ref<HTMLElement | null>(null);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

// Menutup dropdown jika klik di luar area menu
const handleClickOutside = (event: MouseEvent) => {
    if (menuRef.value && !menuRef.value.contains(event.target as Node)) {
        isDropdownOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener("mousedown", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("mousedown", handleClickOutside);
});

const userInitials = computed(() => {
    if (!props.user?.name) return "?";
    const nameParts = props.user.name.split(" ");
    const firstNameInitial = nameParts[0]?.[0] ?? "";
    const lastNameInitial =
        nameParts.length > 1 ? nameParts[nameParts.length - 1]?.[0] ?? "" : "";
    return `${firstNameInitial}${lastNameInitial}`.toUpperCase();
});
</script>

<template>
    <div class="relative w-full" ref="menuRef">
        <div
            @click="toggleDropdown"
            class="flex items-center p-2 rounded-lg cursor-pointer hover:bg-black/10 transition-colors duration-200"
            :class="isMinimized ? 'justify-center' : 'justify-start'"
            role="button"
            tabindex="0"
            aria-haspopup="true"
            :aria-expanded="isDropdownOpen"
        >
            <div
                class="relative flex items-center justify-center w-10 h-10 rounded-full bg-[#6F4E37] text-white font-bold text-sm flex-shrink-0 border border-slate-50 rounded-full"
            >
                {{ userInitials }}
                <span
                    class="absolute bottom-0 right-0 block w-3 h-3 bg-green-500 border-2 border-white rounded-full"
                ></span>
            </div>

            <transition
                enter-active-class="transition-opacity duration-200 ease-in-out"
                enter-from-class="opacity-0"
                leave-active-class="transition-opacity duration-200 ease-in-out"
                leave-to-class="opacity-0"
            >
                <div v-if="!isMinimized" class="ml-3">
                    <p class="text-sm font-semibold text-white truncate">
                        {{ user?.name }}
                    </p>
                    <p class="text-xs text-gray-300 truncate">
                        {{ user?.role ?? "User" }}
                    </p>
                </div>
            </transition>
        </div>

        <transition
            enter-active-class="transition duration-150 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <div
                v-if="isDropdownOpen"
                class="absolute z-50 w-64 mt-2 origin-bottom-left bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                :class="{
                    'bottom-full mb-2 right-0 translate-x-20': !isMinimized,
                    'left-full ml-2 bottom-0': isMinimized,
                }"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="user-menu-button"
            >
                <div class="px-4 py-3 border-b border-gray-200">
                    <p class="text-sm font-semibold text-gray-900">
                        Signed in as
                    </p>
                    <p class="text-sm text-gray-700 truncate">
                        {{ user?.name }}
                    </p>
                </div>

                <div class="py-1" role="none">
                    <a
                        href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                        >Your Profile</a
                    >
                    <a
                        href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                        >Settings</a
                    >
                </div>

                <div class="py-1 border-t border-gray-200" role="none">
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="flex items-center w-full px-4 py-2 text-sm text-left text-red-700 hover:bg-red-50"
                        role="menuitem"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 mr-2"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            />
                        </svg>
                        Logout
                    </Link>
                </div>
            </div>
        </transition>
    </div>
</template>
