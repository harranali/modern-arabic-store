import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';
import { createPinia } from "pinia";
import { useCartStore } from "@/Stores/cart";
import Toast, { PluginOptions } from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const pinia = createPinia();

        const options: PluginOptions = {
            position: 'bottom-left',
            timeout: 3000,
            closeOnClick: true,
            pauseOnHover: true,
            draggable: true,
            showCloseButtonOnHover: false,
            hideProgressBar: false,
            rtl: false,
        };
        
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(Toast, options)
            .mount(el);

        // cart store instance
        const cart = useCartStore();
        cart.fetchCart();

        // the theme 
        const saved = localStorage.getItem("theme");
        if (
            saved === "dark" ||
            (!saved && window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            document.documentElement.classList.add("dark");
        }
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
