<script setup lang="ts">
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";

// Definisikan path SVG untuk setiap ikon
const icons = {
    coffee: `<path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line>`,
    grid: `<rect x="3" y="3" width="7" height="7" rx="1"></rect><rect x="14" y="3" width="7" height="7" rx="1"></rect><rect x="3" y="14" width="7" height="7" rx="1"></rect><rect x="14" y="14" width="7" height="7" rx="1"></rect>`,
    users: `<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>`,
    table: `<path d="M3 10h18M3 14h18M5 6h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2z" />`,
    calendar: `<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>`,
    receipt: `<path d="M3 10h1m4 0h10M3 14h1m4 0h10M3 18h1m4 0h10"></path><path d="M21 8.35V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11.65a2 2 0 0 1 1.2.4L20.6 4.6a2 2 0 0 1 .4 1.2z"></path>`,
    report: `<path d="M9 17v-6a2 2 0 012-2h4a2 2 0 012 2v6m-6 0h6"></path><path d="M13 7h-2a2 2 0 00-2 2v6"></path><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"></path>`,
    box: `<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line>`,
    tag: `<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line>`,
};

const props = defineProps<{
    href: string;
    iconType: keyof typeof icons;
    isMinimized: boolean;
}>();

const isActive = computed(() => {
    const currentPath = usePage().url.split("?")[0];
    return currentPath === props.href;
});
</script>

<template>
    <Link
        :href="href"
        class="group flex items-center rounded-lg p-2.5 transition-all duration-200"
        :class="[
            isActive
                ? 'bg-slate-50 text-[#6F4E37]'
                : 'text-slate-50 hover:bg-slate-50 hover:text-[#6F4E37]',
            { 'justify-center': isMinimized },
        ]"
    >
        <svg
            class="h-5 w-5 flex-shrink-0 transition-colors duration-200"
            :class="
                isActive
                    ? 'stroke-[#6F4E37]'
                    : 'stroke-slate-50 group-hover:stroke-[#6F4E37]'
            "
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            v-html="icons[iconType]"
        ></svg>
        <span v-if="!isMinimized" class="ml-3 whitespace-nowrap"><slot /></span>
    </Link>
</template>
