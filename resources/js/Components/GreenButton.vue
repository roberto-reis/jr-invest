<script setup lang="ts">
withDefaults(
    defineProps<{
        type?: 'button' | 'submit' | 'reset';
    }>(),
    {
        type: 'button',
    },
);
</script>

<template>
    <button
        :type="type"
        class="rounded-md border border-green-600 bg-white px-4 py-2 text-green-600 hover:bg-green-50 dark:border-green-400 dark:bg-gray-700 dark:text-green-400 dark:hover:bg-gray-600"
    >
        <slot />
    </button>
</template>
