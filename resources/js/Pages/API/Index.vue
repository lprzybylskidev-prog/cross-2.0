<script setup>
import ApiTokenManager from '@/Pages/API/Partials/ApiTokenManager.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useTranslations } from '@/Composables/useTranslations';

defineProps({
    tokens: Array,
    availablePermissions: Array,
    defaultPermissions: Array,
});

const { t } = useTranslations();
</script>

<template>
    <AppLayout :title="t('api.title')">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-[color:var(--ui-text)]">
                {{ t('api.title') }}
            </h2>
        </template>

        <div class="space-y-6">
            <div class="mx-auto max-w-7xl">
                <ApiTokenManager
                    :tokens="tokens"
                    :available-permissions="availablePermissions"
                    :default-permissions="defaultPermissions"
                />
            </div>
        </div>
    </AppLayout>
</template>
