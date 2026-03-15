<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { IconMailCheck, IconShieldLock, IconUserPlus } from '@tabler/icons-vue';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import FlashNotifications from '@/Components/FlashNotifications.vue';
import LocaleSwitcher from '@/Components/LocaleSwitcher.vue';
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import { useAppName } from '@/Composables/useAppName';
import { useTranslations } from '@/Composables/useTranslations';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: '',
    },
});

const { t } = useTranslations();
const appName = useAppName();

const highlights = computed(() => [
    {
        icon: IconUserPlus,
        title: t('auth.layout.operations_title'),
        description: t('auth.layout.operations_description'),
    },
    {
        icon: IconMailCheck,
        title: t('auth.layout.security_title'),
        description: t('auth.layout.security_description'),
    },
    {
        icon: IconShieldLock,
        title: t('auth.layout.localization_title'),
        description: t('auth.layout.localization_description'),
    },
]);
</script>

<template>
    <Head :title="props.title" />

    <div class="relative min-h-screen overflow-hidden bg-[color:var(--ui-app-bg)]">
        <FlashNotifications />

        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(148,226,213,0.12),transparent_28%),radial-gradient(circle_at_bottom_right,rgba(243,139,168,0.12),transparent_24%)]"
        />

        <div
            class="relative mx-auto flex min-h-screen max-w-7xl flex-col px-4 py-6 sm:px-6 lg:px-8"
        >
            <header class="flex flex-wrap items-center justify-between gap-3 pb-6">
                <Link
                    :href="route().has('debtors.view') ? route('debtors.view') : '/debtors'"
                    class="bg-[color:var(--ui-surface)]/80 inline-flex items-center gap-3 rounded-2xl border border-[color:var(--ui-border)] px-4 py-3 text-[color:var(--ui-text)] shadow-lg shadow-black/5 backdrop-blur"
                >
                    <ApplicationMark class="h-10 w-10" />
                    <div>
                        <p class="text-sm font-semibold">{{ appName }}</p>
                        <p class="text-xs text-[color:var(--ui-text-muted)]">
                            {{ $t('auth.layout.subtitle') }}
                        </p>
                    </div>
                </Link>

                <div class="flex flex-wrap items-center gap-3">
                    <LocaleSwitcher />
                    <ThemeSwitcher />
                </div>
            </header>

            <main
                class="grid flex-1 gap-6 lg:grid-cols-[minmax(0,1.15fr)_minmax(22rem,30rem)] lg:items-center"
            >
                <section
                    class="bg-[color:var(--ui-surface)]/70 rounded-[2rem] border border-[color:var(--ui-border)] p-6 shadow-2xl shadow-black/10 backdrop-blur sm:p-8"
                >
                    <div class="max-w-2xl">
                        <p
                            class="text-sm font-semibold uppercase tracking-[0.24em] text-[color:var(--ui-accent-strong)]"
                        >
                            {{ $t('auth.layout.eyebrow') }}
                        </p>
                        <h1
                            class="mt-4 text-3xl font-semibold tracking-tight text-[color:var(--ui-text)] sm:text-5xl"
                        >
                            {{ $t('auth.layout.title') }}
                        </h1>
                        <p
                            class="mt-4 max-w-xl text-base leading-7 text-[color:var(--ui-text-soft)] sm:text-lg"
                        >
                            {{ $t('auth.layout.description') }}
                        </p>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <article
                            v-for="highlight in highlights"
                            :key="highlight.title"
                            class="rounded-2xl border border-[color:var(--ui-border)] bg-[color:var(--ui-panel)] p-4"
                        >
                            <component
                                :is="highlight.icon"
                                class="h-5 w-5 text-[color:var(--ui-accent-strong)]"
                            />
                            <h2 class="mt-4 text-sm font-semibold text-[color:var(--ui-text)]">
                                {{ highlight.title }}
                            </h2>
                            <p class="mt-2 text-sm leading-6 text-[color:var(--ui-text-soft)]">
                                {{ highlight.description }}
                            </p>
                        </article>
                    </div>
                </section>

                <section
                    class="rounded-[2rem] border border-[color:var(--ui-border-strong)] bg-[color:var(--ui-surface)] p-6 shadow-2xl shadow-black/10 sm:p-8"
                >
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold text-[color:var(--ui-text)]">
                            {{ props.title }}
                        </h2>
                        <p
                            v-if="props.description"
                            class="mt-2 text-sm leading-6 text-[color:var(--ui-text-soft)]"
                        >
                            {{ props.description }}
                        </p>
                    </div>

                    <slot />
                </section>
            </main>
        </div>
    </div>
</template>
