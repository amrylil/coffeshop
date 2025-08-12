<script setup lang="ts">
import Navbar from "@/components/Partials/Navbar.vue";
import { Head } from "@inertiajs/vue3";

defineProps<{
    title?: string;
}>();
</script>

<template>
    <Head :title="title ? `${title} - Coffee Shop` : 'Coffee Shop'" />
    <div class="font-jost bg-[#fdfaf6]">
        <Navbar />
        <main class="relative bg-[#523433]">
            <slot />
        </main>
    </div>
</template>
