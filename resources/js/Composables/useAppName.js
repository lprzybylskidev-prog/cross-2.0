import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const FALLBACK_APP_NAME = 'Laravel';

export const resolveAppName = () => {
    const documentTitle =
        typeof document !== 'undefined'
            ? document.querySelector('title')?.textContent?.trim()
            : null;

    if (documentTitle) {
        return documentTitle;
    }

    return import.meta.env.VITE_APP_NAME || FALLBACK_APP_NAME;
};

export const formatDocumentTitle = (pageTitle, appName = resolveAppName()) => {
    const normalizedAppName = appName?.trim() || FALLBACK_APP_NAME;
    const normalizedPageTitle = pageTitle?.trim();

    return normalizedPageTitle
        ? `${normalizedAppName} - ${normalizedPageTitle}`
        : normalizedAppName;
};

export const useAppName = () => {
    const page = usePage();

    return computed(() => page.props.app?.name ?? resolveAppName());
};
