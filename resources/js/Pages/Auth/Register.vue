<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head :title="t('auth.register.title')" />

    <AuthLayout :title="t('auth.register.title')" :description="t('auth.register.description')">
        <form class="space-y-4" novalidate @submit.prevent="submit">
            <div>
                <InputLabel for="name" :value="t('common.name')" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" :value="t('common.email')" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="mt-1 block w-full"
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
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    :value="t('auth.register.password_confirmation')"
                />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center text-sm text-[color:var(--ui-text-soft)]">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" />

                        <div class="ms-2">
                            {{ t('auth.register.terms_prefix') }}
                            <a
                                target="_blank"
                                :href="route('terms.show')"
                                class="font-medium text-[color:var(--ui-accent-strong)] transition hover:text-[color:var(--ui-accent)]"
                                >{{ t('legal.terms.title') }}</a
                            >
                            {{ ` ${t('common.and')} ` }}
                            <a
                                target="_blank"
                                :href="route('policy.show')"
                                class="font-medium text-[color:var(--ui-accent-strong)] transition hover:text-[color:var(--ui-accent)]"
                                >{{ t('legal.privacy.title') }}</a
                            >
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                <Link
                    :href="route('login')"
                    class="text-sm font-medium text-[color:var(--ui-accent-strong)] transition hover:text-[color:var(--ui-accent)]"
                >
                    {{ t('auth.register.login_link') }}
                </Link>

                <PrimaryButton
                    class="w-full sm:w-auto"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ t('auth.register.submit') }}
                </PrimaryButton>
            </div>
        </form>
    </AuthLayout>
</template>
