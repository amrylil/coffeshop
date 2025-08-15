import { ref } from "vue";
import type { Ref } from "vue";
import { router } from "@inertiajs/vue3";
import { useCart } from "./useCart";

interface CheckoutItem {
    kode_menu: string;
    jumlah: number;
    harga: number;
}

interface CheckoutData {
    items: CheckoutItem[];
    total_harga: number;
    catatan?: string;
}

interface UseCheckout {
    isProcessing: Ref<boolean>;
    error: Ref<string | null>;
    processCheckout: (data: CheckoutData) => Promise<void>;
}

const getCsrfToken = (): string => {
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    return tokenMeta ? tokenMeta.getAttribute("content") || "" : "";
};

export function useCheckout(): UseCheckout {
    const isProcessing = ref(false);
    const error = ref<string | null>(null);

    const { clearCart } = useCart();

    const updateStatus = async (orderId: string, status: string) => {
        try {
            await fetch(`/transaksi/update-status`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": getCsrfToken(),
                },
                body: JSON.stringify({
                    order_id: orderId,
                    status: status,
                }),
            });
        } catch (err) {
            console.error("Gagal update status transaksi:", err);
        }
    };

    const processCheckout = async (data: CheckoutData) => {
        isProcessing.value = true;
        error.value = null;

        try {
            const response = await fetch("/transaksi/create", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": getCsrfToken(),
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();
            console.log("Checkout Result:", result);

            if (!response.ok) {
                throw new Error(
                    result.message || "Gagal memulai proses checkout."
                );
            }

            const snapToken = result.snap_token;
            if (!snapToken) {
                throw new Error("Snap Token tidak diterima dari server.");
            }

            window.snap.pay(snapToken, {
                onSuccess: async function (paymentResult) {
                    console.log("Payment Success:", paymentResult);
                    await updateStatus(paymentResult.order_id, "paid");
                    alert("Pembayaran sukses!");
                    router.visit(`/transaksi/${paymentResult.order_id}`);
                    clearCart();
                },
                onPending: async function (paymentResult) {
                    console.log("Payment Pending:", paymentResult);
                    await updateStatus(paymentResult.order_id, "pending");
                    alert("Pembayaran Anda sedang diproses.");
                    router.visit(`/transaksi/${paymentResult.order_id}`);
                },
                onError: async function (paymentResult) {
                    console.error("Payment Error:", paymentResult);
                    await updateStatus(paymentResult.order_id, "failed");
                    error.value =
                        "Terjadi kesalahan saat pembayaran. Silakan coba lagi.";
                },
                onClose: function () {
                    console.log(
                        "Customer closed the popup without finishing the payment"
                    );
                },
            });
        } catch (e: any) {
            console.error("Checkout Error:", e);
            error.value = e.message || "Tidak dapat terhubung ke server.";
        } finally {
            isProcessing.value = false;
        }
    };

    return {
        isProcessing,
        error,
        processCheckout,
    };
}
