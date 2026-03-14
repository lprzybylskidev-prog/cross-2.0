<script setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage();
</script>

<template>
    <nav
        v-if="page.props.breadcrumbs?.length"
        class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8"
        aria-label="Breadcrumb"
    >
        <ol class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
            <li
                v-for="(crumb, index) in page.props.breadcrumbs"
                :key="`${crumb.title}-${index}`"
                class="flex items-center gap-2"
            >
                <span v-if="index > 0" class="text-gray-400">/</span>
                <a :href="crumb.url" class="transition hover:text-gray-700">{{ crumb.title }}</a>
            </li>
        </ol>
    </nav>
</template>
