import 'vuetify/styles'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css'
import '../css/app.css';

// Vuetify
import {createVuetify} from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import VueMask from '@devindex/vue-mask';
import {createStore} from 'vuex'
import {conferences} from './store/conferences';
import {favorite} from './store/reports/favorite';
import {coordinates} from "@/store/map/mapCoordinates";
import {VueSocialSharing} from 'vue-social-sharing'
import CKEditor from '@ckeditor/ckeditor5-vue';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

const store = createStore({
    modules: {
        conferences,
        coordinates,
        favorite
    }
})

const vuetify = createVuetify({
    components,
    directives,
})

createInertiaApp({
    title: (title) => `${title} - QuesT `,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, app, props, plugin}) {
        return createApp({render: () => h(app, props)})
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(vuetify)
            .use(VueMask)
            .use(store)
            .use(VueSocialSharing)
            .use(CKEditor)
            .mount(el);
    },
});

InertiaProgress.init({color: '#4B5563'});

