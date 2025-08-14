<script setup lang="ts">
import Navbar from "@/components/Partials/Navbar.vue";
import UserSidebar from "@/components/ui/user/UserSidebar.vue";
import { PageProps, User } from "@/types";
import { Head, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue"; // <-- PERUBAHAN DI SINI

defineProps<{
    title?: string;
}>();

const profileDrawerOpen = ref<boolean>(false);

const page = usePage<PageProps>();
const authUser = computed<User | null>(() => page.props.auth.user);
</script>

<template>
    <Head :title="title ? `${title} - Coffee Shop` : 'Coffee Shop'" />
    <div class="font-jost bg-[#fdfaf6]">
        <Navbar @toggle-sidebar="profileDrawerOpen = true" />
        <main class="relative bg-[#523433]">
            <slot />
            <UserSidebar
                v-if="authUser"
                :is-open="profileDrawerOpen"
                :user="authUser"
                @close="profileDrawerOpen = false"
            />
        </main>
    </div>
</template>
