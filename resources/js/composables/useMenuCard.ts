import { Menu } from "@/types/menu";
import { ref, computed, Ref } from "vue";

interface Props {
    menu: Menu;
}

type EmitFn = (event: "add-to-cart" | "click", payload: Menu) => void;

export function useMenuCard(props: Props, emit: EmitFn) {
    const imageLoading: Ref<boolean> = ref(true);
    const isAdding: Ref<boolean> = ref(false);
    const isFavorite: Ref<boolean> = ref(false);

    const formatPrice = computed(() => {
        return (price: number) => new Intl.NumberFormat("id-ID").format(price);
    });

    const addToCart = async () => {
        isAdding.value = true;
        try {
            await new Promise((resolve) => setTimeout(resolve, 800));
            emit("add-to-cart", props.menu);
            console.log("Item added to cart:", props.menu.nama);
        } catch (error) {
            console.error("Failed to add item to cart:", error);
        } finally {
            isAdding.value = false;
        }
    };

    const toggleFavorite = () => {
        isFavorite.value = !isFavorite.value;
    };

    const handleClick = () => {
        emit("click", props.menu);
    };

    const handleImageError = () => {
        imageLoading.value = false;
    };

    return {
        imageLoading,
        isAdding,
        isFavorite,
        formatPrice,
        addToCart,
        toggleFavorite,
        handleClick,
        handleImageError,
    };
}
