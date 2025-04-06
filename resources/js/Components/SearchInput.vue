<script setup lang="ts">
import { ref, watch, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';

interface Props {
    route: string;
    placeholder?: string;
    minLength?: number;
    debounceTime?: number;
    onlyParams?: string[];
}

const props = withDefaults(defineProps<Props>(), {
    placeholder: 'Buscar...',
    minLength: 2,
    debounceTime: 300,
    onlyParams: () => []
});

const emit = defineEmits(['update:loading']);

const searchQuery = ref('');
const isLoading = ref(false);
let searchTimeout: number | null = null;

// Custom debounce function for search
const debouncedSearch = (query: string) => {
    // Clear any existing timeout
    if (searchTimeout) clearTimeout(searchTimeout);

    // Set a new timeout
    searchTimeout = setTimeout(() => {
        if (query.length >= props.minLength) {
            isLoading.value = true;
            emit('update:loading', true);

            router.get(
                route(props.route),
                { search: query },
                {
                    preserveState: true,
                    preserveScroll: true,
                    only: props.onlyParams,
                    onSuccess: () => {
                        isLoading.value = false;
                        emit('update:loading', false);
                    },
                    onError: () => {
                        isLoading.value = false;
                        emit('update:loading', false);
                    }
                }
            );
        } else if (query.length === 0) {
            // Reset to full list when search is cleared
            isLoading.value = true;
            emit('update:loading', true);

            router.get(
                route(props.route),
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                    only: props.onlyParams,
                    onSuccess: () => {
                        isLoading.value = false;
                        emit('update:loading', false);
                    },
                    onError: () => {
                        isLoading.value = false;
                        emit('update:loading', false);
                    }
                }
            );
        }
    }, props.debounceTime);
};

// Watch for changes in the search input
watch(searchQuery, (newVal) => {
    debouncedSearch(newVal);
});

// Clean up the timeout when the component is unmounted
onUnmounted(() => {
    if (searchTimeout) clearTimeout(searchTimeout);
});
</script>

<template>
    <div class="relative">
        <input
            v-model="searchQuery"
            type="text"
            :placeholder="placeholder"
            class="w-full rounded-md border-gray-300 pr-10 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
        />
        <div class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
            <svg v-if="isLoading" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</template>
