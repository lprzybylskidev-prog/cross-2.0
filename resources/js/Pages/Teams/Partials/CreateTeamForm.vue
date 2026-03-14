<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
});

const createTeam = () => {
    form.post(route('teams.store'), {
        errorBag: 'createTeam',
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="createTeam">
        <template #title> {{ $t('teams.create.details_title') }} </template>

        <template #description>
            {{ $t('teams.create.details_description') }}
        </template>

        <template #form>
            <div class="col-span-6">
                <InputLabel :value="$t('teams.common.owner')" />

                <div class="mt-2 flex items-center">
                    <img
                        class="size-12 rounded-full object-cover"
                        :src="$page.props.auth.user.profile_photo_url"
                        :alt="$page.props.auth.user.name"
                    />

                    <div class="ms-4 leading-tight">
                        <div class="text-[color:var(--ui-text)]">
                            {{ $page.props.auth.user.name }}
                        </div>
                        <div class="text-sm text-[color:var(--ui-text-muted)]">
                            {{ $page.props.auth.user.email }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" :value="$t('teams.common.name')" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    autofocus
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ $t('common.create') }}
            </PrimaryButton>
        </template>
    </FormSection>
</template>
