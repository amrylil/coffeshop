import { ApiResponse } from "@/types/menu";
import { ref } from "vue";
import type { Ref } from "vue";
import { route } from "ziggy-js";
import { router } from "@inertiajs/vue3";

interface UseCart {
    loading: Ref<boolean>;
    error: Ref<string | null>;
    cartCount: Ref<number>;
    addToCart: (kodeMenu: string, quantity: number) => Promise<boolean>;
    loadCartCount: () => Promise<void>;
    isProcessing: Ref<boolean>;
    updateQuantity: (kodeItemKeranjang: number, newQuantity: number) => void;
    removeItem: (kodeItemKeranjang: number) => void;
    clearCart: () => void;
}

const getCsrfToken = (): string => {
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    return tokenMeta ? tokenMeta.getAttribute("content") || "" : "";
};

export function useCart(): UseCart {
    const loading = ref(false);
    const error = ref<string | null>(null);

    const cartCount = ref(0);

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
        kodeMenu: string,
        quantity: number = 1
    ): Promise<boolean> => {
        loading.value = true;
        error.value = null;

        try {
            const response = await fetch("/keranjang/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": getCsrfToken(),
                },
                body: JSON.stringify({
                    kode_menu: kodeMenu,
                    quantity: quantity,
                }),
            });

            const responseData = await response.json();

            if (!response.ok) {
                error.value =
                    responseData.message ||
                    "Terjadi kesalahan saat menambahkan item.";
                console.error("API Error:", responseData);
                return false;
            }

            console.log("Item berhasil ditambahkan:", responseData.data);
            return true;
        } catch (e: any) {
            console.error("Fetch Error:", e);
            error.value = "Tidak dapat terhubung ke server. Silakan coba lagi.";
            return false;
        } finally {
            loading.value = false;
        }
    };

    const isProcessing = ref(false);

    // Pindahkan semua fungsi aksi ke sini
    const updateQuantity = (kodeItemKeranjang: number, newQuantity: number) => {
        if (newQuantity < 1) {
            removeItem(kodeItemKeranjang);
            return;
        }

        router.put(
            route("keranjang.update", kodeItemKeranjang),
            {
                kode_item: kodeItemKeranjang,
                quantity: newQuantity,
            },
            {
                preserveScroll: true,
                onStart: () => {
                    isProcessing.value = true;
                },
                onFinish: () => {
                    isProcessing.value = false;
                },
            }
        );
    };

    const removeItem = (kodeItemKeranjang: number) => {
        if (confirm("Yakin ingin menghapus item ini?")) {
            router.delete(
                route("keranjang.remove", kodeItemKeranjang),

                {
                    preserveScroll: true,
                    onStart: () => {
                        isProcessing.value = true;
                    },
                    onFinish: () => {
                        isProcessing.value = false;
                    },
                }
            );
        }
    };

    const clearCart = () => {
        if (confirm("Yakin ingin mengosongkan keranjang?")) {
            router.post(
                route("keranjang.clear"),
                {},
                {
                    preserveScroll: true,
                    onStart: () => {
                        isProcessing.value = true;
                    },
                    onFinish: () => {
                        isProcessing.value = false;
                    },
                }
            );
        }
    };

    return {
        loading,
        error,
        loadCartCount,
        cartCount,
        addToCart,
        isProcessing,
        updateQuantity,
        removeItem,
        clearCart,
    };
}
