<template>
    <div class="card p-4 rounded-lg shadow-sm">
        <img :src="product.image" alt="" class="w-full h-40 object-cover rounded" />
        <h3 class="mt-2 text-lg font-semibold">{{ product.name }}</h3>
        <p class="mt-1 text-sm">{{ product.price }} ر.س</p>
        <button @click="addToCart" class="mt-3 px-3 py-1 rounded bg-blue-600 text-white">أضف للسلة</button>
    </div>
</template>

<script setup>
import { useToast } from '@/composables/useToast' // اختياري
import axios from 'axios'
const props = defineProps({ product: Object })
const toast = useToast()

async function addToCart() {
    const res = await axios.post('/cart/add', { product_id: props.product.id })
    toast.success(res.data.message || 'أضيف')
    // بعث حدث مركزي أو تحديث store
    window.dispatchEvent(new CustomEvent('cart-updated', { detail: res.data }))
}
</script>