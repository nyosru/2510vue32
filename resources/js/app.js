import '../css/app.css'
import './bootstrap'

import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createApp, h } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

// ✅ импортируем Pinia
import { createPinia } from 'pinia'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        // ✅ создаём экземпляр pinia
        const pinia = createPinia()

        // ✅ подключаем pinia и inertia plugin
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia) // <--- вот это добавляем
            .use(ZiggyVue)

        app.mount(el)
    },
    progress: {
        color: '#4B5563',
    },
})
