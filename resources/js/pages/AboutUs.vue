<script setup>
import MainLayout from '@/layouts/MainLayout.vue'
import { motion } from "motion-v"

</script>

<template>
    <MainLayout>
        <div class="bg-gray-50 min-h-screen text-gray-900">
            <!-- Hero -->
            <section class="relative overflow-hidden bg-gradient-to-br from-primary/20 via-white to-primary/10">
                <div class="absolute inset-0 -z-10">
                    <div class="absolute -top-32 -left-32 w-96 h-96 bg-primary/20 rounded-full blur-3xl animate-pulse">
                    </div>
                    <div
                        class="absolute bottom-0 right-0 w-80 h-80 bg-blue-300/30 rounded-full blur-2xl animate-bounce">
                    </div>
                </div>

                <div class="max-w-5xl mx-auto px-6 lg:px-12 py-20 text-center md:text-right space-y-8">
                    <motion.div :initial="{ opacity: 0, y: 40 }" :animate="{ opacity: 1, y: 0 }"
                        :transition="{ duration: 1 }">
                        <h1
                            class="text-4xl md:text-5xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-primary to-blue-600">
                            من نحن
                        </h1>
                        <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto md:mx-0">
                            نحن متجر إلكتروني حديث هدفنا تقديم أفضل المنتجات بأعلى جودة وبأسعار مناسبة للجميع.
                            نؤمن أن التسوق يجب أن يكون تجربة ممتعة، سهلة، وملهمة ✨.
                        </p>
                    </motion.div>
                </div>
            </section>

            <section class="max-w-6xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-10 items-center">
                <motion.div :initial="{ opacity: 0, x: -50 }" :animate="{ opacity: 1, x: 0 }"
                    :transition="{ duration: 0.8 }" class="space-y-6">
                    <h2 class="text-2xl font-bold text-primary">رسالتنا</h2>
                    <p class="text-gray-700 leading-relaxed">
                        أن نجعل عملية التسوق الإلكتروني أكثر سهولة وأمانًا، مع تقديم تجربة مستخدم عصرية
                        تعتمد على أحدث التقنيات.
                    </p>

                    <h2 class="text-2xl font-bold text-primary">رؤيتنا</h2>
                    <p class="text-gray-700 leading-relaxed">
                        أن نصبح الوجهة الأولى للتسوق الإلكتروني في العالم العربي،
                        حيث يلتقي الابتكار مع رضا العملاء.
                    </p>
                </motion.div>

                <motion.div :initial="{ opacity: 0, x: 50 }" :animate="{ opacity: 1, x: 0 }"
                    :transition="{ duration: 0.8 }">
                    <img src="/images/team.jpg" alt="فريق العمل"
                        class="rounded-2xl shadow-xl w-full object-cover h-80" />
                </motion.div>
            </section>

            <section class="bg-white py-16">
                <div class="max-w-6xl mx-auto px-6 text-center space-y-12">
                    <h2 class="text-3xl font-extrabold text-primary">قيمنا الأساسية</h2>
                    <div class="grid md:grid-cols-3 gap-8">
                        <motion.div v-for="(val, idx) in [
                            { title: 'الجودة', text: 'منتجات عالية الجودة نختارها بعناية.' },
                            { title: 'الثقة', text: 'نلتزم بالشفافية والموثوقية مع عملائنا.' },
                            { title: 'الابتكار', text: 'نستخدم أحدث الأدوات لتجربة أفضل.' },
                        ]" :key="idx" :initial="{ opacity: 0, y: 20 }" :animate="{ opacity: 1, y: 0 }"
                            :transition="{ delay: idx * 0.2 }"
                            class="bg-gray-50 rounded-2xl shadow-md p-6 hover:shadow-xl transition">
                            <h3 class="text-xl font-semibold text-primary mb-3">{{ val.title }}</h3>
                            <p class="text-gray-600">{{ val.text }}</p>
                        </motion.div>
                    </div>
                </div>
            </section>
        </div>
    </MainLayout>
</template>

<style>
:root {
    --primary: #3b82f6;
    --primary-hover: #2563eb;
}
</style>
