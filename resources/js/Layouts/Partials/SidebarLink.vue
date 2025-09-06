<script setup lang="ts">
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";

const icons = {
    coffee: `<path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line>`,
    grid: `<rect x="3" y="3" width="7" height="7" rx="1"></rect><rect x="14" y="3" width="7" height="7" rx="1"></rect><rect x="3" y="14" width="7" height="7" rx="1"></rect><rect x="14" y="14" width="7" height="7" rx="1"></rect>`,
    users: `<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>`,
    table: `<path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18M5 6h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2z" />`,
    calendar: `<path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-5a2 2 0 00-2-2H5a2 2 0 00-2 2v5a2 2 0 002 2z"></path>`,
    receipt: `<path stroke-linecap="round" stroke-linejoin="round" d="M3 10h1M3 14h1M7 10h10M7 14h10M7 18h10M3 18h1"></path>`,
    report: `<path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6a2 2 0 012-2h4a2 2 0 012 2v6m-6 0h6"></path><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h-2a2 2 0 00-2 2v6"></path>`,
};

const props = defineProps<{
    href: string;
    iconType: keyof typeof icons;
    isMinimized: boolean; // <-- TAMBAHKAN: Terima prop isMinimized
}>();

const currentUrl = computed(() => usePage().url);

const isActive = computed(() => currentUrl.value.startsWith(props.href));

// Determine the correct route name from the href
const routeName = computed(() => {
    // A simple mapping logic, you may need to adjust it based on your actual route names
    const parts = props.href.split("/").filter(Boolean); // e.g., ['admin', 'menu']
    if (parts.length >= 2) {
        return `${parts[0]}.${parts[1]}.index`;
    }
    return "admin.dashboard"; // fallback
});
</script>

<template>
    <Link
        :href="route(routeName)"
        class="group flex items-center rounded-lg p-2.5 transition-all duration-200"
        :class="[
            isActive
                ? 'bg-slate-50 text-[#6F4E37]'
                : 'text-slate-50 hover:bg-slate-50 hover:text-[#6F4E37]',
            { 'justify-center': isMinimized },
        ]"
    >
        <svg
            class="h-5 w-5 transition-colors duration-200 group-hover:stroke-[#6F4E37]"
            :class="isActive ? 'stroke-[#6F4E37] ' : 'stroke-slate-50'"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            v-html="icons[iconType]"
        ></svg>
        <span v-if="!isMinimized" class="ml-3"><slot /></span>
    </Link>
</template>
