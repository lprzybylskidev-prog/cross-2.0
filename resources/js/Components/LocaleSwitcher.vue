<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { IconChevronDown } from '@tabler/icons-vue';
import { useTranslations } from '@/Composables/useTranslations';
import { useUserPreferences } from '@/Composables/useUserPreferences';

const { t } = useTranslations();
const { locale, theme, updatePreferences } = useUserPreferences();
const isOpen = ref(false);
const containerRef = ref(null);

const localeOptions = computed(() => [
    {
        code: 'pl',
        flag: 'fi fi-pl',
        label: t('language.polish'),
    },
    {
        code: 'en',
        flag: 'fi fi-gb',
        label: t('language.english'),
    },
]);

const currentOption = computed(
    () =>
        localeOptions.value.find((option) => option.code === locale.value) ?? localeOptions.value[0]
);

const changeLocale = (nextLocale) => {
    isOpen.value = false;

    updatePreferences({
        nextLocale,
        nextTheme: theme.value,
    });
};

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const closeDropdown = () => {
    isOpen.value = false;
};

const handleDocumentClick = (event) => {
    if (!(event.target instanceof HTMLElement)) {
        return;
    }

    if (!containerRef.value?.contains(event.target)) {
        closeDropdown();
    }
};

onMounted(() => {
    document.addEventListener('click', handleDocumentClick);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleDocumentClick);
});
</script>

<template>
    <div ref="containerRef" class="group relative">
        <button
            type="button"
            class="inline-flex h-11 items-center gap-2 rounded-2xl border border-[color:var(--ui-border)] bg-[color:var(--ui-surface-muted)] px-3 text-sm font-medium text-[color:var(--ui-text)] transition hover:border-[color:var(--ui-border-strong)] hover:bg-[color:var(--ui-surface)]"
            @click.stop="toggleDropdown"
        >
            <span :class="currentOption.flag" class="rounded-sm" />
            <IconChevronDown class="h-4 w-4 text-[color:var(--ui-text-muted)]" />
        </button>

        <div
            v-if="!isOpen"
            class="pointer-events-none absolute left-1/2 top-full z-20 mt-2 -translate-x-1/2 whitespace-nowrap rounded-lg border border-[color:var(--ui-border-strong)] bg-[color:var(--ui-surface)] px-2 py-1 text-xs text-[color:var(--ui-text)] opacity-0 shadow-xl transition duration-150 ease-out group-focus-within:opacity-100 group-hover:opacity-100"
        >
            {{ $t('language.application') }}
        </div>

        <Transition name="shell-dropdown">
            <div
                v-if="isOpen"
                class="absolute right-0 top-full z-30 mt-2 min-w-44 rounded-2xl border border-[color:var(--ui-border-strong)] bg-[color:var(--ui-surface)] p-2 shadow-xl"
            >
                <button
                    v-for="option in localeOptions"
                    :key="option.code"
                    type="button"
                    class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-left text-sm transition hover:bg-[color:var(--ui-surface-muted)]"
                    :class="
                        option.code === locale
                            ? 'text-[color:var(--ui-accent-strong)]'
                            : 'text-[color:var(--ui-text-soft)]'
                    "
                    @click="changeLocale(option.code)"
                >
                    <span :class="option.flag" class="rounded-sm" />
                    <span>{{ option.label }}</span>
                </button>
            </div>
        </Transition>
    </div>
</template>
