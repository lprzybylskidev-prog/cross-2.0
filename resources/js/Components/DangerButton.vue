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
        class="inline-flex items-center justify-center rounded-2xl border border-red-400/30 bg-red-500/15 px-4 py-3 text-sm font-semibold text-red-300 transition hover:bg-red-500/25 focus:outline-none focus:ring-2 focus:ring-red-400/30"
    >
        <slot />
    </button>
</template>
