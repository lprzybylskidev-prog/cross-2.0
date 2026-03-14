<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useTranslations } from '@/Composables/useTranslations';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
const { t } = useTranslations();
</script>

<template>
    <Head :title="t('auth.verify_email.title')" />

    <AuthLayout
        :title="t('auth.verify_email.title')"
        :description="t('auth.verify_email.description')"
    >
        <div class="mb-4 text-sm text-[color:var(--ui-text-soft)]">
            {{ t('auth.verify_email.helper') }}
        </div>

        <div
            v-if="verificationLinkSent"
            class="mb-4 rounded-2xl border border-emerald-400/20 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-300"
        >
            {{ t('auth.verify_email.resent') }}
        </div>

        <form novalidate @submit.prevent="submit">
            <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ t('auth.verify_email.submit') }}
                </PrimaryButton>

                <div class="flex flex-wrap items-center gap-4 text-sm">
                    <Link
                        :href="route('profile.show')"
                        class="font-medium text-[color:var(--ui-accent-strong)] transition hover:text-[color:var(--ui-accent)]"
                    >
                        {{ t('auth.verify_email.edit_profile') }}</Link
                    >

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="font-medium text-[color:var(--ui-accent-strong)] transition hover:text-[color:var(--ui-accent)]"
                    >
                        {{ t('nav.logout') }}
                    </Link>
                </div>
            </div>
        </form>
    </AuthLayout>
</template>
