<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import NovoRecebimento from './NovoRecebimento.vue';
import VisualizarProvento from './VisualizarProvento.vue';
import EditarProvento from './EditarProvento.vue';
import ExcluirProvento from './ExcluirProvento.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Provento, Ativo, TipoProvento, Corretora, PaginatedData } from '@/types';
import { formatDate, formatCurrency, formatNumber } from '@/Utils/formatters';
import Pagination from '@/Components/Pagination.vue';
import SearchInput from '@/Components/SearchInput.vue';

const isLoading = ref(false);

const props = defineProps<{
    ativos: Ativo[];
    tiposProventos: TipoProvento[];
    corretoras: Corretora[];
    proventos: PaginatedData<Provento>;
}>();

// Breadcrumbs data
const breadcrumbItems = [
    { label: 'Início', url: route('dashboard') },
    { label: 'Proventos' }
];

const showNovoRecebimentoModal = ref(false);
const showVisualizarProventoModal = ref(false);
const showEditarProventoModal = ref(false);
const showExcluirProventoModal = ref(false);
const proventoSelecionado = ref(null);

const handleVisualizarProvento = (provento: any) => {
    proventoSelecionado.value = provento;
    showVisualizarProventoModal.value = true;
};

const handleEditarProvento = (provento: any) => {
    proventoSelecionado.value = provento;
    showEditarProventoModal.value = true;
};

const handleSubmitEdicao = (data: any) => {
    // Aqui você implementa a lógica para salvar as alterações do provento
    console.log('Provento editado:', data);
    showEditarProventoModal.value = false;
};

const handleExcluirProvento = (provento: any) => {
    proventoSelecionado.value = provento;
    showExcluirProventoModal.value = true;
};

const handleConfirmarExclusao = () => {
    // Aqui você implementa a lógica para excluir o provento
    console.log('Excluindo provento:', proventoSelecionado.value);
    showExcluirProventoModal.value = false;
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Proventos" />
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Proventos
                </h2>

                <!-- Use the Breadcrumbs component -->
                <Breadcrumbs :items="breadcrumbItems" />
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Barra de ações em um card separado -->
                <div class="mb-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-4">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex gap-2">
                                <button
                                    @click="showNovoRecebimentoModal = true"
                                    class="rounded-md border border-green-600 bg-white px-4 py-2 text-green-600 hover:bg-green-50 dark:border-green-400 dark:bg-gray-700 dark:text-green-400 dark:hover:bg-gray-600"
                                >
                                    Novo Recebimento
                                </button>
                                <button class="rounded-md border border-gray-600 bg-white px-4 py-2 text-gray-600 hover:bg-gray-50 dark:border-gray-400 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600">
                                    Exportar
                                </button>
                            </div>
                            <div class="flex-1 md:max-w-sm">
                                <SearchInput
                                    route="proventos.index"
                                    :only-params="['proventos']"
                                    @update:loading="(val) => isLoading = val"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card da tabela -->
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table v-if="props.proventos.data.length > 0" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Ativo
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Tipo de provento
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Data Com
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Data Pagamento
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        QTD
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Valor
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Valor Total
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Yield On Cost
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                <tr v-for="provento in props.proventos.data" :key="provento.uid">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ provento.ativo_codigo }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ provento.tipo_provento_nome }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ formatDate(provento.data_com) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ formatDate(provento.data_pagamento) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ formatNumber(provento.quantidade_ativo) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ formatCurrency(provento.valor) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ formatCurrency(provento.valor_total) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ formatNumber(provento.yield_on_cost) }} %
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <!-- Botão Visualizar -->
                                            <button
                                                @click="handleVisualizarProvento(provento)"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <!-- Botão Editar -->
                                            <button
                                                @click="handleEditarProvento(provento)"
                                                class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <!-- Botão Excluir -->
                                            <button
                                                @click="handleExcluirProvento(provento)"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-else class="flex h-full items-center justify-center">
                            <p class="text-gray-500 dark:text-gray-400">Nenhum provento encontrado</p>
                        </div>
                    </div>
                </div>

                <!-- Use the Pagination component -->
                <Pagination
                    :data="props.proventos"
                    route="proventos.index"
                    :only-params="['proventos']"
                    :preserve-params="['search']"
                    @update:loading="(val) => isLoading = val"
                />
            </div>
        </div>

        <!-- Modal de Novo Recebimento -->
        <NovoRecebimento
            :show="showNovoRecebimentoModal"
            @close="showNovoRecebimentoModal = false"
            :ativos="props.ativos"
            :tiposProventos="props.tiposProventos"
            :corretoras="props.corretoras"
        />

        <!-- Modal de Visualizar Provento -->
        <VisualizarProvento
            :show="showVisualizarProventoModal"
            :provento="proventoSelecionado"
            @close="showVisualizarProventoModal = false"
        />

        <!-- Modal de Editar Provento -->
        <EditarProvento
            :show="showEditarProventoModal"
            :provento="proventoSelecionado"
            @close="showEditarProventoModal = false"
            @submit="handleSubmitEdicao"
        />

        <!-- Modal de Excluir Provento -->
        <ExcluirProvento
            :show="showExcluirProventoModal"
            :provento="proventoSelecionado"
            @close="showExcluirProventoModal = false"
            @confirm="handleConfirmarExclusao"
        />
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
