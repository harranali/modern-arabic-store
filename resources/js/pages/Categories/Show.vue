<script setup>
import { ref } from "vue";
import { motion } from "motion-v";
import { ShoppingCart, Loader2 } from "lucide-vue-next";
import CartDrawer from "@/Components/CartDrawer.vue";
import { useCartStore } from "@/Stores/cart";
import MainLayout from '@/layouts/MainLayout.vue';
import { useToast } from "vue-toastification";
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';

const toast = useToast();
const cart = useCartStore();
const loadingIds = ref([]);

// Props from server
const props = defineProps({
    category: Object,
    products: Object,
});

async function addToCart(product) {
    if (loadingIds.value.includes(product.id)) return;

    loadingIds.value.push(product.id);
    try {
        await cart.add(product.id);
        toast.success('✅ تم الإضافة إلي السلة بنجاح');
    } catch (e) {
        toast.error('❌ حدث خطأ أثناء الإضافة');
    } finally {
        loadingIds.value = loadingIds.value.filter(id => id !== product.id);
    }
}

const breadcrumbs = [
    { title: 'الرئيسية', href: '/' },
    { title: 'الفئات', href: '/categories' },
    { title: props.category.name, href: `/categories/${props.category.slug}` }
];
</script>

<template>
    <MainLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-gray-50 text-gray-900">

            <!-- Hero / Category Title -->
            <section class="bg-gradient-to-r from-primary/20 to-primary/5 py-16 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-2">{{ category.name }}</h1>
                <p class="text-gray-600">{{ category.description }}</p>
            </section>

            <!-- Products Grid -->
            <main class="max-w-7xl mx-auto px-4 py-12">
                <motion.div :initial="{ opacity: 0 }" :animate="{ opacity: 1 }" :transition="{ staggerChildren: 0.1 }"
                    class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <motion.div v-for="p in products.data" :key="p.id" :initial="{ opacity: 0, y: 20 }"
                        :animate="{ opacity: 1, y: 0 }" :whileHover="{ scale: 1.03 }"
                        class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden group relative">
                        <div class="overflow-hidden rounded-t-2xl">
                            <Link :href="`/products/${p.slug}`">
                            <img :src="`/${p.image}`" :alt="p.name"
                                class="w-full h-48 object-cover group-hover:scale-105 transition duration-300"
                                loading="lazy" />
                            </Link>
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-1 truncate" :title="p.name">{{ p.name }}</h3>
                            <p class="text-gray-600 mb-3 font-medium text-primary">{{ p.price }} ر.س</p>

                            <div class="flex gap-2">
                                <Button as="a" :href="`/products/${p.slug}`"
                                    class="flex-1 py-2 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300 transition-shadow shadow-sm text-center">
                                    عرض
                                </Button>

                                <Button @click="addToCart(p)" :disabled="loadingIds.includes(p.id)"
                                    class="flex-1 py-2 bg-primary text-white rounded-xl flex items-center justify-center gap-2 hover:bg-primary/90 disabled:opacity-60 disabled:cursor-not-allowed transition-shadow shadow-sm hover:shadow-md">
                                    <template v-if="loadingIds.includes(p.id)">
                                        <Loader2 class="w-4 h-4 animate-spin" /> جاري الإضافة...
                                    </template>
                                    <template v-else>
                                        <ShoppingCart class="w-4 h-4" /> أضف
                                    </template>
                                </Button>
                            </div>
                        </div>
                    </motion.div>
                </motion.div>
            </main>

            <!-- Cart Drawer -->
            <CartDrawer v-if="cart.isOpen" @close="cart.toggleCart" />
        </div>
    </MainLayout>
</template>

<style>
:root {
    --primary: #3b82f6;
    --primary-hover: #2563eb;
}

.text-primary {
    color: var(--primary);
}

.bg-primary {
    background-color: var(--primary);
}

.bg-primary:hover {
    background-color: var(--primary-hover);
}

button:disabled {
    cursor: not-allowed;
}
</style>
