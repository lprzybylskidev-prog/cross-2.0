<script setup>
import { computed } from 'vue';
import ActionSection from '@/Components/ActionSection.vue';
import UserAvatar from '@/Components/UserAvatar.vue';
import { useTranslations } from '@/Composables/useTranslations';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const { t } = useTranslations();

const verificationToneClass = computed(() =>
    props.user.email_verified_at
        ? 'border-[color:var(--ui-status-success-border)] bg-[color:var(--ui-status-success-bg)] text-[color:var(--ui-status-success-text)]'
        : 'border-[color:var(--ui-status-warning-border)] bg-[color:var(--ui-status-warning-bg)] text-[color:var(--ui-status-warning-text)]'
);

const verificationLabel = computed(() =>
    props.user.email_verified_at
        ? t('profile.overview.email_verified')
        : t('profile.overview.email_unverified')
);
</script>

<template>
    <ActionSection>
        <template #title> {{ $t('profile.overview.title') }} </template>

        <template #description>
            {{ $t('profile.overview.description') }}
        </template>

        <template #content>
            <div class="space-y-6">
                <div
                    class="flex flex-col gap-5 rounded-3xl border border-[color:var(--ui-border)] bg-[color:var(--ui-surface-muted)] p-5 md:flex-row md:items-center md:justify-between"
                >
                    <div class="flex items-center gap-4">
                        <UserAvatar :user="user" size="lg" />

                        <div class="space-y-1">
                            <p
                                class="text-xs font-semibold uppercase tracking-[0.24em] text-[color:var(--ui-text-soft)]"
                            >
                                {{ $t('profile.overview.account_label') }}
                            </p>
                            <h3 class="text-2xl font-semibold text-[color:var(--ui-text)]">
                                {{ user.name }}
                            </h3>
                            <p class="text-sm text-[color:var(--ui-text-soft)]">
                                {{ user.email }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="inline-flex items-center rounded-full border px-3 py-1.5 text-sm font-medium"
                        :class="verificationToneClass"
                    >
                        {{ verificationLabel }}
                    </div>
                </div>

                <div class="grid gap-4 lg:grid-cols-2">
                    <div
                        class="rounded-3xl border border-[color:var(--ui-border)] bg-[color:var(--ui-surface-muted)] p-5"
                    >
                        <p
                            class="text-xs font-semibold uppercase tracking-[0.24em] text-[color:var(--ui-text-soft)]"
                        >
                            {{ $t('profile.overview.fields.name') }}
                        </p>
                        <p class="mt-3 text-base font-medium text-[color:var(--ui-text)]">
                            {{ user.name }}
                        </p>
                    </div>

                    <div
                        class="rounded-3xl border border-[color:var(--ui-border)] bg-[color:var(--ui-surface-muted)] p-5"
                    >
                        <p
                            class="text-xs font-semibold uppercase tracking-[0.24em] text-[color:var(--ui-text-soft)]"
                        >
                            {{ $t('profile.overview.fields.email') }}
                        </p>
                        <p class="mt-3 break-all text-base font-medium text-[color:var(--ui-text)]">
                            {{ user.email }}
                        </p>
                    </div>
                </div>
            </div>
        </template>
    </ActionSection>
</template>
