import { computed, reactive } from 'vue';
import { usePage } from '@inertiajs/vue3';

const state = reactive({
    items: [],
});

let nextId = 1;

const normalizeNotification = (notification) => {
    if (!notification?.message) {
        return null;
    }

    return {
        id: nextId++,
        type: notification.type ?? 'info',
        title: notification.title ?? null,
        message: notification.message,
        duration: notification.duration ?? 4500,
    };
};

export const pushFlashMessage = (notification) => {
    const item = normalizeNotification(notification);

    if (item === null) {
        return null;
    }

    state.items.push(item);

    if (item.duration > 0) {
        window.setTimeout(() => {
            removeFlashMessage(item.id);
        }, item.duration);
    }

    return item.id;
};

export const removeFlashMessage = (id) => {
    const index = state.items.findIndex((item) => item.id === id);

    if (index >= 0) {
        state.items.splice(index, 1);
    }
};

export const useFlashMessages = () => {
    const page = usePage();

    const backendNotification = computed(() => page.props.flash?.notification ?? null);
    const bannerNotification = computed(() => {
        const message = page.props.jetstream?.flash?.banner ?? '';

        if (!message) {
            return null;
        }

        return {
            type: page.props.jetstream?.flash?.bannerStyle === 'danger' ? 'error' : 'success',
            message,
        };
    });

    return {
        items: computed(() => state.items),
        backendNotification,
        bannerNotification,
        pushFlashMessage,
        removeFlashMessage,
    };
};
