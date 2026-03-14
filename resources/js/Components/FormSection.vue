<script setup>
import { computed, useSlots } from 'vue';
import SectionTitle from './SectionTitle.vue';

defineEmits(['submitted']);

const hasActions = computed(() => !!useSlots().actions);
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
            <form class="space-y-0" novalidate @submit.prevent="$emit('submitted')">
                <div
                    class="rounded-t-[1.75rem] border border-[color:var(--ui-border)] bg-[color:var(--ui-surface)] p-5 shadow-lg shadow-black/5 sm:p-6"
                    :class="hasActions ? '' : 'rounded-b-[1.75rem]'"
                >
                    <div class="grid grid-cols-6 gap-6">
                        <slot name="form" />
                    </div>
                </div>

                <div
                    v-if="hasActions"
                    class="flex flex-wrap items-center justify-end gap-3 rounded-b-[1.75rem] border border-t-0 border-[color:var(--ui-border)] bg-[color:var(--ui-surface-muted)] px-5 py-4 text-end shadow-lg shadow-black/5 sm:px-6"
                >
                    <slot name="actions" />
                </div>
            </form>
        </div>
    </div>
</template>
