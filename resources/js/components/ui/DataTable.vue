<script setup lang="ts">
import { ref, computed, watch } from "vue";

interface Header {
    key: string;
    label: string;
}

interface FilterOption {
    key: string;
    label: string;
    options: { value: any; label: string }[];
}

const props = withDefaults(
    defineProps<{
        headers: Header[];
        items: any[];
        searchKeys?: string[];
        itemsPerPage?: number;
        filters?: FilterOption[];
        enableFilter?: boolean;
    }>(),
    {
        searchKeys: () => [],
        itemsPerPage: 10,
        filters: () => [],
        enableFilter: false,
    }
);

const searchQuery = ref("");
const currentPage = ref(1);
const activeFilters = ref<Record<string, any>>({});
const showFilterDropdown = ref(false);

const filteredItems = computed(() => {
    let result = props.items;

    // Filtering berdasarkan search
    if (searchQuery.value) {
        result = result.filter((item) => {
            if (props.searchKeys.length > 0) {
                return props.searchKeys.some((key) =>
                    String(item[key])
                        .toLowerCase()
                        .includes(searchQuery.value.toLowerCase())
                );
            }
            return Object.values(item).some((value) =>
                String(value)
                    .toLowerCase()
                    .includes(searchQuery.value.toLowerCase())
            );
        });
    }

    Object.keys(activeFilters.value).forEach((filterKey) => {
        const filterValue = activeFilters.value[filterKey];
        if (filterValue !== "" && filterValue != null) {
            result = result.filter(
                (item) => String(item[filterKey]) === String(filterValue)
            );
        }
    });

    return result;
});

const totalPages = computed(() => {
    return Math.ceil(filteredItems.value.length / props.itemsPerPage);
});

const paginatedItems = computed(() => {
    const start = (currentPage.value - 1) * props.itemsPerPage;
    const end = start + props.itemsPerPage;
    return filteredItems.value.slice(start, end);
});

const goToPage = (page: number) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

watch(searchQuery, () => {
    currentPage.value = 1;
});
</script>

<template>
    <div
        class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100"
    >
        <!-- Simple Header Section -->
        <div class="p-4 sm:p-6 border-b border-gray-200 bg-gray-50">
            <div
                class="flex flex-col sm:flex-row items-center justify-between gap-4"
            >
                <!-- Search Section -->
                <div class="flex-1 max-w-md w-full">
                    <div class="relative">
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                        >
                            <svg
                                class="w-5 h-5 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                ></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Filter Button -->
                <div v-if="enableFilter && filters.length > 0" class="relative">
                    <button
                        @click="showFilterDropdown = !showFilterDropdown"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <svg
                            class="w-4 h-4 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"
                            ></path>
                        </svg>
                        Filter
                        <span
                            v-if="Object.values(activeFilters).some((v) => v)"
                            class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-blue-600 bg-blue-100 rounded-full"
                        >
                            {{
                                Object.values(activeFilters).filter((v) => v)
                                    .length
                            }}
                        </span>
                    </button>

                    <!-- Dropdown -->
                    <div
                        v-if="showFilterDropdown"
                        class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                    >
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-medium text-gray-900">
                                    Filters
                                </h3>
                                <button
                                    @click="showFilterDropdown = false"
                                    class="text-gray-400 hover:text-gray-500"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        ></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="space-y-3">
                                <template
                                    v-for="filter in filters"
                                    :key="filter.key"
                                >
                                    <div>
                                        <label
                                            class="block text-xs font-medium text-gray-700 mb-1"
                                        >
                                            {{ filter.label }}
                                        </label>
                                        <select
                                            v-model="activeFilters[filter.key]"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        >
                                            <option value="">
                                                All {{ filter.label }}
                                            </option>
                                            <option
                                                v-for="opt in filter.options"
                                                :key="opt.value"
                                                :value="opt.value"
                                            >
                                                {{ opt.label }}
                                            </option>
                                        </select>
                                    </div>
                                </template>
                            </div>
                            <div
                                v-if="
                                    Object.values(activeFilters).some((v) => v)
                                "
                                class="mt-3 pt-3 border-t border-gray-200"
                            >
                                <button
                                    @click="
                                        activeFilters = {};
                                        showFilterDropdown = false;
                                    "
                                    class="text-sm text-blue-600 hover:text-blue-700 font-medium"
                                >
                                    Clear all filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom actions slot -->
                <div v-if="$slots['header-actions']">
                    <slot name="header-actions"></slot>
                </div>
            </div>

            <!-- Stats -->
            <div
                v-if="
                    searchQuery || Object.values(activeFilters).some((v) => v)
                "
                class="mt-4 flex items-center justify-between text-sm text-gray-600"
            >
                <span>{{ filteredItems.length }} results found</span>
                <button
                    @click="
                        searchQuery = '';
                        activeFilters = {};
                    "
                    class="text-blue-600 hover:text-blue-700 font-medium"
                >
                    Clear all
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th
                            v-for="header in headers"
                            :key="header.key"
                            scope="col"
                            class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider"
                        >
                            <slot
                                :name="`header(${header.key})`"
                                :header="header"
                            >
                                {{ header.label }}
                            </slot>
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-4 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider"
                        >
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="paginatedItems.length === 0">
                        <td
                            :colspan="headers.length + 1"
                            class="px-6 py-16 text-center"
                        >
                            <div
                                class="flex flex-col items-center justify-center text-gray-500"
                            >
                                <svg
                                    class="w-12 h-12 mb-4 text-gray-300"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                                    ></path>
                                </svg>
                                <slot name="empty">
                                    <p class="text-lg font-medium">
                                        No data found
                                    </p>
                                    <p class="text-sm text-gray-400 mt-1">
                                        Try adjusting your search or filter
                                        criteria
                                    </p>
                                </slot>
                            </div>
                        </td>
                    </tr>
                    <tr
                        v-for="item in paginatedItems"
                        :key="item.id || item.kode_menu"
                        class="hover:bg-gray-50"
                    >
                        <td
                            v-for="header in headers"
                            :key="header.key"
                            class="px-6 py-4 whitespace-nowrap text-base"
                        >
                            <slot :name="`cell(${header.key})`" :item="item">
                                <span class="text-gray-800">{{
                                    item[header.key]
                                }}</span>
                            </slot>
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-base text-center"
                        >
                            <div
                                class="flex items-center justify-center space-x-3"
                            >
                                <slot name="actions" :item="item"></slot>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div
            v-if="totalPages > 1"
            class="p-4 sm:p-6 border-t border-gray-200 bg-gray-50 flex justify-between items-center"
        >
            <span class="text-sm text-gray-600">
                Page {{ currentPage }} of {{ totalPages }}
            </span>
            <div class="flex items-center gap-2">
                <button
                    @click="goToPage(currentPage - 1)"
                    :disabled="currentPage === 1"
                    class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Prev
                </button>
                <button
                    @click="goToPage(currentPage + 1)"
                    :disabled="currentPage === totalPages"
                    class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Next
                </button>
            </div>
        </div>
    </div>
</template>
