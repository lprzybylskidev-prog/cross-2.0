<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    canViewHome: {
        type: Boolean,
        required: true,
    },
});
</script>

<template>
    <Head title="Home" />

    <AppLayout title="Home">
        <template #header>
            <h1 class="text-2xl font-semibold text-gray-900">Cross 2.0</h1>
        </template>

        <section class="mx-auto max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-gray-700">
                    Welcome to the Cross 2.0 workspace. The system is prepared for debt collection
                    workflows across amicable, court, and enforcement stages.
                </p>
                <p class="mt-3 text-sm text-gray-500">
                    Permission check for this page:
                    <strong>{{ canViewHome ? 'granted' : 'denied' }}</strong>
                </p>
            </div>
        </section>
    </AppLayout>
</template>
