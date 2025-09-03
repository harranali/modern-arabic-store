<script setup>
import { ref, computed } from "vue";
import { motion } from "motion-v";
import { Loader2, Trash2 } from "lucide-vue-next";
import { useCartStore } from "@/Stores/cart";
import MainLayout from "@/layouts/MainLayout.vue";
import { useToast } from "vue-toastification";
import { Button } from '@/components/ui/button';

const toast = useToast();
const cart = useCartStore();
const removingIds = ref([]);
const processing = ref(false);
const promoCode = ref("");
const selectedMethod = ref("credit");

// Fetch cart
cart.fetchCart();

// Total computed
const total = computed(() => cart.items.reduce((sum, item) => sum + item.price * item.quantity, 0));

// Quantity handlers
const increaseQuantity = (item) => cart.update(item.id, item.quantity + 1);
const decreaseQuantity = (item) => { if (item.quantity > 1) cart.update(item.id, item.quantity - 1); };

// Remove item
const removeItem = async (id) => {
    if (removingIds.value.includes(id)) return;
    removingIds.value.push(id);
    try {
        await cart.remove(id);
        toast.success('تمت إزالة العنصر من السلة');
    } finally {
        removingIds.value = removingIds.value.filter(rid => rid !== id);
    }
};

// Apply promo
const applyPromo = () => {
    if (!promoCode.value) return toast.error("ادخل رمز الخصم");
    toast.success(`تم تطبيق رمز الخصم: ${promoCode.value}`);
};

// Checkout
const checkout = async () => {
    if (cart.items.length === 0) return;
    processing.value = true;
    setTimeout(() => {
        toast.success(`تم الدفع بنجاح عبر ${paymentLabel.value}!`);
        cart.clear();
        processing.value = false;
    }, 1500);
};

// Payment label
const paymentLabel = computed(() => {
    switch (selectedMethod.value) {
        case "apple": return "Apple Pay";
        case "google": return "Google Pay";
        case "paypal": return "PayPal";
        default: return "بطاقة ائتمان";
    }
});

// Brand colors
const brandColors = {
    credit: "border-gray-300",
    apple: "border-black bg-black/10",
    google: "border-[#4285F4] bg-[#4285F4]/10",
    paypal: "border-[#003087] bg-[#003087]/10 text-white"
};
</script>

<template>
    <MainLayout>
        <div class="min-h-screen bg-gray-50 text-gray-900 py-12 px-4">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left: Cart Items & Shipping -->
                <div class="lg:col-span-2 flex flex-col gap-6">

                    <!-- Cart Items -->
                    <motion.div v-for="item in cart.items" :key="item.id" initial="{ opacity: 0, y: 20 }"
                        animate="{ opacity: 1, y: 0 }"
                        class="flex items-center gap-4 bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition">

                        <img :src="`/images/${item.image}`" class="w-24 h-24 object-cover rounded-lg" />

                        <div class="flex-1">
                            <div class="font-semibold">{{ item.name }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <Button variant="outline" @click="decreaseQuantity(item)" class="px-2 py-1">−</Button>
                                <span>{{ item.quantity }}</span>
                                <Button variant="outline" @click="increaseQuantity(item)" class="px-2 py-1">+</Button>
                            </div>
                            <div class="text-primary font-medium mt-1">{{ (item.price * item.quantity).toFixed(2) }} ر.س
                            </div>
                        </div>

                        <button @click="removeItem(item.id)" :disabled="removingIds.includes(item.id)"
                            class="text-red-500">
                            <Loader2 v-if="removingIds.includes(item.id)" class="w-5 h-5 animate-spin" />
                            <Trash2 v-else class="w-5 h-5" />
                        </button>
                    </motion.div>

                    <div v-if="cart.items.length === 0" class="text-center text-gray-500 py-12">السلة فارغة</div>

                    <!-- Promo code -->
                    <div class="bg-white p-4 rounded-xl shadow-sm flex gap-2">
                        <input v-model="promoCode" type="text" placeholder="رمز خصم"
                            class="flex-1 border px-3 py-2 rounded-lg" />
                        <Button @click="applyPromo">تطبيق</Button>
                    </div>

                    <!-- Shipping Info -->
                    <div class="bg-white p-6 rounded-xl shadow-sm flex flex-col gap-4">
                        <h2 class="text-lg font-semibold">معلومات الشحن</h2>
                        <input type="text" placeholder="الاسم الكامل" class="w-full border px-3 py-2 rounded-lg" />
                        <input type="text" placeholder="البريد الإلكتروني" class="w-full border px-3 py-2 rounded-lg" />
                        <input type="text" placeholder="العنوان" class="w-full border px-3 py-2 rounded-lg" />
                    </div>

                </div>

                <!-- Right: Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl p-6 shadow-lg sticky top-6 flex flex-col gap-6">
                        <h2 class="text-xl font-bold">ملخص الطلب</h2>

                        <!-- Items with thumbnails -->
                        <div class="flex flex-col gap-4 max-h-64 overflow-y-auto">
                            <div v-for="item in cart.items" :key="item.id"
                                class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <img :src="`/images/${item.image}`" alt="thumbnail"
                                        class="w-11 h-12 object-cover rounded-lg" />
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-gray-800">{{ item.name }}</span>
                                        <span class="text-gray-500 text-sm">× {{ item.quantity }}</span>
                                    </div>
                                </div>
                                <span class="font-semibold text-gray-900">{{ (item.price * item.quantity).toFixed(2) }}
                                    ر.س</span>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="border-t pt-3 flex justify-between font-semibold text-lg">
                            <span>الإجمالي</span>
                            <span>{{ total.toFixed(2) }} ر.س</span>
                        </div>

                        <!-- Payment Methods -->
                        <div class="flex flex-col gap-3 mt-4">
                            <label v-for="method in ['creditcard', 'apple', 'google', 'paypal']" :key="method"
                                class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer transition transform hover:scale-105 hover:shadow-md"
                                :class="[
                                    selectedMethod === method ? 'ring-2 ring-offset-2 ring-primary' : 'border-gray-300',
                                    brandColors[method]
                                ]">
                                <input type="radio" v-model="selectedMethod" :value="method" class="hidden" />

                                <div
                                    class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full flex-shrink-0">
                                    <img :src="`/images/${method}.png`" class="w-11  object-contain" />
                                </div>

                                <span class="font-semibold text-gray-800">
                                    {{ method === 'creditcard' ? 'بطاقة ائتمان' : method.charAt(0).toUpperCase() +
                                        method.slice(1) + ' Pay' }}
                                </span>
                            </label>



                            <!-- Pay Now button -->
                            <Button @click="checkout" :disabled="processing || cart.items.length === 0"
                                class="w-full flex items-center justify-center gap-2 bg-primary text-white py-3 rounded-xl hover:bg-primary/90 transition transform hover:scale-105">
                                <Loader2 v-if="processing" class="w-5 h-5 animate-spin" />
                                <span v-else>الدفع عبر {{ paymentLabel }}</span>
                            </Button>
                        </div>

                        <!-- Security Info -->
                        <div class="mt-4 text-sm text-gray-500 flex items-center gap-2">
                            <img :src="`/images/safety-icon.png`" class="w-11  object-contain" />
                            الدفع آمن ومضمون
                        </div>
                    </div>
                </div>

            </div>
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
