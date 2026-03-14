<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useTranslations } from '@/Composables/useTranslations';

defineProps({
    canViewDebtors: {
        type: Boolean,
        required: true,
    },
});

const { t } = useTranslations();
</script>

<template>
    <Head :title="t('debtors.title')" />

    <AppLayout :title="t('debtors.title')" active-module="debtors" :module-navigation="[]" />
</template>
