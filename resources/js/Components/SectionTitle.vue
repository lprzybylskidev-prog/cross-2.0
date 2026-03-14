<template>
    <div class="flex flex-col justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold text-[color:var(--ui-text)]">
                <slot name="title" />
            </h3>

            <p class="mt-2 text-sm leading-6 text-[color:var(--ui-text-soft)]">
                <slot name="description" />
            </p>
        </div>

        <div>
            <slot name="aside" />
        </div>
    </div>
</template>
