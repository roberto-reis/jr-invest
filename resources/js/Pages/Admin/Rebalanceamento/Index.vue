<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import VueApexCharts from 'vue3-apexcharts';
import { formatCurrency, formatNumber } from '@/Utils/formatters';

// Breadcrumbs data
const breadcrumbItems = [
    { label: 'Início', url: route('dashboard') },
    { label: 'Rebalanceamento' }
];

const props = defineProps({
    carteira: {
        type: Object,
        required: true
    },
    posicaoAtualClasseKeys: {
        type: Array,
        required: true
    },
    posicaoAtualClasseValues: {
        type: Array,
        required: true
    },
    posicaoIdealClasseKeys: {
        type: Array,
        required: true
    },
    posicaoIdealClasseValues: {
        type: Array,
        required: true
    },
    feedback: {
        type: String,
        required: false
    }
});

// Dados para os gráficos de categorias
const minhaCarteiraOptions = ref({
    chart: {
        type: 'pie',
        height: 220,
    },
    labels: props.posicaoAtualClasseKeys,
    colors: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
    legend: {
        position: 'bottom',
        fontSize: '14px'
    },
    dataLabels: {
        enabled: true,
        formatter: function (val) {
            return val.toFixed(1) + "%"
        }
    }
});

const posicaoIdealOptions = ref({
    chart: {
        type: 'pie',
        height: 220,
    },
    labels: props.posicaoIdealClasseKeys,
    colors: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
    legend: {
        position: 'bottom',
        fontSize: '14px'
    },
    dataLabels: {
        enabled: true,
        formatter: function (val) {
            return val.toFixed(1) + "%"
        }
    }
});

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
            <!-- Feedback aviso -->
            <div v-if="props.feedback" class="mb-6">
                <div
                    class="flex gap-3 items-start rounded-md border p-4
                           bg-yellow-50 border-yellow-200 text-yellow-800
                           dark:bg-yellow-900 dark:border-yellow-700 dark:text-yellow-100"
                >
                    <svg class="h-6 w-6 flex-shrink-0 text-yellow-600 dark:text-yellow-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.72-1.36 3.485 0l6.518 11.582C18.59 16.55 17.663 18 16.312 18H3.688c-1.351 0-2.278-1.45-1.948-3.319L8.257 3.1zM9 7a1 1 0 112 0v4a1 1 0 11-2 0V7zm0 8a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd" />
                    </svg>

                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-semibold">Atenção</h3>
                        </div>
                        <p class="mt-1 text-base leading-relaxed">
                            {{ props.feedback }}
                        </p>
                    </div>
                </div>
            </div>

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

            <!-- Rebalanceamento por Ativo -->
            <div class="mb-6">
                <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-200">Rebalanceamento por Ativo</h2>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <!-- Card Posição Atual -->
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-3 bg-gray-200 dark:bg-gray-700">
                            <h3 class="text-center font-medium text-gray-700 dark:text-gray-200">Posição Atual</h3>
                        </div>
                        <div class="p-3">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="text-left text-base font-bold text-gray-500 dark:text-gray-300">
                                        <tr>
                                            <th class="px-2 py-2">
                                                Ativo
                                            </th>
                                            <th class="px-2 py-2">
                                                QT. Cota
                                            </th>
                                            <th class="px-2 py-2">
                                                Valor R$
                                            </th>
                                            <th class="px-2 py-2">
                                                %
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y text-xs divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-200">
                                        <tr v-for="(item) in carteira" :key="item.uid">
                                            <td class="px-2 py-2">{{ item.codigo_ativo }}</td>
                                            <td class="px-2 py-2">{{ formatNumber(item.quantidade) }}</td>
                                            <td class="px-2 py-2">{{ formatCurrency(item.patrimonio) }}</td>
                                            <td class="px-2 py-2">{{ formatNumber(item.percentual_na_carteira) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Card Posição Ideal -->
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-3 bg-gray-200 dark:bg-gray-700">
                            <h3 class="text-center font-medium text-gray-700 dark:text-gray-200">
                                Posição Ideal (Por Ativo)
                            </h3>
                        </div>
                        <div class="p-3">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="text-left text-base font-bold text-gray-500 dark:text-gray-300">
                                        <tr>
                                            <th class="px-2 py-2">Ativo</th>
                                            <th class="px-2 py-2">QT. Cota</th>
                                            <th class="px-2 py-2">Valor R$</th>
                                            <th class="px-2 py-2">%</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y text-xs divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-200">
                                        <tr v-for="(item) in carteira" :key="item.uid">
                                            <td class="px-2 py-2">{{ item.codigo_ativo }}</td>
                                            <td class="px-2 py-2">{{ formatNumber(item.quntidade_ideal) }}</td>
                                            <td class="px-2 py-2">{{ formatCurrency(item.valor_ideal) }}</td>
                                            <td class="px-2 py-2">{{ formatNumber(item.percentual_ideal) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Card Ajuste de Posição -->
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-3 bg-gray-200 dark:bg-gray-700">
                            <h3 class="text-center font-medium text-gray-700 dark:text-gray-200">Ajuste de Posição</h3>
                        </div>
                        <div class="p-3">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="text-left text-base font-bold text-gray-500 dark:text-gray-300">
                                        <tr>
                                            <th class="px-2 py-2">Ativo</th>
                                            <th class="px-2 py-2">QT. Cota</th>
                                            <th class="px-2 py-2">Valor R$</th>
                                            <th class="px-2 py-2">%</th>
                                            <th class="px-2 py-2">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y text-xs divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-200">
                                        <tr v-for="(item) in carteira" :key="item.uid">
                                            <td class="px-2 py-2">{{ item.codigo_ativo }}</td>
                                            <td class="px-2 py-2">{{ formatNumber(item.quantidade_ajuste) }}</td>
                                            <td class="px-2 py-2" :class="item.tipo_ajuste == 'comprar' ? 'text-green-600' : 'text-red-600'">
                                                {{ formatCurrency(item.valor_ajuste) }}
                                            </td>
                                            <td class="px-2 py-2" :class="item.tipo_ajuste == 'comprar' ? 'text-green-600' : 'text-red-600'">
                                                {{ formatNumber(item.percentual_ajuste) }}
                                            </td>
                                            <td class="px-2 py-2">
                                                <span
                                                    class="inline-flex items-center rounded-full px-2.5 py-0.4 font-medium"
                                                    :class="item.tipo_ajuste == 'comprar' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                                >
                                                    {{ item.tipo_ajuste }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rebalanceamento por Categoria -->
            <div class="mb-6">
                <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-200">Rebalanceamento por Classe</h2>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- Card Posição atual -->
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-3 bg-gray-200 dark:bg-gray-700">
                            <h3 class="text-center font-medium text-gray-700 dark:text-gray-200">Posição Atual</h3>
                        </div>
                        <div class="p-6">
                            <VueApexCharts
                                height="350"
                                type="pie"
                                :options="minhaCarteiraOptions"
                                :series="props.posicaoAtualClasseValues"
                            />
                        </div>
                    </div>

                    <!-- Card Posição Ideal -->
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-3 bg-gray-200 dark:bg-gray-700">
                            <h3 class="text-center font-medium text-gray-700 dark:text-gray-200">Posição Ideal (Por classe)</h3>
                        </div>
                        <div class="p-6">
                            <VueApexCharts
                                height="350"
                                type="pie"
                                :options="posicaoIdealOptions"
                                :series="props.posicaoIdealClasseValues"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
