<script setup>
import { IconHome } from '@tabler/icons-vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
</script>

<template>
    <nav v-if="page.props.breadcrumbs?.length" class="mb-4 sm:mb-6" aria-label="Breadcrumb">
        <ol
            class="flex flex-wrap items-center gap-2 rounded-2xl border border-[color:var(--ui-border)] bg-[color:var(--ui-surface)] px-4 py-3 text-sm text-[color:var(--ui-text-muted)] shadow-lg shadow-black/5"
        >
            <li class="flex items-center">
                <IconHome class="h-4 w-4 text-[color:var(--ui-accent-strong)]" />
            </li>
            <li
                v-for="(crumb, index) in page.props.breadcrumbs"
                :key="`${crumb.title}-${index}`"
                class="flex items-center gap-2"
            >
                <span v-if="index > 0" class="text-[color:var(--ui-text-muted)]">/</span>
                <a :href="crumb.url" class="transition hover:text-[color:var(--ui-text)]">{{
                    crumb.title
                }}</a>
            </li>
        </ol>
    </nav>
</template>
