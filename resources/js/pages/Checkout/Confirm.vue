<script setup>
import { CheckCircle } from 'lucide-vue-next';

const page = usePage();

// Optional: Get order info from server
const order = page.props.order || {
    id: '12345',
    total: 299.99,
    items: [
        { name: 'منتج 1', quantity: 1, price: 99.99 },
        { name: 'منتج 2', quantity: 2, price: 100 },
    ],
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 p-6">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-8 text-center">
            <CheckCircle class="w-16 h-16 text-green-500 mx-auto mb-4" />
            <h1 class="text-2xl font-bold mb-2">تمت العملية بنجاح!</h1>
            <p class="text-gray-600 mb-6">شكرًا لك على طلبك. تم تأكيد طلبك برقم:</p>
            <p class="text-lg font-semibold mb-4">#{{ order.id }}</p>

            <!-- Order summary -->
            <div class="bg-gray-100 p-4 rounded-xl mb-6">
                <h2 class="font-semibold mb-2">ملخص الطلب</h2>
                <ul class="flex flex-col gap-2 text-gray-700">
                    <li v-for="item in order.items" :key="item.name" class="flex justify-between">
                        <span>{{ item.name }} × {{ item.quantity }}</span>
                        <span>{{ item.price.toFixed(2) }} ر.س</span>
                    </li>
                </ul>
                <div class="border-t mt-2 pt-2 flex justify-between font-semibold text-gray-900">
                    <span>الإجمالي</span>
                    <span>{{ order.total.toFixed(2) }} ر.س</span>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <a href="/" class="w-full py-3 bg-primary text-white rounded-xl hover:bg-primary/90 transition">العودة
                    للرئيسية</a>
                <a href="/orders/{{ order.id }}" class="w-full py-3 border rounded-xl hover:bg-gray-100 transition">عرض
                    تفاصيل الطلب</a>
            </div>
        </div>
    </div>
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
</style>
