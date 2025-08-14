<template>
    <AppLayout title="Coffee Selection">
        <section class="min-h-screen py-12 mt-16">
            <div>
                <MenuHeader />

                <SearchFilter :categories="categories" :filters="filters" />

                <div v-if="menu.data.length === 0" class="text-center py-12">
                    <p class="text-xl text-[#e6dbd1]">
                        No menu items found matching your criteria.
                    </p>
                </div>

                <div v-else class="max-w-7xl mx-auto px-4">
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"
                    >
                        <CardMenu
                            v-for="item in menu.data"
                            :key="item.kode_menu"
                            :menu="item"
                            :loading="loadingMenuId === item.kode_menu"
                            @add-to-cart="
                                handleAddToCart(item.kode_menu, item.nama)
                            "
                            @click="
                                router.visit(route('menu.show', item.kode_menu))
                            "
                            class="fade-in"
                        />
                    </div>
                </div>
            </div>

            <ScrollToTop
                :is-visible="scrollButtonVisible"
                @scroll-to-top="handleScrollToTop"
            />
        </section>

        <Toast
            :is-visible="toast.isVisible"
            :message="toast.message"
            :type="toast.type"
        />
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import {
    useScrollToTop,
    useToast,
    useModal,
    useMenuFilter,
} from "@/composables/useMenu";
import type { MenuPageProps } from "@/types/menu";
import MenuHeader from "@/components/ui/menu/MenuHeader.vue";
import SearchFilter from "@/components/ui/menu/SearchFilter.vue";
import ScrollToTop from "@/components/ui/ScrollToTop.vue";
import { route } from "ziggy-js";
import CardMenu from "@/components/ui/CardMenu.vue";
import { useCart } from "@/composables/useCart";

const props = defineProps<MenuPageProps>();

const { isVisible: scrollButtonVisible, scrollToTop } = useScrollToTop();
const { addToCart } = useCart();
const toast = useToast();
const modal = useModal();
const { filters } = useMenuFilter(props.filters);

const loadingMenuId = ref<string | null>(null);

const handleAddToCart = async (menuId: string, menuName: string) => {
    if (!props.auth.user) {
        modal.showLoginModal();
        return;
    }
    loadingMenuId.value = menuId;
    try {
        const result = await addToCart(menuId, 1);
        if (result) {
            toast.showToast(`${menuName} added to cart!`, "success");
        } else {
            toast.showToast("Failed to add item to cart", "error");
        }
    } catch (error) {
        toast.showToast("An error occurred. Please try again.", "error");
    } finally {
        loadingMenuId.value = null;
    }
};

const handleScrollToTop = () => {
    scrollToTop();
};
</script>
