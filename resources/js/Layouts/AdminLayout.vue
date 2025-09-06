<script setup lang="ts">
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { PageProps, User } from "@/types";
import Sidebar from "./Partials/Sidebar.vue";
import Header from "./Partials/Header.vue";

const isSidebarMinimized = ref(false);
const toggleSidebar = () => {
    isSidebarMinimized.value = !isSidebarMinimized.value;
};

const page = usePage<PageProps>();
const user = computed<User | null>(() => page.props.auth.user);
</script>

<template>
    <div class="font-jost bg-[#6F4E37]">
        <Sidebar :is-minimized="isSidebarMinimized" @toggle="toggleSidebar" />

        <!-- <Header :user="user" :is-minimized="isSidebarMinimized" /> -->

        <main
            class="flex flex-col h-screen shadow-md transition-all duration-300 ease-in-out"
            :class="isSidebarMinimized ? 'sm:ml-20' : 'sm:ml-64'"
        >
            <div
                class="bg-gradient-to-br h-screen from-slate-50 to-gray-100 rounded-l-4xl overflow-auto"
            >
                <slot />
            </div>
        </main>
    </div>
</template>
