import { beforeEach, describe, expect, it } from 'vitest';
import { translate } from './lib/translate';
import { applyThemePreference } from './Composables/useUserPreferences';
import { getUserInitials } from './lib/profile';

describe('translate', () => {
    it('returns nested translation values', () => {
        expect(
            translate(
                {
                    auth: {
                        login: {
                            submit: 'Sign in',
                        },
                    },
                },
                'auth.login.submit'
            )
        ).toBe('Sign in');
    });

    it('applies replacements to translated strings', () => {
        expect(
            translate(
                {
                    debtors: {
                        filters: {
                            updated_at: 'Updated at :time',
                        },
                    },
                },
                'debtors.filters.updated_at',
                { time: '2 minutes ago' }
            )
        ).toBe('Updated at 2 minutes ago');
    });
});

describe('applyThemePreference', () => {
    beforeEach(() => {
        document.documentElement.removeAttribute('data-theme');
        document.documentElement.removeAttribute('data-theme-preference');
    });

    it('applies explicit theme preferences to the document', () => {
        applyThemePreference('light');

        expect(document.documentElement.dataset.themePreference).toBe('light');
        expect(document.documentElement.dataset.theme).toBe('light');
    });
});

describe('getUserInitials', () => {
    it('builds initials from the first two name segments', () => {
        expect(getUserInitials('Jan Kowalski Nowak')).toBe('JK');
    });

    it('returns a fallback for empty values', () => {
        expect(getUserInitials('')).toBe('?');
    });
});
