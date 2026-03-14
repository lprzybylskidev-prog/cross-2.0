<script setup>
import { onMounted, watch } from 'vue';
import { IconAlertCircle, IconCircleCheck, IconInfoCircle, IconX } from '@tabler/icons-vue';
import { removeFlashMessage, useFlashMessages } from '@/Composables/useFlashMessages';
import { useTranslations } from '@/Composables/useTranslations';

const { items, backendNotification, bannerNotification, pushFlashMessage } = useFlashMessages();
const { t } = useTranslations();

const icons = {
    success: IconCircleCheck,
    error: IconAlertCircle,
    info: IconInfoCircle,
    warning: IconAlertCircle,
};

const syncNotification = (notification) => {
    if (notification?.message) {
        pushFlashMessage(notification);
    }
};

onMounted(() => {
    syncNotification(backendNotification.value);
    syncNotification(bannerNotification.value);
});

watch(backendNotification, syncNotification);
watch(bannerNotification, syncNotification);
</script>

<template>
    <div
        class="pointer-events-none fixed right-4 top-6 z-50 flex w-[min(24rem,calc(100vw-2rem))] flex-col gap-3 sm:top-8"
    >
        <transition-group name="toast">
            <article
                v-for="item in items"
                :key="item.id"
                class="bg-[color:var(--ui-surface)]/95 pointer-events-auto rounded-2xl border border-[color:var(--ui-border-strong)] p-4 shadow-2xl shadow-black/20 backdrop-blur"
            >
                <div class="flex items-start gap-3">
                    <component
                        :is="icons[item.type] ?? icons.info"
                        class="mt-0.5 h-5 w-5 shrink-0"
                        :class="{
                            'text-emerald-400': item.type === 'success',
                            'text-red-400': item.type === 'error',
                            'text-sky-400': item.type === 'info',
                            'text-amber-400': item.type === 'warning',
                        }"
                    />

                    <div class="min-w-0 flex-1">
                        <p
                            v-if="item.title"
                            class="text-sm font-semibold text-[color:var(--ui-text)]"
                        >
                            {{ item.title }}
                        </p>
                        <p class="text-sm text-[color:var(--ui-text-soft)]">
                            {{ item.message }}
                        </p>
                    </div>

                    <button
                        type="button"
                        class="rounded-xl p-1 text-[color:var(--ui-text-muted)] transition hover:bg-[color:var(--ui-surface-muted)] hover:text-[color:var(--ui-text)]"
                        :aria-label="t('common.dismiss')"
                        @click="removeFlashMessage(item.id)"
                    >
                        <IconX class="h-4 w-4" />
                    </button>
                </div>
            </article>
        </transition-group>
    </div>
</template>
