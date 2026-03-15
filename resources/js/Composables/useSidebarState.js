import { ref } from 'vue';

const SIDEBAR_STATE_COOKIE = 'cross_sidebar_collapsed';
const ONE_YEAR_IN_SECONDS = 60 * 60 * 24 * 365;

const readCookie = (name) => {
    if (typeof document === 'undefined') {
        return null;
    }

    const prefix = `${name}=`;
    const match = document.cookie
        .split(';')
        .map((chunk) => chunk.trim())
        .find((chunk) => chunk.startsWith(prefix));

    return match ? decodeURIComponent(match.slice(prefix.length)) : null;
};

export const readSidebarCollapsedPreference = () => readCookie(SIDEBAR_STATE_COOKIE) === '1';

export const persistSidebarCollapsedPreference = (collapsed) => {
    if (typeof document === 'undefined') {
        return;
    }

    document.cookie = [
        `${SIDEBAR_STATE_COOKIE}=${collapsed ? '1' : '0'}`,
        'path=/',
        `max-age=${ONE_YEAR_IN_SECONDS}`,
        'SameSite=Lax',
    ].join('; ');
};

export const useSidebarState = () => {
    const sidebarCollapsed = ref(readSidebarCollapsedPreference());

    const setSidebarCollapsed = (collapsed) => {
        sidebarCollapsed.value = collapsed;
        persistSidebarCollapsedPreference(collapsed);
    };

    const toggleSidebarCollapsed = () => {
        setSidebarCollapsed(!sidebarCollapsed.value);
    };

    return {
        sidebarCollapsed,
        setSidebarCollapsed,
        toggleSidebarCollapsed,
    };
};
