<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DeleteTeamForm from '@/Pages/Teams/Partials/DeleteTeamForm.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import TeamMemberManager from '@/Pages/Teams/Partials/TeamMemberManager.vue';
import UpdateTeamNameForm from '@/Pages/Teams/Partials/UpdateTeamNameForm.vue';
import { useTranslations } from '@/Composables/useTranslations';

defineProps({
    team: Object,
    availableRoles: Array,
    permissions: Object,
});

const { t } = useTranslations();
</script>

<template>
    <AppLayout :title="t('teams.settings.title')">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-[color:var(--ui-text)]">
                {{ t('teams.settings.title') }}
            </h2>
        </template>

        <div class="space-y-6">
            <div class="mx-auto max-w-7xl space-y-6">
                <UpdateTeamNameForm :team="team" :permissions="permissions" />

                <TeamMemberManager
                    class="mt-10 sm:mt-0"
                    :team="team"
                    :available-roles="availableRoles"
                    :user-permissions="permissions"
                />

                <template v-if="permissions.canDeleteTeam && !team.personal_team">
                    <SectionBorder />

                    <DeleteTeamForm class="mt-10 sm:mt-0" :team="team" />
                </template>
            </div>
        </div>
    </AppLayout>
</template>
