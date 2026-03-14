import { computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

export const applyThemePreference = (themePreference) => {
    const isSystem = themePreference === 'system';
    const darkMediaQuery =
        typeof window.matchMedia === 'function'
            ? window.matchMedia('(prefers-color-scheme: dark)')
            : { matches: true };
    const resolvedTheme = isSystem ? (darkMediaQuery.matches ? 'dark' : 'light') : themePreference;

    document.documentElement.dataset.themePreference = themePreference;
    document.documentElement.dataset.theme = resolvedTheme;
};

export const useUserPreferences = () => {
    const page = usePage();

    const preferences = computed(() => page.props.preferences ?? {});
    const locale = computed(() => preferences.value.locale ?? 'pl');
    const theme = computed(() => preferences.value.theme ?? 'dark');

    const updatePreferences = ({ nextLocale = locale.value, nextTheme = theme.value }) => {
        router.put(
            route('preferences.update'),
            {
                locale: nextLocale,
                theme: nextTheme,
            },
            {
                preserveScroll: true,
                preserveState: false,
                onSuccess: () => {
                    applyThemePreference(nextTheme);
                },
            }
        );
    };

    return {
        locale,
        theme,
        updatePreferences,
        applyThemePreference,
    };
};
