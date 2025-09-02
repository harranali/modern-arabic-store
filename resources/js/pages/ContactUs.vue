<script setup>
import { ref } from "vue";
import { motion } from "motion-v";
import MainLayout from '@/layouts/MainLayout.vue';
import { useToast } from "vue-toastification";
import { Button } from '@/components/ui/button';

const toast = useToast();

const name = ref('');
const email = ref('');
const message = ref('');
const submitting = ref(false);

function validateEmail(email) {
    const re = /\S+@\S+\.\S+/;
    return re.test(email);
}

async function submitForm() {
    if (!name.value || !email.value || !message.value) {
        toast.error('❌ الرجاء ملء جميع الحقول');
        return;
    }

    if (!validateEmail(email.value)) {
        toast.error('❌ البريد الإلكتروني غير صالح');
        return;
    }

    submitting.value = true;

    try {
        await new Promise(resolve => setTimeout(resolve, 1000));
        toast.success('✅ تم إرسال رسالتك بنجاح');
        name.value = '';
        email.value = '';
        message.value = '';
    } catch (e) {
        toast.error('❌ حدث خطأ أثناء إرسال الرسالة');
    } finally {
        submitting.value = false;
    }
}
</script>

<template>
    <MainLayout>
        <div dir="rtl" class="min-h-screen bg-gray-50 text-gray-900">

            <!-- Hero -->
            <section class="bg-gradient-to-r from-primary/20 via-white to-primary/10 py-16 text-center">
                <motion.div :initial="{ opacity: 0, y: 20 }" :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 0.8 }" class="space-y-4 max-w-3xl mx-auto">
                    <h1
                        class="text-4xl md:text-5xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-primary to-blue-600">
                        اتصل بنا
                    </h1>
                    <p class="text-lg text-gray-600">
                        نحن هنا للإجابة على جميع استفساراتك. املأ النموذج وسنتواصل معك في أقرب وقت.
                    </p>
                </motion.div>
            </section>

            <!-- Contact Form -->
            <section class="max-w-3xl mx-auto px-6 py-12">
                <motion.form :initial="{ opacity: 0, y: 20 }" :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 0.8 }" @submit.prevent="submitForm"
                    class="bg-white p-8 rounded-2xl shadow-md space-y-6">
                    <div class="flex flex-col">
                        <label class="mb-2 font-semibold">الاسم</label>
                        <input type="text" v-model="name" placeholder="أدخل اسمك"
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary" />
                    </div>

                    <div class="flex flex-col">
                        <label class="mb-2 font-semibold">البريد الإلكتروني</label>
                        <input type="email" v-model="email" placeholder="example@mail.com"
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary" />
                    </div>

                    <div class="flex flex-col">
                        <label class="mb-2 font-semibold">الرسالة</label>
                        <textarea v-model="message" placeholder="اكتب رسالتك هنا..." rows="5"
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
                    </div>

                    <Button type="submit"
                        class="w-full py-3 bg-primary text-white rounded-xl hover:bg-primary/90 disabled:opacity-60"
                        :disabled="submitting">
                        <template v-if="submitting">جاري الإرسال...</template>
                        <template v-else>إرسال الرسالة</template>
                    </Button>
                </motion.form>
            </section>

            <!-- Contact Info -->
            <section class="max-w-3xl mx-auto px-6 py-12 text-center space-y-4">
                <h2 class="text-2xl font-bold text-primary">معلومات التواصل</h2>
                <p>البريد الإلكتروني: info@example.com</p>
                <p>رقم الهاتف: 123456789</p>
                <p>العنوان: المملكة العربية السعودية</p>
            </section>

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
</style>
