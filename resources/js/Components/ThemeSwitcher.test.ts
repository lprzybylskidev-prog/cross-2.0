import { beforeEach, describe, expect, it, vi } from 'vitest';
import { ref } from 'vue';
import { mount } from '@vue/test-utils';

const updatePreferencesMock = vi.fn();

vi.mock('@/Composables/useTranslations', () => ({
    useTranslations: () => ({
        t: (key: string) =>
            ({
                'theme.dark': 'Dark',
                'theme.light': 'Light',
                'theme.system': 'System',
            })[key] ?? key,
    }),
}));

vi.mock('@/Composables/useUserPreferences', () => ({
    useUserPreferences: () => ({
        locale: ref('pl'),
        theme: ref('dark'),
        updatePreferences: updatePreferencesMock,
    }),
}));

import ThemeSwitcher from './ThemeSwitcher.vue';

describe('ThemeSwitcher', () => {
    beforeEach(() => {
        updatePreferencesMock.mockReset();
    });

    it('updates preferences with the selected theme', async () => {
        const wrapper = mount(ThemeSwitcher);
        const buttons = wrapper.findAll('button');

        await buttons[1].trigger('click');

        expect(updatePreferencesMock).toHaveBeenCalledWith({
            nextLocale: 'pl',
            nextTheme: 'light',
        });
    });
});
