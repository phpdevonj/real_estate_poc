import './bootstrap'
import '../css/app.css';

import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import AdminLayout from './Layouts/AdminLayout.vue';

createInertiaApp({
  title: (title) => 'RealState ${title}',
  resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        let page = pages[`./Pages/${name}.vue`]
        page.default.layout = page.default.layout || AdminLayout;
        return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .component( 'Head' ,Head)
      .component( 'Link' ,Link)
      .mount(el)
  },
})