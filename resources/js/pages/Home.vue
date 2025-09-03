<script setup>
import { ref } from "vue"
import { Motion } from "motion-v"
import { ShoppingCart, Loader2 } from "lucide-vue-next"
import CartDrawer from "@/components/CartDrawer.vue"
import { useCartStore } from "@/Stores/cart"
import MainLayout from '@/layouts/MainLayout.vue'
import { useToast } from "vue-toastification"
import { Button } from '@/components/ui/button'
import { router, Link } from '@inertiajs/vue3'

const toast = useToast()
const cart = useCartStore()
const loadingIds = ref([])

const props = defineProps({
    products: Object,
    categories: Array,
    filters: Object,
})

// Initialize filters reactively
const filters = ref({
    category: props.filters.category ?? '',
    sortBy: props.filters.sort_by || '',
})

// Apply filters via Inertia
function applyFilters() {
    router.get('/', { category: filters.value.category, sort_by: filters.value.sortBy }, { preserveState: true, replace: true, preserveScroll: true })
}

// Add to cart
async function addToCart(product) {
    if (loadingIds.value.includes(product.id)) return

    loadingIds.value.push(product.id)
    try {
        await cart.add(product.id)
        toast.success('تم الإضافة إلي السلة بنجاح')
    } finally {
        loadingIds.value = loadingIds.value.filter(id => id !== product.id)
    }
}
</script>

<template>
    <MainLayout>
        <div class="-mt-12 min-h-screen bg-gray-50 text-gray-900">
            <!-- Hero -->
            <section class="relative overflow-hidden bg-gradient-to-br from-primary/30 via-white to-primary/10">
                <div class="absolute inset-0 -z-10">
                    <div class="absolute -top-32 -left-32 w-96 h-96 bg-primary/20 rounded-full blur-3xl animate-pulse">
                    </div>
                    <div
                        class="absolute bottom-0 right-0 w-80 h-80 bg-blue-300/30 rounded-full blur-2xl animate-bounce">
                    </div>
                </div>

                <div class="max-w-7xl mx-auto px-6 lg:px-12 py-20 grid md:grid-cols-2 items-center gap-10">
                    <Motion :initial="{ opacity: 0, x: -50 }" :animate="{ opacity: 1, x: 0 }"
                        :transition="{ duration: 0.8 }" class="text-center md:text-right space-y-6">
                        <h1
                            class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight bg-clip-text text-transparent bg-gradient-to-r from-primary to-blue-600">
                            اكتشف أحدث المنتجات
                            <br />
                            بجودة ✨ وأسعار لا تقاوم
                        </h1>

                        <p class="text-lg md:text-xl text-gray-600">
                            تسوق الآن وتمتع بتجربة عصرية وسهلة مع أفضل العروض.
                        </p>

                        <div class="flex justify-center md:justify-start gap-4">
                            <Button as="a" href="/products"
                                class="px-6 py-3 bg-primary text-white rounded-full shadow-lg hover:shadow-xl hover:bg-primary/90 transition transform hover:scale-105">
                                تسوق الآن
                            </Button>
                            <Button as="a" href="/categories"
                                class="px-6 py-3 bg-white/70 backdrop-blur-md text-primary border border-primary rounded-full shadow-md hover:bg-white transition">
                                تصفح الفئات
                            </Button>
                        </div>
                    </Motion>

                    <Motion :initial="{ opacity: 0, y: 40 }" :animate="{ opacity: 1, y: 0 }"
                        :transition="{ duration: 1 }" class="relative">
                        <img src="/images/products/phone-2.jpg" alt="منتجات مميزة"
                            class=" max-w-md mx-auto h-99 drop-shadow-2xl rounded-2xl" />
                        <div
                            class="absolute -bottom-6 -left-6 bg-white/40 backdrop-blur-xl px-6 py-3 rounded-2xl shadow-lg">
                            ⭐ آلاف العملاء يثقون بنا
                        </div>
                    </Motion>
                </div>
            </section>

            <!-- Filters -->
            <div class="max-w-7xl mx-auto px-4 mt-8 flex gap-4 flex-wrap justify-center">
                <select v-model="filters.sortBy" @change="applyFilters"
                    class="rounded-lg border-gray-300 px-4 py-2 shadow-sm hover:shadow-md transition">
                    <option value="">ترتيب</option>
                    <option value="price_asc">السعر: من الأقل</option>
                    <option value="price_desc">السعر: من الأعلى</option>
                </select>

                <select v-model="filters.category" @change="applyFilters" class="rounded-lg border px-4 py-2">
                    <option value="">كل الفئات</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                </select>
            </div>

            <!-- Products Grid -->
            <main id="products" class="max-w-7xl mx-auto px-4 py-12">
                <Motion :initial="{ opacity: 0 }" :animate="{ opacity: 1 }" :transition="{ staggerChildren: 0.1 }"
                    class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <Motion v-for="p in products.data" :key="p.id" :initial="{ opacity: 0, y: 20 }"
                        :animate="{ opacity: 1, y: 0 }" :whileHover="{ scale: 1.03 }"
                        class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden group relative">
                        <div class="overflow-hidden rounded-t-2xl">
                            <Link :href="`/products/${p.slug}`">
                            <img :src="`/images/${p.image}`" :alt="p.name"
                                class="w-full h-48 object-cover group-hover:scale-105 transition duration-300" />
                            </Link>
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-1 truncate" :title="p.name">
                                {{ p.name }}
                            </h3>
                            <p class="text-gray-600 mb-3 font-medium text-primary">
                                {{ p.price }} ر.س
                            </p>

                            <div class="flex gap-2">
                                <Button as="a" :href="`/products/${p.slug}`"
                                    class="flex-1 py-2 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300 transition-shadow shadow-sm hover:shadow-md text-center">
                                    عرض
                                </Button>

                                <Button @click="addToCart(p)" :disabled="loadingIds.includes(p.id)"
                                    class="flex-1 py-2 bg-primary text-white rounded-xl flex items-center justify-center gap-2 hover:bg-primary/90 disabled:opacity-60 disabled:cursor-not-allowed transition-shadow shadow-sm hover:shadow-md">
                                    <template v-if="loadingIds.includes(p.id)">
                                        <Loader2 class="w-4 h-4 animate-spin" />
                                        جاري الإضافة...
                                    </template>
                                    <template v-else>
                                        <ShoppingCart class="w-4 h-4" />
                                        أضف
                                    </template>
                                </Button>
                            </div>
                        </div>
                    </Motion>
                </Motion>
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
