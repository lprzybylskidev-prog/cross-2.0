<script setup>
import SectionTitle from './SectionTitle.vue';
</script>

<template>
    <div class="grid gap-6 xl:grid-cols-[minmax(0,18rem)_minmax(0,1fr)]">
        <SectionTitle>
            <template #title>
                <slot name="title" />
            </template>
            <template #description>
                <slot name="description" />
            </template>
        </SectionTitle>

        <div>
            <div
                class="rounded-[1.75rem] border border-[color:var(--ui-border)] bg-[color:var(--ui-surface)] px-5 py-5 shadow-lg shadow-black/5 sm:p-6"
            >
                <slot name="content" />
            </div>
        </div>
    </div>
</template>
