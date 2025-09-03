<script setup>
import { onMounted, ref } from "vue";
import { motion } from "motion-v";
import { X, Trash2, Loader2 } from "lucide-vue-next";
import { useCartStore } from "@/Stores/cart";
import { Button } from '@/components/ui/button';
import { useToast } from "vue-toastification";
import { router } from '@inertiajs/vue3';

const toast = useToast()
const cart = useCartStore();

const removingIds = ref([]);
const processingCheckout = ref(false);


const removeItem = async (id) => {
    if (removingIds.value.includes(id)) return;

    removingIds.value.push(id);
    try {
        await cart.remove(id);
        toast.success('تم إزالة العنصر من السلة بنجاح');
    } finally {
        removingIds.value = removingIds.value.filter(rid => rid !== id);
    }
};

const increaseQuantity = (item) => {
    cart.update(item.id, item.quantity + 1);
    toast.success('تم تحديث السلة بنجاج');
}

const decreaseQuantity = (item) => {
    cart.update(item.id, Math.max(1, item.quantity - 1))
    toast.success('تم تحديث السلة بنجاج');
}

// Go to checkout
const goToCheckout = async () => {
    if (cart.items.length === 0) return;
    cart.toggleCart();
    processingCheckout.value = true;
    await router.get('/checkout', {}, { preserveState: true });
    processingCheckout.value = false;
};

onMounted(() => {
    cart.fetchCart();
});
</script>

<template>
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/30 dark:bg-black/50 z-50" @click="$emit('close')"></div>

    <!-- Drawer -->
    <motion.div initial="{ x: '100%' }" animate="{ x: 0 }" exit="{ x: '100%' }" :transition="{ duration: 0.3 }"
        class="fixed top-0 right-0 w-80 md:w-96 h-full bg-white dark:bg-gray-900 shadow-lg z-50 flex flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b dark:border-gray-700">
            <h2 class="text-lg font-bold">سلة التسوق</h2>
            <button @click="$emit('close')" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                <X class="w-5 h-5" />
            </button>
        </div>

        <!-- Items -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4">
            <div v-if="cart.items.length === 0"
                class="flex items-center justify-center text-gray-500 dark:text-gray-400 h-full">
                السلة فارغة
            </div>
            <div v-for="item in cart.items" :key="item.id"
                class="flex items-center gap-3 bg-gray-50 dark:bg-gray-800 rounded-lg p-3">
                <img :src="`/images/${item.image}`" class="w-16 h-16 object-cover rounded-lg" />
                <div class="flex-1">
                    <div class="font-semibold">{{ item.name }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                        {{ item.price }} ر.س ×
                        <!-- Quantity Control -->
                        <div class="flex items-center border rounded dark:border-gray-600">
                            <Button variant="outline" @click="decreaseQuantity(item)"
                                class="px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-l">
                                −
                            </Button>
                            <span class="px-3">{{ item.quantity }}</span>
                            <Button variant="outline" @click="increaseQuantity(item)"
                                class="px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-r">
                                +
                            </Button>
                        </div>
                    </div>
                </div>
                <button @click="removeItem(item.id)" :disabled="removingIds.includes(item.id)"
                    class="text-red-500 hover:text-red-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <Loader2 v-if="removingIds.includes(item.id)" class="w-5 h-5 animate-spin" />
                    <Trash2 v-else class="w-5 h-5" />
                </button>
            </div>

        </div>

        <!-- Footer -->
        <div class="border-t dark:border-gray-700 p-4">
            <div class="flex justify-between text-lg font-semibold mb-4">
                <span>الإجمالي:</span>
                <span>{{ cart.total }} ر.س</span>
            </div>
            <button @click="goToCheckout"
                class="w-full py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition flex items-center justify-center gap-2"
                :disabled="cart.items.length === 0 || processingCheckout">
                <Loader2 v-if="processingCheckout" class="w-5 h-5 animate-spin" />
                <span v-else>إتمام الشراء</span>
            </button>
        </div>
    </motion.div>
</template>

<style>
.flex-1::-webkit-scrollbar {
    width: 6px;
}

.flex-1::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 10px;
}

.dark .flex-1::-webkit-scrollbar-thumb {
    background-color: #555;
}
</style>
