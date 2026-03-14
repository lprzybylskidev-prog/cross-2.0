<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useTranslations } from '@/Composables/useTranslations';

const form = useForm({
    password: '',
});

const passwordInput = ref(null);
const { t } = useTranslations();

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();

            passwordInput.value.focus();
        },
    });
};
</script>

<template>
    <Head :title="t('auth.confirm_password.title')" />

    <AuthLayout
        :title="t('auth.confirm_password.title')"
        :description="t('auth.confirm_password.description')"
    >
        <div class="mb-4 text-sm text-[color:var(--ui-text-soft)]">
            {{ t('auth.confirm_password.helper') }}
        </div>

        <form class="space-y-4" novalidate @submit.prevent="submit">
            <div>
                <InputLabel for="password" :value="t('common.password')" />
                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 flex justify-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ t('auth.confirm_password.submit') }}
                </PrimaryButton>
            </div>
        </form>
    </AuthLayout>
</template>
