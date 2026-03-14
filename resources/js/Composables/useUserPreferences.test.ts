import { beforeEach, describe, expect, it, vi } from 'vitest';

const { putMock, page } = vi.hoisted(() => ({
    putMock: vi.fn(),
    page: {
        props: {
            preferences: {
                locale: 'pl',
                theme: 'dark',
            },
        },
    },
}));

vi.mock('@inertiajs/vue3', () => ({
    router: {
        put: putMock,
    },
    usePage: () => page,
}));

import { applyThemePreference, useUserPreferences } from './useUserPreferences';

describe('useUserPreferences', () => {
    beforeEach(() => {
        putMock.mockReset();
        page.props.preferences = {
            locale: 'pl',
            theme: 'dark',
        };

        document.documentElement.removeAttribute('data-theme');
        document.documentElement.removeAttribute('data-theme-preference');

        vi.stubGlobal(
            'route',
            vi.fn(() => '/preferences')
        );
    });

    it('reads locale and theme from shared page props', () => {
        const { locale, theme } = useUserPreferences();

        expect(locale.value).toBe('pl');
        expect(theme.value).toBe('dark');
    });

    it('updates preferences through inertia and applies theme on success', () => {
        const { updatePreferences } = useUserPreferences();

        updatePreferences({
            nextLocale: 'en',
            nextTheme: 'light',
        });

        expect(putMock).toHaveBeenCalledWith(
            '/preferences',
            {
                locale: 'en',
                theme: 'light',
            },
            expect.objectContaining({
                preserveScroll: true,
                preserveState: false,
                onSuccess: expect.any(Function),
            })
        );

        const options = putMock.mock.calls[0][2];
        options.onSuccess();

        expect(document.documentElement.dataset.themePreference).toBe('light');
        expect(document.documentElement.dataset.theme).toBe('light');
    });
});

describe('applyThemePreference', () => {
    beforeEach(() => {
        document.documentElement.removeAttribute('data-theme');
        document.documentElement.removeAttribute('data-theme-preference');
    });

    it('resolves system theme using browser preference', () => {
        Object.defineProperty(window, 'matchMedia', {
            writable: true,
            value: vi.fn(() => ({ matches: false })),
        });

        applyThemePreference('system');

        expect(document.documentElement.dataset.themePreference).toBe('system');
        expect(document.documentElement.dataset.theme).toBe('light');
    });
});
