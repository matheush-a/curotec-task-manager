import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { createPinia } from 'pinia'

const pages = {
  'Tasks/Index': () => import('./Pages/Tasks/Index.vue'),
}

createInertiaApp({
  resolve: name => {
    if (pages[name]) {
      return pages[name]()
    }
    return import(`./Pages/${name}.vue`)
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
    app.use(plugin)
    app.use(createPinia())
    app.mount(el)
  },
})
