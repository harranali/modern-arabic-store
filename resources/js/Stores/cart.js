// resources/js/Stores/cart.js
import { defineStore } from "pinia";
import { ref, computed } from "vue";
import axios from "axios";

export const useCartStore = defineStore("cart", () => {
    const items = ref([]);
    const isOpen = ref(false);

    const count = computed(() =>
        items.value.reduce((acc, item) => acc + item.quantity, 0)
    );
    const total = computed(() =>
        items.value.reduce((acc, item) => acc + item.price * item.quantity, 0).toFixed(2)
    );

    function toggleCart() {
        isOpen.value = !isOpen.value;
    }

    async function fetchCart() {
        const res = await axios.get("/cart");
        items.value = Object.values(res.data.cart ?? res.data ?? {});
    }

    async function add(productId) {
        const res = await axios.post("/cart/add", { product_id: productId });
        await fetchCart();
        return res.data;
    }

    async function update(productId, quantity) {
        await axios.post("/cart/update", { product_id: productId, quantity });
        await fetchCart();
    }

    async function remove(productId) {
        await axios.post("/cart/remove", { product_id: productId });
        await fetchCart();
    }

    async function clear() {
        await axios.post("/cart/clear");
        await fetchCart();
    }

    return {
        items,
        isOpen,
        count,
        total,
        toggleCart,
        fetchCart,
        add,
        update,
        remove,
        clear
    };
});
