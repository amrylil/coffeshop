<!-- components/Pagination.vue -->
<template>
  <div class="mt-12 flex justify-center">
    <nav class="pagination">
      <ul class="flex list-none p-0 m-0 justify-center">
        <li 
          v-for="link in paginationData.links" 
          :key="link.label"
          class="mx-0.5"
        >
          <Link
            v-if="link.url && !link.active"
            :href="link.url"
            class="block py-2 px-4 no-underline bg-[#eee3d2] text-[#3e1f1f] rounded transition-colors hover:bg-[#d4c7b6]"
            preserve-scroll
            v-html="link.label"
          />
          <span
            v-else
            :class="[
              'block py-2 px-4 rounded',
              link.active 
                ? 'bg-[#3e1f1f] text-white' 
                : 'bg-[#eee3d2] text-[#3e1f1f] opacity-50 cursor-not-allowed'
            ]"
            v-html="link.label"
          />
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface PaginationLink {
  url?: string;
  label: string;
  active: boolean;
}

interface PaginationData {
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
  links: PaginationLink[];
}

interface Props {
  paginationData: PaginationData;
}

defineProps<Props>();
</script>

<style scoped>
.pagination {
  display: flex;
  list-style: none;
  padding: 0;
  margin: 0;
  justify-content: center;
}

.pagination li {
  margin: 0 2px;
}

.pagination li a,
.pagination li span {
  display: block;
  padding: 8px 16px;
  text-decoration: none;
  background-color: #eee3d2;
  color: #3e1f1f;
  border-radius: 4px;
  transition: background-color 0.3s;
}

.pagination li.active span {
  background-color: #3e1f1f;
  color: white;
}

.pagination li a:hover {
  background-color: #d4c7b6;
}
</style>