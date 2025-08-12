// composables/useMenu.ts
import { ref, onMounted, onUnmounted } from "vue";
import { router } from "@inertiajs/vue3";
import type { Menu, ApiResponse, ToastType } from "@/types/menu";
import { route } from "ziggy-js";

export const useScrollToTop = () => {
    const isVisible = ref(false);

    const handleScroll = () => {
        isVisible.value = window.scrollY > 300;
    };

    const scrollToTop = () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    };

    onMounted(() => {
        window.addEventListener("scroll", handleScroll);
    });

    onUnmounted(() => {
        window.removeEventListener("scroll", handleScroll);
    });

    return {
        isVisible,
        scrollToTop,
    };
};

export const useCart = () => {
    const cartCount = ref(0);
    const isLoading = ref(false);

    const loadCartCount = async () => {
        try {
            const response = await fetch(route("keranjang.count"), {
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN":
                        document
                            .querySelector<HTMLMetaElement>(
                                'meta[name="csrf-token"]'
                            )
                            ?.getAttribute("content") || "",
                },
            });

            const data: ApiResponse = await response.json();

            if (data.success && typeof data.count === "number") {
                cartCount.value = data.count;
            }
        } catch (error) {
            console.error("Error loading cart count:", error);
        }
    };

    const addToCart = async (
        menuId: string,
        quantity: number = 1
    ): Promise<ApiResponse> => {
        isLoading.value = true;

        try {
            const response = await fetch(route("keranjang.add"), {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN":
                        document
                            .querySelector<HTMLMetaElement>(
                                'meta[name="csrf-token"]'
                            )
                            ?.getAttribute("content") || "",
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: JSON.stringify({
                    kode_menu: menuId,
                    quantity,
                }),
            });

            const data: ApiResponse = await response.json();

            if (data.success) {
                await loadCartCount();
            }

            return data;
        } catch (error) {
            console.error("Error adding to cart:", error);
            return {
                success: false,
                message: "An error occurred. Please try again.",
            };
        } finally {
            isLoading.value = false;
        }
    };

    return {
        cartCount,
        isLoading,
        loadCartCount,
        addToCart,
    };
};

export const useToast = () => {
    const isVisible = ref(false);
    const message = ref("");
    const type = ref<ToastType>("success");

    const showToast = (
        toastMessage: string,
        toastType: ToastType = "success"
    ) => {
        message.value = toastMessage;
        type.value = toastType;
        isVisible.value = true;

        setTimeout(() => {
            isVisible.value = false;
        }, 3000);
    };

    return {
        isVisible,
        message,
        type,
        showToast,
    };
};

import { reactive, watch } from "vue";
import { pickBy } from "lodash";

// Composable baru yang lebih baik untuk filtering
export const useMenuFilter = (initialFilters: any) => {
    const filters = reactive({
        search: initialFilters.search || "",
        category: initialFilters.category || null,
    });

    // Gunakan watch untuk otomatis memfilter saat nilai berubah
    watch(
        filters,
        () => {
            // pickBy dari lodash akan menghapus key dengan nilai null/kosong
            // agar URL lebih bersih
            const queryParams = pickBy(filters);

            router.get(route("menu.index"), queryParams, {
                preserveState: true,
                preserveScroll: true,
                replace: true, // replace:true agar tidak menumpuk history browser
            });
        },
        { deep: true }
    ); // deep:true untuk memantau perubahan di dalam object

    return { filters };
};

export const useModal = () => {
    const isLoginModalVisible = ref(false);

    const showLoginModal = () => {
        isLoginModalVisible.value = true;
    };

    const hideLoginModal = () => {
        isLoginModalVisible.value = false;
    };

    const goToLogin = () => {
        router.visit(route("login"));
    };

    return {
        isLoginModalVisible,
        showLoginModal,
        hideLoginModal,
        goToLogin,
    };
};
