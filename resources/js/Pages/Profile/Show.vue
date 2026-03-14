<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProfileOverviewPanel from '@/Pages/Profile/Partials/ProfileOverviewPanel.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();
</script>

<template>
    <AppLayout :title="t('profile.title')">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-[color:var(--ui-text)]">
                {{ t('profile.title') }}
            </h2>
        </template>

        <div class="space-y-6">
            <div class="mx-auto max-w-7xl space-y-6">
                <div>
                    <ProfileOverviewPanel :user="$page.props.auth.user" />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canUpdatePassword">
                    <UpdatePasswordForm class="mt-10 sm:mt-0" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
