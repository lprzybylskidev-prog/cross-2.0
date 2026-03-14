<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class="block w-full appearance-none rounded-2xl border border-[color:var(--ui-border)] bg-[color:var(--ui-panel)] px-4 py-3 text-sm text-[color:var(--ui-text)] shadow-sm outline-none transition placeholder:text-[color:var(--ui-text-muted)] focus:border-[color:var(--ui-accent)] focus:outline-none focus:[box-shadow:inset_0_0_0_1px_var(--ui-accent),0_1px_2px_rgba(0,0,0,0.12)] focus-visible:outline-none"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    />
</template>
