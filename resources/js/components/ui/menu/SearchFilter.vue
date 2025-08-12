<template>
  <div class="max-w-7xl mx-auto px-4 mb-12">
    <div class="flex flex-col lg:flex-row justify-between gap-6">
      <div class="lg:w-1/2">
        <div class="flex border border-slate-50 rounded-lg">
          <input 
            v-model="props.filters.search"
            type="text" 
            placeholder="Search for menu items..."
            class="w-full text-slate-50 px-4 py-2 rounded-l-lg border-0 focus:ring-2 focus:ring-[#3e1f1f] text-[#3e1f1f]"
          >
          <button 
            type="button"
            class="bg-[#3e1f1f] text-white px-4 py-2 rounded-r-lg"
          >
            </button>
        </div>
      </div>

      <div class="lg:w-1/2 flex flex-wrap gap-2 justify-end">
        <button
          @click="props.filters.category = null"
          :class="[
            'px-4 py-2 rounded-full text-sm font-medium',
            props.filters.category === null 
              ? 'bg-[#3e1f1f] text-white' 
              : 'bg-[#eee3d2] text-[#3e1f1f]'
          ]"
        >
          All
        </button>
        <button
          v-for="category in categories"
          :key="category.kode_kategori"
          @click="props.filters.category = category.kode_kategori"
          :class="[
            'px-4 py-2 rounded-full text-sm font-medium',
            props.filters.category === category.kode_kategori 
              ? 'bg-[#3e1f1f] text-white' 
              : 'bg-[#eee3d2] text-[#3e1f1f]'
          ]"
        >
          {{ category.nama }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Category } from '@/types/menu';

// DIUBAH: props sekarang menerima object 'filters'
interface Props {
  categories: Category[];
  filters: {
    search?: string;
    category?: string | null;
  };
}

const props = defineProps<Props>();

</script>