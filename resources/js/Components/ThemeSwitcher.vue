<script setup>
import { computed } from 'vue';
import { IconDeviceDesktop, IconMoonStars, IconSunHigh } from '@tabler/icons-vue';
import { useTranslations } from '@/Composables/useTranslations';
import { useUserPreferences } from '@/Composables/useUserPreferences';

const { t } = useTranslations();
const { locale, theme, updatePreferences } = useUserPreferences();

const options = computed(() => [
    { value: 'dark', label: t('theme.dark'), icon: IconMoonStars },
    { value: 'light', label: t('theme.light'), icon: IconSunHigh },
    { value: 'system', label: t('theme.system'), icon: IconDeviceDesktop },
]);
</script>

<template>
    <div
        class="inline-flex h-11 rounded-2xl border border-[color:var(--ui-border)] bg-[color:var(--ui-surface-muted)] p-1"
    >
        <button
            v-for="option in options"
            :key="option.value"
            type="button"
            class="group relative inline-flex h-full items-center justify-center rounded-xl px-3 text-sm font-medium transition"
            :class="
                option.value === theme
                    ? 'bg-[color:var(--ui-accent)] text-[color:var(--ui-accent-contrast)] shadow'
                    : 'text-[color:var(--ui-text-soft)] hover:text-[color:var(--ui-text)]'
            "
            @click="updatePreferences({ nextLocale: locale, nextTheme: option.value })"
        >
            <component :is="option.icon" class="h-4 w-4" />

            <span
                class="pointer-events-none absolute left-1/2 top-full z-20 mt-2 -translate-x-1/2 whitespace-nowrap rounded-lg border border-[color:var(--ui-border-strong)] bg-[color:var(--ui-surface)] px-2 py-1 text-xs text-[color:var(--ui-text)] opacity-0 shadow-xl transition duration-150 ease-out group-hover:opacity-100"
            >
                {{ option.label }}
            </span>
        </button>
    </div>
</template>
