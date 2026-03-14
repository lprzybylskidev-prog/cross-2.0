<script setup>
import { Head } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { useTranslations } from '@/Composables/useTranslations';

defineProps({
    terms: String,
});

const { t } = useTranslations();
</script>

<template>
    <Head :title="t('legal.terms.title')" />

    <AuthLayout :title="t('legal.terms.title')" :description="t('legal.terms.description')">
        <div
            class="prose prose-invert max-w-none rounded-[1.75rem] border border-[color:var(--ui-border)] bg-[color:var(--ui-panel)] p-6 text-[color:var(--ui-text-soft)]"
            v-html="terms"
        />
    </AuthLayout>
</template>
