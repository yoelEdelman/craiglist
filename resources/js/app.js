require('./bootstrap');

import Vue from 'vue';
import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faChevronLeft, faChevronRight,faAngleDoubleRight, faAngleDoubleLeft, faPrint, faEnvelope, faUser, faShareAlt, faStar, faTimes, faExclamationTriangle, faPencilAlt } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
library.add(faChevronLeft,faChevronRight,faAngleDoubleRight,faAngleDoubleLeft,faPrint, faEnvelope, faUser,faShareAlt, faStar, faTimes, faExclamationTriangle, faPencilAlt)
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.mixin({ methods: { route } });
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(Vuesax)
const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
