import { beforeEach, describe, expect, it, vi } from 'vitest';
import { reactive } from 'vue';

const page = reactive({
    props: {
        flash: {
            notification: null,
        },
        jetstream: {
            flash: {
                banner: '',
                bannerStyle: 'success',
            },
        },
    },
});

vi.mock('@inertiajs/vue3', () => ({
    usePage: () => page,
}));

import { pushFlashMessage, removeFlashMessage, useFlashMessages } from './useFlashMessages';

describe('useFlashMessages', () => {
    beforeEach(() => {
        page.props.flash.notification = null;
        page.props.jetstream.flash.banner = '';
        page.props.jetstream.flash.bannerStyle = 'success';

        const { items } = useFlashMessages();
        [...items.value].forEach((item) => removeFlashMessage(item.id));
        vi.useRealTimers();
    });

    it('maps backend and jetstream banner notifications from page props', () => {
        page.props.flash.notification = {
            type: 'success',
            message: 'Saved',
        };
        page.props.jetstream.flash.banner = 'Updated';
        page.props.jetstream.flash.bannerStyle = 'danger';

        const { backendNotification, bannerNotification } = useFlashMessages();

        expect(backendNotification.value).toEqual({
            type: 'success',
            message: 'Saved',
        });
        expect(bannerNotification.value).toEqual({
            type: 'error',
            message: 'Updated',
        });
    });

    it('pushes notifications and removes timed ones automatically', () => {
        vi.useFakeTimers();

        const { items } = useFlashMessages();
        const firstId = pushFlashMessage({
            type: 'info',
            message: 'Hello',
            duration: 1000,
        });

        expect(firstId).not.toBeNull();
        expect(items.value).toHaveLength(1);
        expect(items.value[0]).toMatchObject({
            type: 'info',
            message: 'Hello',
        });

        vi.advanceTimersByTime(1000);

        expect(items.value).toHaveLength(0);
    });

    it('ignores empty notifications', () => {
        const { items } = useFlashMessages();

        expect(pushFlashMessage({})).toBeNull();
        expect(items.value).toHaveLength(0);
    });
});
