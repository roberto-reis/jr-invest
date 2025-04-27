<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { formatCurrency, formatNumber } from '@/Utils/formatters';

// Breadcrumbs data
const breadcrumbItems = [
    { label: 'Início', url: route('dashboard') },
    { label: 'Portfólio' }
];

// Recebe as propriedades do componente
const props = defineProps({
    carteira: {
        type: Object,
        required: true
    }
});

// Estado para busca e paginação
const search = ref('');

// Função para exportar dados
const exportarDados = () => {
    console.log('Exportando dados do portfólio...');
    // Implementar lógica de exportação (CSV, Excel, etc.)
};

// Filtra os itens do portfólio com base na busca
const filteredItems = computed(() => {
    if (!search.value) return props.carteira;

    const searchLower = search.value.toLowerCase();
    return props.carteira.filter((item: any) =>
        item.codigo_ativo.toLowerCase().includes(searchLower) ||
        item.classe_ativo.toLowerCase().includes(searchLower)
    );
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Portfólio" />
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Portfólio
                </h2>

                <!-- Use the Breadcrumbs component -->
                <Breadcrumbs :items="breadcrumbItems" />
            </div>
        </template>

        <div>
            <div class="bg-white p-4 shadow-sm dark:bg-gray-800 sm:rounded-lg mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <button
                            @click="exportarDados"
                            class="rounded-md border border-gray-600 bg-white px-4 py-2 text-gray-600 hover:bg-gray-50 dark:border-gray-400 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600">
                            Exportar
                        </button>
                    </div>

                    <div class="flex-1 md:max-w-sm">
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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 border-b border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                    Ativo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                    Classe
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                    Qtd
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                    Preço Médio
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                    Custo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                    Patrimônio
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                    % Na Classe
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                    % Na Carteira
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            <tr v-for="item in filteredItems" :key="item.uid" class="text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="whitespace-nowrap px-6 py-4 text-gray-800 dark:text-gray-300">
                                    {{ item.codigo_ativo }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ item.classe_ativo }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ formatNumber(item.quantidade) }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ formatCurrency(item.preco_medio) }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ formatCurrency(item.custo_total) }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-green-600 dark:text-green-400">
                                    {{ formatCurrency(item.patrimonio) }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ formatNumber(item.percentual_classe) }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ formatNumber(item.percentual_na_carteira) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginação -->

        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
