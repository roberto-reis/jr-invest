<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';

// Breadcrumbs data
const breadcrumbItems = [
    { label: 'Início', url: route('dashboard') },
    { label: 'Classes de Ativos' }
];

const search = ref('');

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Classes de Ativos" />
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Classes de Ativos
                </h2>

                <Breadcrumbs :items="breadcrumbItems" />
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow-sm dark:bg-gray-800 sm:rounded-lg mb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <button
                                @click="openNovaClasseModal"
                                class="rounded-md border border-green-600 bg-white px-4 py-2 text-green-600 hover:bg-green-50 dark:border-green-400 dark:bg-gray-700 dark:text-green-400 dark:hover:bg-gray-600">
                                Nova Classe
                            </button>
                        </div>

                        <div class="flex-1 md:max-w-sm ml-4">
                            <div class="relative">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Buscar..."
                                    class="w-full rounded-md border-gray-300 pr-10 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
                                />
                                <button class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </AuthenticatedLayout>
</template>
