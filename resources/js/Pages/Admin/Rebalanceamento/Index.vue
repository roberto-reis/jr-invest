<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Link } from '@inertiajs/vue3';

// Breadcrumbs data
const breadcrumbItems = [
    { label: 'Início', url: route('dashboard') },
    { label: 'Rebalanceamento' }
];

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Rebalanceamento" />
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Rebalanceamento
                </h2>

                <!-- Use the Breadcrumbs component -->
                <Breadcrumbs :items="breadcrumbItems" />
            </div>
        </template>

        <div>
                        <!-- Barra de ações em um card separado -->
            <div class="mb-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-4">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex gap-2">
                            <Link :href="route('rebalanceamento.config')" class="rounded-md border border-gray-600 bg-white px-4 py-2 text-gray-600 hover:bg-gray-50 dark:border-gray-400 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600">
                                Config. Rebalanceamento
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </AuthenticatedLayout>
</template>

<style scoped>
</style>
