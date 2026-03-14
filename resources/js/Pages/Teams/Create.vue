<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateTeamForm from '@/Pages/Teams/Partials/CreateTeamForm.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();
</script>

<template>
    <AppLayout :title="t('teams.create.title')">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-[color:var(--ui-text)]">
                {{ t('teams.create.title') }}
            </h2>
        </template>

        <div class="space-y-6">
            <div class="mx-auto max-w-7xl">
                <CreateTeamForm />
            </div>
        </div>
    </AppLayout>
</template>
