<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import ActionSection from '@/Components/ActionSection.vue';
import Checkbox from '@/Components/Checkbox.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    tokens: Array,
    availablePermissions: Array,
    defaultPermissions: Array,
});

const createApiTokenForm = useForm({
    name: '',
    permissions: props.defaultPermissions,
});

const updateApiTokenForm = useForm({
    permissions: [],
});

const deleteApiTokenForm = useForm({});

const displayingToken = ref(false);
const managingPermissionsFor = ref(null);
const apiTokenBeingDeleted = ref(null);

const createApiToken = () => {
    createApiTokenForm.post(route('api-tokens.store'), {
        preserveScroll: true,
        onSuccess: () => {
            displayingToken.value = true;
            createApiTokenForm.reset();
        },
    });
};

const manageApiTokenPermissions = (token) => {
    updateApiTokenForm.permissions = token.abilities;
    managingPermissionsFor.value = token;
};

const updateApiToken = () => {
    updateApiTokenForm.put(route('api-tokens.update', managingPermissionsFor.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (managingPermissionsFor.value = null),
    });
};

const confirmApiTokenDeletion = (token) => {
    apiTokenBeingDeleted.value = token;
};

const deleteApiToken = () => {
    deleteApiTokenForm.delete(route('api-tokens.destroy', apiTokenBeingDeleted.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (apiTokenBeingDeleted.value = null),
    });
};
</script>

<template>
    <div>
        <!-- Generate API Token -->
        <FormSection @submitted="createApiToken">
            <template #title> {{ $t('api.create.title') }} </template>

            <template #description>
                {{ $t('api.create.description') }}
            </template>

            <template #form>
                <!-- Token Name -->
                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="name" :value="$t('common.name')" />
                    <TextInput
                        id="name"
                        v-model="createApiTokenForm.name"
                        type="text"
                        class="mt-1 block w-full"
                        autofocus
                    />
                    <InputError :message="createApiTokenForm.errors.name" class="mt-2" />
                </div>

                <!-- Token Permissions -->
                <div v-if="availablePermissions.length > 0" class="col-span-6">
                    <InputLabel for="permissions" :value="$t('api.permissions')" />

                    <div class="mt-2 grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div v-for="permission in availablePermissions" :key="permission">
                            <label class="flex items-center text-[color:var(--ui-text-soft)]">
                                <Checkbox
                                    v-model:checked="createApiTokenForm.permissions"
                                    :value="permission"
                                />
                                <span class="ms-2 text-sm">{{ permission }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </template>

            <template #actions>
                <ActionMessage :on="createApiTokenForm.recentlySuccessful" class="me-3">
                    {{ $t('common.created') }}
                </ActionMessage>

                <PrimaryButton
                    :class="{ 'opacity-25': createApiTokenForm.processing }"
                    :disabled="createApiTokenForm.processing"
                >
                    {{ $t('common.create') }}
                </PrimaryButton>
            </template>
        </FormSection>

        <div v-if="tokens.length > 0">
            <SectionBorder />

            <!-- Manage API Tokens -->
            <div class="mt-10 sm:mt-0">
                <ActionSection>
                    <template #title> {{ $t('api.manage.title') }} </template>

                    <template #description>
                        {{ $t('api.manage.description') }}
                    </template>

                    <!-- API Token List -->
                    <template #content>
                        <div class="space-y-6">
                            <div
                                v-for="token in tokens"
                                :key="token.id"
                                class="flex items-center justify-between"
                            >
                                <div class="break-all">
                                    {{ token.name }}
                                </div>

                                <div class="ms-2 flex items-center">
                                    <div
                                        v-if="token.last_used_ago"
                                        class="text-sm text-[color:var(--ui-text-muted)]"
                                    >
                                        {{
                                            $t('api.manage.last_used', {
                                                time: token.last_used_ago,
                                            })
                                        }}
                                    </div>

                                    <button
                                        v-if="availablePermissions.length > 0"
                                        class="ms-6 cursor-pointer text-sm text-[color:var(--ui-text-muted)] underline"
                                        @click="manageApiTokenPermissions(token)"
                                    >
                                        {{ $t('api.permissions') }}
                                    </button>

                                    <button
                                        class="ms-6 cursor-pointer text-sm text-red-500"
                                        @click="confirmApiTokenDeletion(token)"
                                    >
                                        {{ $t('common.delete') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </ActionSection>
            </div>
        </div>

        <!-- Token Value Modal -->
        <DialogModal :show="displayingToken" @close="displayingToken = false">
            <template #title> {{ $t('api.token_value.title') }} </template>

            <template #content>
                <div>
                    {{ $t('api.token_value.description') }}
                </div>

                <div
                    v-if="$page.props.jetstream.flash.token"
                    class="mt-4 break-all rounded-2xl bg-[color:var(--ui-panel)] px-4 py-2 font-mono text-sm text-[color:var(--ui-text)]"
                >
                    {{ $page.props.jetstream.flash.token }}
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="displayingToken = false">{{
                    $t('common.close')
                }}</SecondaryButton>
            </template>
        </DialogModal>

        <!-- API Token Permissions Modal -->
        <DialogModal :show="managingPermissionsFor != null" @close="managingPermissionsFor = null">
            <template #title> {{ $t('api.permissions_modal.title') }} </template>

            <template #content>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div v-for="permission in availablePermissions" :key="permission">
                        <label class="flex items-center text-[color:var(--ui-text-soft)]">
                            <Checkbox
                                v-model:checked="updateApiTokenForm.permissions"
                                :value="permission"
                            />
                            <span class="ms-2 text-sm">{{ permission }}</span>
                        </label>
                    </div>
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="managingPermissionsFor = null">{{
                    $t('common.cancel')
                }}</SecondaryButton>

                <PrimaryButton
                    class="ms-3"
                    :class="{ 'opacity-25': updateApiTokenForm.processing }"
                    :disabled="updateApiTokenForm.processing"
                    @click="updateApiToken"
                >
                    {{ $t('common.save') }}
                </PrimaryButton>
            </template>
        </DialogModal>

        <!-- Delete Token Confirmation Modal -->
        <ConfirmationModal
            :show="apiTokenBeingDeleted != null"
            @close="apiTokenBeingDeleted = null"
        >
            <template #title> {{ $t('api.delete.title') }} </template>

            <template #content> {{ $t('api.delete.description') }} </template>

            <template #footer>
                <SecondaryButton @click="apiTokenBeingDeleted = null">{{
                    $t('common.cancel')
                }}</SecondaryButton>

                <DangerButton
                    class="ms-3"
                    :class="{ 'opacity-25': deleteApiTokenForm.processing }"
                    :disabled="deleteApiTokenForm.processing"
                    @click="deleteApiToken"
                >
                    {{ $t('common.delete') }}
                </DangerButton>
            </template>
        </ConfirmationModal>
    </div>
</template>
