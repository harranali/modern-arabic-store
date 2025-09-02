<script setup>
import { ref } from "vue";
import { motion } from "motion-v";
import { ShoppingCart, Loader2, ChevronLeft, ChevronRight } from "lucide-vue-next";
import CartDrawer from "@/components/CartDrawer.vue";
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
    product: Object,
    relatedProducts: {
        type: Array,
        default: () => []
    },
});

// Gallery state
const currentImage = ref(0);

// Add to cart
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

// Navigate gallery
function prevImage() {
    currentImage.value = (currentImage.value === 0) ? props.product.images.length - 1 : currentImage.value - 1;
}
function nextImage() {
    currentImage.value = (currentImage.value === props.product.images.length - 1) ? 0 : currentImage.value + 1;
}

// Helper: excerpt
function createExcerpt(text, maxLength, ending = '...') {
    if (!text) return '';
    if (text.length <= maxLength) return text;
    const truncated = text.substr(0, maxLength);
    const lastSpace = truncated.lastIndexOf(' ');
    return lastSpace > 0 ? truncated.substr(0, lastSpace) + ending : truncated + ending;
}

// Breadcrumbs
const breadcrumbs = [
    { title: 'الرئيسية', href: '/' },
    { title: 'الفئات', href: '/categories' },
    { title: props.product.category.name, href: `/categories/${props.product.category.slug}` },
    { title: createExcerpt(props.product.name, 20), href: `/products/${props.product.slug}` }
];
</script>

<template>
    <MainLayout :breadcrumbs="breadcrumbs">
        <div dir="rtl" class="min-h-screen bg-gray-50 text-gray-900">

            <!-- Product Details -->
            <main class="max-w-6xl mx-auto px-4 pb-12 grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Product Gallery -->
                <motion.div :initial="{ opacity: 0, x: -20 }" :animate="{ opacity: 1, x: 0 }" class="relative w-full">
                    <img :src="'/' + props.product.images[currentImage]" alt=""
                        class="w-full h-[400px] object-cover rounded-2xl shadow-md" />

                    <!-- Arrows -->
                    <button @click="prevImage"
                        class="absolute top-1/2 -translate-y-1/2 left-2 bg-white/80 rounded-full p-2 hover:bg-white shadow-md">
                        <ChevronLeft class="w-5 h-5" />
                    </button>
                    <button @click="nextImage"
                        class="absolute top-1/2 -translate-y-1/2 right-2 bg-white/80 rounded-full p-2 hover:bg-white shadow-md">
                        <ChevronRight class="w-5 h-5" />
                    </button>

                    <!-- Thumbnails -->
                    <div class="flex gap-2 mt-4 overflow-x-auto">
                        <img v-for="(img, index) in props.product.images" :key="index" :src="'/' + img"
                            @click="currentImage = index"
                            :class="['w-20 h-20 object-cover rounded-lg cursor-pointer border-2', index === currentImage ? 'border-primary' : 'border-transparent']" />
                    </div>
                </motion.div>

                <!-- Product Info -->
                <motion.div :initial="{ opacity: 0, x: 20 }" :animate="{ opacity: 1, x: 0 }"
                    class="flex flex-col gap-4">
                    <h1 class="text-3xl font-bold">{{ props.product.name }}</h1>
                    <p class="text-xl text-primary font-semibold">{{ props.product.price }} ر.س</p>
                    <p class="text-gray-700">{{ props.product.description }}</p>

                    <Button @click="addToCart(props.product)" :disabled="loadingIds.includes(props.product.id)"
                        class="w-full py-3 bg-primary text-white rounded-xl flex items-center justify-center gap-2 hover:bg-primary/90 disabled:opacity-60 disabled:cursor-not-allowed transition-shadow shadow-sm hover:shadow-md">
                        <template v-if="loadingIds.includes(props.product.id)">
                            <Loader2 class="w-4 h-4 animate-spin" />
                            جاري الإضافة...
                        </template>
                        <template v-else>
                            <ShoppingCart class="w-4 h-4" />
                            أضف للسلة
                        </template>
                    </Button>

                    <!-- Tags / Categories -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span v-for="tag in props.product.tags" :key="tag"
                            class="px-3 py-1 rounded-full bg-gray-200 text-gray-800 text-sm">
                            {{ tag }}
                        </span>
                    </div>
                </motion.div>
            </main>

            <!-- Related Products -->
            <section v-if="props.relatedProducts.length" class="max-w-6xl mx-auto px-4 py-12">
                <h2 class="text-2xl font-bold mb-6">منتجات مشابهة</h2>
                <motion.div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6" :initial="{ opacity: 0 }"
                    :animate="{ opacity: 1 }">
                    <motion.div v-for="p in props.relatedProducts" :key="p.id" :initial="{ opacity: 0, y: 20 }"
                        :animate="{ opacity: 1, y: 0 }" :whileHover="{ scale: 1.03 }"
                        class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden group relative">
                        <Link :href="`/products/${p.slug}`">
                        <img :src="'/' + p.image" alt=""
                            class="w-full h-48 object-cover group-hover:scale-105 transition duration-300" />
                        </Link>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-1 truncate">{{ p.name }}</h3>
                            <p class="text-gray-600 mb-3 font-medium text-primary">{{ p.price }} ر.س</p>
                            <Button @click="addToCart(p)" :disabled="loadingIds.includes(p.id)"
                                class="w-full py-2 bg-primary text-white rounded-xl flex items-center justify-center gap-2 hover:bg-primary/90 disabled:opacity-60 disabled:cursor-not-allowed transition-shadow shadow-sm hover:shadow-md">
                                <template v-if="loadingIds.includes(p.id)">
                                    <Loader2 class="w-4 h-4 animate-spin" /> جاري الإضافة...
                                </template>
                                <template v-else>
                                    <ShoppingCart class="w-4 h-4" /> أضف للسلة
                                </template>
                            </Button>
                        </div>
                    </motion.div>
                </motion.div>
            </section>

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
