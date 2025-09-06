<script setup lang="ts">
import { User } from "@/types";
import UserMenu from "./UserMenu.vue";

defineProps<{
    user: User | null;
    isMinimized: boolean;
}>();
</script>

<template>
    <header
        class="fixed top-0 right-0 left-0 z-30 flex h-16 items-center justify-between bg-white p-4 px-9 pl-6 shadow-md transition-all duration-300 ease-in-out"
        :class="isMinimized ? 'sm:pl-28' : 'sm:pl-72'"
        aria-label="Header"
    >
        <div class="flex flex-col">
            <h1 class="text-2xl font-semibold text-amber-900">Administrator</h1>
        </div>

        <UserMenu :user="user" />
    </header>
</template>
