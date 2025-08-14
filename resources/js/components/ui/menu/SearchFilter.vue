<template>
  <div class="max-w-7xl mx-auto px-4 mb-12">
    <div class="bg-[#e6dbd1] rounded-2xl shadow-lg border border-gray-100 p-6">
      <div class="flex flex-col lg:flex-row gap-6">
        <!-- Search Section -->
        <div class="lg:w-1/2">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
            <input 
              v-model="props.filters.search"
              type="text" 
              placeholder="Search for menu items..."
              class="w-full pl-12 pr-4 py-3 rounded-xl border border-coklat focus:ring-2 focus:ring-[#3e1f1f] focus:border-transparent text-[#3e1f1f] placeholder-gray-500 transition-all duration-200 hover:border-gray-300"
            >
          </div>
        </div>

        <!-- Category Filters Section -->
        <div class="lg:w-1/2">
          <div class="flex flex-wrap gap-2 justify-start lg:justify-end">
            <button
              @click="props.filters.category = null"
              :class="[
                'px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5',
                props.filters.category === null 
                  ? 'bg-[#3e1f1f] text-white shadow-lg' 
                  : 'bg-[#f8f4ed] text-[#3e1f1f] border border-[#eee3d2] hover:bg-[#eee3d2]'
              ]"
            >
              All Categories
            </button>
            <button
              v-for="category in categories"
              :key="category.kode_kategori"
              @click="props.filters.category = category.kode_kategori"
              :class="[
                'px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5',
                props.filters.category === category.kode_kategori 
                  ? 'bg-[#3e1f1f] text-white shadow-lg' 
                  : 'bg-[#f8f4ed] text-[#3e1f1f] border border-[#eee3d2] hover:bg-[#eee3d2]'
              ]"
            >
              {{ category.nama }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Category } from '@/types/menu';

interface Props {
  categories: Category[];
  filters: {
    search?: string;
    category?: string | null;
  };
}

const props = defineProps<Props>();
</script>