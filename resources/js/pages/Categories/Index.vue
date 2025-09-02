<script setup>
import { ref } from "vue";
import { Motion } from "motion-v";
import MainLayout from '@/layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array
});

const breadcrumbs = [
    {
        title: 'الرئيسية',
        href: '/'
    },
    {
        title: 'الفئات',
        href: ``
    }
];
</script>

<template>
    <MainLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-gray-50 text-gray-900">

            <!-- Hero -->
            <section
                class="relative overflow-hidden bg-gradient-to-br from-primary/30 via-white to-primary/10 py-20 text-center">
                <Motion :initial="{ opacity: 0, y: 30 }" :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 0.8 }">
                    <h1
                        class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-primary to-blue-600">
                        تصفح الفئات
                    </h1>
                </Motion>
                <p class="text-lg text-gray-600">
                    اختر الفئة التي تهمك واكتشف منتجاتنا المميزة
                </p>
            </section>

            <!-- Categories Grid -->
            <main class="max-w-7xl mx-auto px-4 py-12">
                <Motion :initial="{ opacity: 0 }" :animate="{ opacity: 1 }" :transition="{ staggerChildren: 0.1 }"
                    class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <Motion v-for="cat in categories" :key="cat.id" :initial="{ opacity: 0, y: 20 }"
                        :animate="{ opacity: 1, y: 0 }" :whileHover="{ scale: 1.03 }"
                        class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden group relative">
                        <div class="overflow-hidden rounded-t-2xl">
                            <Link :href="`/categories/${cat.slug}`">
                            <img :src="cat.products[0]?.image ?? '/images/category-placeholder.jpg'" :alt="cat.name"
                                class="w-full h-48 object-cover group-hover:scale-105 transition duration-300" />
                            </Link>
                        </div>
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-semibold mb-2 truncate">{{ cat.name }}</h3>
                            <Link :href="`/categories/${cat.slug}`"
                                class="inline-block mt-2 px-4 py-2 bg-primary text-white rounded-xl hover:bg-primary/90 transition-shadow shadow-sm">
                            تصفح المنتجات
                            </Link>
                        </div>
                    </Motion>
                </Motion>
            </main>

        </div>
    </MainLayout>
</template>

<style>
:root {
    --primary: #3b82f6;
    --primary-hover: #2563eb;
}

.bg-primary {
    background-color: var(--primary);
}

.bg-primary:hover {
    background-color: var(--primary-hover);
}

.text-primary {
    color: var(--primary);
}
</style>
