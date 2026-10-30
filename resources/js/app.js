import './bootstrap';
import '../css/learning.css';
import '../css/account.css';
import '../css/account-security.css';
import '../css/course-v4.css';
import '../css/home-v3.css';
import '../css/typography.css';
import '../css/responsive.css';
import '../css/auth.css';
import '../css/learning-panel.css';
import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import UiIcon from './Components/UiIcon.vue';
import BrandMark from './Components/BrandMark.vue';

const pages = import.meta.glob('./Pages/**/*.vue');

createInertiaApp({
    resolve: (name) => {
        const page = pages[`./Pages/${name}.vue`];
        if (!page) {
            throw new Error(`Unable to resolve Inertia page: ${name}`);
        }

        return page();
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) }).use(plugin).component('UiIcon', UiIcon).component('BrandMark', BrandMark).mount(el);
    },
});
import '../css/academy-colors.css';
