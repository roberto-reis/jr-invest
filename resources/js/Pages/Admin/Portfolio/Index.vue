<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

// Dados de exemplo para a tabela de portfólio
const portfolioItems = [
    {
        ativo: 'BTC',
        classe: 'CRIPTO',
        qtd: '0,00256565',
        precoMedio: 'R$ 290.000,00',
        custo: 'R$ 5.505,97',
        patrimonio: 'R$ 6.079,84',
        percentualClasse: '7,20%',
        percentualCarteira: '3,50%'
    },
    {
        ativo: 'HCTR11',
        classe: 'FII',
        qtd: '20,00000000',
        precoMedio: '11/12/2021 23:27',
        custo: 'R$ 5.505,97',
        patrimonio: 'R$ 6.079,84',
        percentualClasse: '7,20%',
        percentualCarteira: '3,50%'
    },
    {
        ativo: 'ETH',
        classe: 'CRIPTO',
        qtd: '0,00256565',
        precoMedio: 'R$ 95,50',
        custo: 'R$ 5.505,97',
        patrimonio: 'R$ 6.079,84',
        percentualClasse: '7,20%',
        percentualCarteira: '3,50%'
    },
    {
        ativo: 'VGIA11',
        classe: 'FII',
        qtd: '20,00000000',
        precoMedio: 'R$ 95,50',
        custo: 'R$ 5.505,97',
        patrimonio: 'R$ 6.079,84',
        percentualClasse: '7,20%',
        percentualCarteira: '3,50%'
    },
    {
        ativo: 'ETH',
        classe: 'CRIPTO',
        qtd: '0,00256565',
        precoMedio: 'R$ 290.000,00',
        custo: 'R$ 5.505,97',
        patrimonio: 'R$ 6.079,84',
        percentualClasse: '7,20%',
        percentualCarteira: '3,50%'
    }
];

// Estado para busca e paginação
const search = ref('');
const currentPage = ref(1);
const perPage = ref(10);

// Função para exportar dados
const exportarDados = () => {
    console.log('Exportando dados do portfólio...');
    // Implementar lógica de exportação (CSV, Excel, etc.)
};

// Filtra os itens do portfólio com base na busca
const filteredItems = computed(() => {
    if (!search.value) return portfolioItems;

    const searchLower = search.value.toLowerCase();
    return portfolioItems.filter(item =>
        item.ativo.toLowerCase().includes(searchLower) ||
        item.classe.toLowerCase().includes(searchLower)
    );
});
</script>

<template>
    <Head title="Portfólio" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Portfólio
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow-sm dark:bg-gray-800 sm:rounded-lg mb-4">
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

                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Ativo
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Classe
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Qtd.
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
                            <tbody>
                                <tr v-for="(item, index) in filteredItems" :key="index" :class="index % 2 === 0 ? '' : 'bg-gray-50 dark:bg-gray-900'">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ item.ativo }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ item.classe }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ item.qtd }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ item.precoMedio }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ item.custo }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-green-600 dark:text-green-400">
                                        {{ item.patrimonio }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ item.percentualClasse }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ item.percentualCarteira }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Paginação -->
                <div class="mt-4 flex items-center justify-between">
                    <div>
                        <select
                            v-model="perPage"
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        >
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>

                    <div class="flex space-x-1">
                        <button
                            class="rounded-md border border-gray-300 bg-white px-3 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        >
                            Anterior
                        </button>
                        <button
                            class="rounded-md border border-gray-300 bg-indigo-600 px-3 py-1 text-sm font-medium text-white hover:bg-indigo-700 dark:border-gray-600"
                        >
                            1
                        </button>
                        <button
                            class="rounded-md border border-gray-300 bg-white px-3 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        >
                            2
                        </button>
                        <button
                            class="rounded-md border border-gray-300 bg-white px-3 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        >
                            3
                        </button>
                        <button
                            class="rounded-md border border-gray-300 bg-white px-3 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        >
                            4
                        </button>
                        <button
                            class="rounded-md border border-gray-300 bg-white px-3 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        >
                            5
                        </button>
                        <button
                            class="rounded-md border border-gray-300 bg-white px-3 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        >
                            6
                        </button>
                        <button
                            class="rounded-md border border-gray-300 bg-white px-3 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        >
                            Próximo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
