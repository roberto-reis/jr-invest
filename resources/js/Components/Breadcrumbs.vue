<script setup lang="ts">
defineProps<{
    items: Array<{
        label: string;
        url?: string;
    }>;
}>();
</script>

<template>
    <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
        <template v-for="(item, index) in items" :key="index">
            <!-- Link if URL is provided -->
            <a
                v-if="item.url"
                :href="item.url"
                class="hover:text-blue-500 dark:hover:text-blue-400"
            >
                {{ item.label }}
            </a>

            <!-- Plain text if no URL -->
            <span
                v-else
                class="text-gray-800 dark:text-gray-300"
            >
                {{ item.label }}
            </span>

            <!-- Separator (except for last item) -->
            <span
                v-if="index < items.length - 1"
                class="mx-1"
            >
                >
            </span>
        </template>
    </div>
</template>
