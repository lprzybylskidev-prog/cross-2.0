<script setup>
import { computed } from 'vue';
import { getUserInitials } from '@/lib/profile';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    size: {
        type: String,
        default: 'md',
    },
});

const sizeClasses = computed(() => {
    if (props.size === 'lg') {
        return {
            frame: 'size-16 rounded-2xl text-lg tracking-[0.18em]',
            image: 'size-16 rounded-2xl',
        };
    }

    if (props.size === 'nav') {
        return {
            frame: 'size-11 rounded-2xl text-base leading-none tracking-[0.08em]',
            image: 'size-11 rounded-2xl',
        };
    }

    return {
        frame: 'size-8 rounded-2xl text-sm tracking-[0.12em]',
        image: 'size-8 rounded-2xl',
    };
});

const initials = computed(() => getUserInitials(props.user.name));
</script>

<template>
    <img
        v-if="$page.props.jetstream.managesProfilePhotos && user.profile_photo_url"
        :src="user.profile_photo_url"
        :alt="user.name"
        class="shrink-0 border border-[color:var(--ui-border)] object-cover"
        :class="sizeClasses.image"
    />

    <div
        v-else
        class="flex shrink-0 items-center justify-center border border-[color:var(--ui-border)] bg-[color:var(--ui-surface)] font-semibold text-[color:var(--ui-accent-strong)]"
        :class="sizeClasses.frame"
    >
        {{ initials }}
    </div>
</template>
