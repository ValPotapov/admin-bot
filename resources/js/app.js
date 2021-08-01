require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Multiselect from 'vue-multiselect'
import tooltip from "./tooltip.js";
import "../css/tooltip.css";

const el = document.getElementById('app');

let app = createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .use(VueSweetalert2)
    .use(Multiselect)
    .directive('tooltip',tooltip)
    .mount(el);

InertiaProgress.init({ color: '#4B5563' });
