<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useTranslations } from '@/Composables/useTranslations';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const { t } = useTranslations();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head :title="t('auth.login.title')" />

    <AuthLayout :title="t('auth.login.title')" :description="t('auth.login.description')">
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

            <div class="mt-4">
                <InputLabel for="password" :value="t('common.password')" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block">
                <label class="flex items-center text-sm text-[color:var(--ui-text-soft)]">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ms-2">{{ t('auth.login.remember') }}</span>
                </label>
            </div>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm font-medium text-[color:var(--ui-accent-strong)] transition hover:text-[color:var(--ui-accent)]"
                >
                    {{ t('auth.login.forgot_password') }}
                </Link>

                <PrimaryButton
                    class="w-full sm:w-auto"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ t('auth.login.submit') }}
                </PrimaryButton>
            </div>
        </form>
    </AuthLayout>
</template>
