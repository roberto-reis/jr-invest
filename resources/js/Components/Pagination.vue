<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { PaginatedData } from '@/types';

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginationProps<T> {
    data: PaginatedData<T>;
    route: string;
    onlyParams?: string[];
    preserveParams?: string[];
}

const props = withDefaults(defineProps<PaginationProps<any>>(), {
    onlyParams: () => ['data'],
    preserveParams: () => ['search']
});

const emit = defineEmits(['update:loading']);

const perPage = ref(props.data.per_page);
const isLoading = ref(false);

// Computed for visible page links
const pageLinks = computed(() => {
    // Get available page numbers
    const availablePages = [];
    for (let i = 1; i <= props.data.last_page; i++) {
        availablePages.push(i);
    }
    return availablePages;
});

// Watch for perPage changes
watch(perPage, (newValue) => {
    handlePageChange(1, newValue);
});

// Update perPage when props change
watch(() => props.data.per_page, (newValue) => {
    perPage.value = newValue;
});

const handlePageChange = (page: number, itemsPerPage: number = perPage.value) => {
    isLoading.value = true;
    emit('update:loading', true);

    // Get the current URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const params: Record<string, any> = {
        page: page,
        per_page: itemsPerPage
    };

    // Preserve specified parameters
    if (props.preserveParams && props.preserveParams.length > 0) {
        props.preserveParams.forEach(param => {
            if (urlParams.has(param)) {
                params[param] = urlParams.get(param);
            }
        });
    }

    router.get(
        route(props.route),
        params,
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
};
</script>

<template>
    <div v-if="props.data.total > 0" class="mt-6 overflow-hidden">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <select
                    v-model="perPage"
                    class="rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
                >
                    <option :value="10">10</option>
                    <option :value="25">25</option>
                    <option :value="50">50</option>
                    <option :value="100">100</option>
                </select>
                <span class="ml-3 text-sm text-gray-500 dark:text-gray-400">
                    Mostrando {{ props.data.from }} a {{ props.data.to }} de {{ props.data.total }} registros
                </span>
            </div>
            <div class="flex items-center gap-2">
                <button
                    :disabled="props.data.current_page === 1"
                    @click="handlePageChange(props.data.current_page - 1)"
                    :class="[
                        'rounded-md border px-3 py-1 text-sm',
                        props.data.current_page === 1
                            ? 'border-gray-200 bg-gray-100 text-gray-400 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-500'
                            : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600'
                    ]"
                >
                    Anterior
                </button>
                <div class="flex gap-1">
                    <button
                        v-for="page in pageLinks"
                        :key="page"
                        @click="handlePageChange(page)"
                        :class="[
                            'px-3 py-1 text-sm rounded-md border',
                            props.data.current_page === page
                                ? 'bg-blue-600 text-white border-blue-600'
                                : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600'
                        ]"
                    >
                        {{ page }}
                    </button>
                </div>
                <button
                    :disabled="props.data.current_page === props.data.last_page"
                    @click="handlePageChange(props.data.current_page + 1)"
                    :class="[
                        'rounded-md border px-3 py-1 text-sm',
                        props.data.current_page === props.data.last_page
                            ? 'border-gray-200 bg-gray-100 text-gray-400 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-500'
                            : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600'
                    ]"
                >
                    Próximo
                </button>
            </div>
        </div>
    </div>
</template>
