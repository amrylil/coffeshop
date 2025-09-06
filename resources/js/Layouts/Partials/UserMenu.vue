<script setup lang="ts">
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { User } from "@/types";

const props = defineProps<{
    user: User | null;
}>();

// Dropdown state is now local to this component
const isDropdownOpen = ref(false);

const userInitials = computed(() => {
    if (!props.user?.name) return "";
    const nameParts = props.user.name.split(" ");
    const firstNameInitial = nameParts[0]?.[0] ?? "";
    const lastNameInitial =
        nameParts.length > 1 ? nameParts[nameParts.length - 1]?.[0] ?? "" : "";
    return `${firstNameInitial}${lastNameInitial}`.toUpperCase();
});
</script>

<template>
    <div class="relative">
        <div class="flex items-center gap-3">
            <div class="font-medium text-amber-800">
                {{ user?.name }}
            </div>
            <div
                @click="isDropdownOpen = !isDropdownOpen"
                tabindex="0"
                role="button"
                class="relative flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-gray-600 text-white transition-all duration-200 hover:shadow-md"
            >
                <div
                    class="relative flex h-10 w-10 items-center justify-center overflow-hidden rounded-full border-2 border-white bg-[#422424] shadow-lg"
                >
                    <span class="text-lg font-bold text-white">{{
                        userInitials
                    }}</span>
                    <div
                        class="absolute inset-0 rounded-full bg-white opacity-10 mix-blend-overlay"
                    ></div>
                </div>
            </div>
        </div>

        <ul
            v-show="isDropdownOpen"
            @click.outside="isDropdownOpen = false"
            class="absolute right-0 z-[100] mt-2 w-56 rounded-lg border border-amber-100 bg-white p-2 shadow-lg"
        >
            <div class="my-1 border-t border-amber-100"></div>
            <li>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="flex w-full items-center rounded-md px-4 py-2 text-left text-amber-900 transition-colors duration-150 hover:bg-amber-50"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mr-2 h-5 w-5"
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
</template>
