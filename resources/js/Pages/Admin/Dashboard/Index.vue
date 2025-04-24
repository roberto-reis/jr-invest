<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PatrimonioChart from '@/Components/PatrimonioChart.vue';
import ProventosChart from '@/Components/ProventosChart.vue';
import ComposicaoCarteiraChart from '@/Components/ComposicaoCarteiraChart.vue';
import UltimasOperacoesTable from '@/Components/UltimasOperacoesTable.vue';

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div>
            <!-- Cards de Rentabilidade -->
            <div class="grid grid-cols-1 gap-4 mb-5 md:grid-cols-3">
                <!-- Card Rentabilidade (Dia) -->
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <p class="text-lg font-medium text-red-600 dark:text-red-400">-R$ 100.500,00 (-15%)</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rentabilidade (Dia)</p>
                        <div class="text-red-500 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card Rentabilidade (últimos 30 dias) -->
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <p class="text-lg font-medium text-green-600 dark:text-green-400">R$ 100.500,00 (15%)</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rentabilidade (últimos 30 dias)</p>
                        <div class="text-green-500 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd" transform="rotate(180, 10, 10)" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card Rentabilidade (Ano) -->
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <p class="text-lg font-medium text-green-600 dark:text-green-400">R$ 100.500,00 (15%)</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rentabilidade (Ano)</p>
                        <div class="text-green-500 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd" transform="rotate(180, 10, 10)" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <PatrimonioChart />
            </div>

            <!-- Gráfico de Proventos -->
            <div class="mb-5">
                <ProventosChart />
            </div>

            <!-- Composição da Carteira e Últimas Operações -->
            <div class="grid grid-cols-1 gap-4 mb-5 md:grid-cols-2">
                <!-- Composição da Carteira -->
                <div>
                    <ComposicaoCarteiraChart />
                </div>

                <div class="px-4 pt-4 bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Últimas Operações</h2>
                    <UltimasOperacoesTable />
                    <!-- Conteúdo para Últimas Operações será adicionado posteriormente -->
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
