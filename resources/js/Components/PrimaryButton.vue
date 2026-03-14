<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button
        :type="type"
        class="focus:ring-[color:var(--ui-accent)]/30 inline-flex items-center justify-center rounded-2xl border border-transparent bg-[color:var(--ui-accent)] px-4 py-3 text-sm font-semibold text-[color:var(--ui-accent-contrast)] transition hover:brightness-110 focus:outline-none focus:ring-2 disabled:cursor-not-allowed disabled:opacity-50"
    >
        <slot />
    </button>
</template>
