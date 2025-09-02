<script setup>
import { ref, onMounted } from "vue";
import { ShoppingCart, Sun, Moon } from "lucide-vue-next";
import CartDrawer from "@/components/CartDrawer.vue";
import { useCartStore } from "@/Stores/cart";
import Breadcrumbs from '@/components/Breadcrumbs.vue';

const search = ref("");
const darkMode = ref(false);
const cart = useCartStore();

function applySearch() {
    if (search.value.trim()) {
        window.location.href = `/?q=${search.value}`;
    }
}

function toggleDarkMode() {
    darkMode.value = !darkMode.value;
    if (darkMode.value) {
        document.documentElement.classList.add("dark");
        localStorage.setItem("theme", "dark");
    } else {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("theme", "light");
    }
}

onMounted(() => {
    const saved = localStorage.getItem("theme");
    if (
        saved === "dark" ||
        (!saved && window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
        darkMode.value = true;
        document.documentElement.classList.add("dark");
    }

    cart.fetchCart();
});

const props = defineProps({
    breadcrumbs: []
});

</script>

<template>
    <div
        class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <!-- Header -->
        <header
            class="sticky top-0 w-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg shadow-sm z-50 transition-colors">
            <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-4">
                <!-- Logo -->
                <a href="/" class="text-2xl font-bold text-primary dark:text-primary-light tracking-wide">
                    متجري
                </a>

                <!-- Search -->
                <div class="flex-1 mx-6 hidden md:block">
                    <input v-model="search" @keyup.enter="applySearch" type="text" placeholder="ابحث عن منتج..."
                        class="w-full rounded-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:outline-none transition-colors" />
                </div>

                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="toggleDarkMode"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <component :is="darkMode ? Moon : Sun" class="w-6 h-6" />
                    </button>

                    <!-- Cart -->
                    <button @click="cart.toggleCart"
                        class="relative flex items-center justify-center p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                        <ShoppingCart class="w-6 h-6" />
                        <span v-if="cart.count > 0"
                            class="absolute -top-2 -left-2 bg-primary text-white text-xs rounded-full px-2">
                            {{ cart.count }}
                        </span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1">
            <main class="max-w-6xl mx-auto px-4 pb-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div v-if="props.breadcrumbs && props.breadcrumbs.length > 0" class="flex items-center gap-2 mt-12 ">
                    <template v-if="props.breadcrumbs && props.breadcrumbs.length > 0">
                        <Breadcrumbs :breadcrumbs="props.breadcrumbs" />
                    </template>
                </div>
            </main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t dark:border-gray-700 mt-12 transition-colors">
            <div class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-3 gap-6">
                <div>
                    <h4 class="font-bold text-lg mb-3">عن المتجر</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        متجر إلكتروني عربي لعرض منتجات عصرية بأفضل الأسعار.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-3">روابط سريعة</h4>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li>
                            <a href="/" class="hover:text-primary">الصفحة الرئيسية</a>
                        </li>
                        <li>
                            <a href="/about-us" class="hover:text-primary">من نحن</a>
                        </li>
                        <li>
                            <a href="/contact-us" class="hover:text-primary">اتصل بنا</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-3">تابعنا</h4>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-primary"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="hover:text-primary"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="hover:text-primary"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center py-4 text-gray-500 dark:text-gray-400 text-sm border-t dark:border-gray-700">
                © 2025 جميع الحقوق محفوظة - متجري
            </div>
        </footer>

        <!-- Cart Drawer -->
        <CartDrawer v-if="cart.isOpen" @close="cart.toggleCart" />
    </div>
</template>

<style>
:root {
    --primary: #3b82f6;
    --primary-light: #60a5fa;
}

.text-primary {
    color: var(--primary);
}

.text-primary-light {
    color: var(--primary-light);
}

.bg-primary {
    background-color: var(--primary);
}
</style>
