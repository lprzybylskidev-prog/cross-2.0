<script setup>
defineProps({
    value: String,
});
</script>

<template>
    <label class="block text-sm font-medium text-[color:var(--ui-text-soft)]">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
