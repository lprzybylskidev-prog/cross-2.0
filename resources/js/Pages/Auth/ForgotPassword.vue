<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useTranslations } from '@/Composables/useTranslations';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const { t } = useTranslations();

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head :title="t('auth.forgot_password.title')" />

    <AuthLayout
        :title="t('auth.forgot_password.title')"
        :description="t('auth.forgot_password.description')"
    >
        <div class="mb-4 text-sm text-[color:var(--ui-text-soft)]">
            {{ t('auth.forgot_password.helper') }}
        </div>

        <div
            v-if="status"
            class="mb-4 rounded-2xl border border-emerald-400/20 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-300"
        >
            {{ status }}
        </div>

        <form class="space-y-4" novalidate @submit.prevent="submit">
            <div>
                <InputLabel for="email" :value="t('common.email')" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="mt-1 block w-full"
                    autofocus
                    autocomplete="username"
                    inputmode="email"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="flex justify-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ t('auth.forgot_password.submit') }}
                </PrimaryButton>
            </div>
        </form>
    </AuthLayout>
</template>
