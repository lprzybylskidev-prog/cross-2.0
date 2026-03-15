import { beforeEach, describe, expect, it } from 'vitest';
import {
    persistSidebarCollapsedPreference,
    readSidebarCollapsedPreference,
    useSidebarState,
} from './useSidebarState';

describe('useSidebarState', () => {
    beforeEach(() => {
        document.cookie = 'cross_sidebar_collapsed=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
    });

    it('defaults to an expanded sidebar when no cookie is present', () => {
        const { sidebarCollapsed } = useSidebarState();

        expect(sidebarCollapsed.value).toBe(false);
        expect(readSidebarCollapsedPreference()).toBe(false);
    });

    it('persists the collapsed state in a cookie', () => {
        persistSidebarCollapsedPreference(true);

        expect(readSidebarCollapsedPreference()).toBe(true);
    });

    it('toggles the sidebar state and stores the new preference', () => {
        const { sidebarCollapsed, toggleSidebarCollapsed } = useSidebarState();

        toggleSidebarCollapsed();

        expect(sidebarCollapsed.value).toBe(true);
        expect(readSidebarCollapsedPreference()).toBe(true);
    });
});
