import './bootstrap';
import '../css/app.css';
import 'flag-icons/css/flag-icons.min.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { translate } from '@/lib/translate';
import { formatDocumentTitle, resolveAppName } from '@/Composables/useAppName';
import { applyThemePreference } from '@/Composables/useUserPreferences';

const appName = resolveAppName();

createInertiaApp({
    title: (title) => formatDocumentTitle(title, appName),
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        applyThemePreference(props.initialPage.props.preferences?.theme ?? 'dark');

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mixin({
                methods: {
                    $t(key, replacements = {}) {
                        return translate(this.$page.props.translations ?? {}, key, replacements);
                    },
                },
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
