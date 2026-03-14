<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="focus:ring-[color:var(--ui-accent)]/20 inline-flex items-center justify-center rounded-2xl border border-[color:var(--ui-border-strong)] bg-[color:var(--ui-surface)] px-4 py-3 text-sm font-semibold text-[color:var(--ui-text)] shadow-sm transition hover:bg-[color:var(--ui-surface-muted)] focus:outline-none focus:ring-2 disabled:cursor-not-allowed disabled:opacity-50"
    >
        <slot />
    </button>
</template>
