<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import NovoAporte from './NovaOperacao.vue';
import EditarOperacao from './EditarOperacao.vue';
import VisualizarOperacao from './VisualizarOperacao.vue';
import ExcluirOperacao from './ExcluirOperacao.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';

const search = ref('');
const currentPage = ref(1);
const perPage = ref(10);

// Breadcrumbs data
const breadcrumbItems = [
    { label: 'Início', url: route('dashboard') },
    { label: 'Operações' }
];

// Dados de exemplo para a tabela
const operacoes = [
    {
        ativo: 'BTC',
        operacao: 'Compra',
        categoria: 'CRIPTO',
        quantidade: '0,00256565',
        cotacao: 'R$ 290.000,00',
        valorTotal: 'R$ 600,00',
        corretora: 'Binance',
        data: '11/12/2021 23:27'
    },
    {
        ativo: 'YXZK11',
        operacao: 'Venda',
        categoria: 'FII',
        quantidade: '20,00000000',
        cotacao: 'R$ 50,00',
        valorTotal: 'R$ 2.000,00',
        corretora: 'Clear',
        data: '11/12/2021 23:27'
    },
];

const showNovoAporteModal = ref(false);
const showEditarOperacaoModal = ref(false);
const showVisualizarOperacaoModal = ref(false);
const showExcluirOperacaoModal = ref(false);
const operacaoSelecionada = ref(null);

const handleNovoAporte = (data: any) => {
    // Aqui você implementa a lógica para salvar o novo aporte
    console.log('Novo aporte:', data);
    showNovoAporteModal.value = false;
};

const handleEditarOperacao = (operacao: any) => {
    operacaoSelecionada.value = operacao;
    showEditarOperacaoModal.value = true;
};

const handleSubmitEdicao = (data: any) => {
    // Aqui você implementa a lógica para salvar as alterações da operação
    console.log('Operação editada:', data);
    showEditarOperacaoModal.value = false;
};

const handleVisualizarOperacao = (operacao: any) => {
    // Atualiza para usar o modal
    operacaoSelecionada.value = operacao;
    showVisualizarOperacaoModal.value = true;
};

const handleExcluirOperacao = (operacao: any) => {
    operacaoSelecionada.value = operacao;
    showExcluirOperacaoModal.value = true;
};

const handleConfirmarExclusao = () => {
    // Aqui você implementa a lógica para excluir a operação
    console.log('Excluindo operação:', operacaoSelecionada.value);
    showExcluirOperacaoModal.value = false;
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Operações" />

        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Operações
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
                                    @click="showNovoAporteModal = true"
                                    class="rounded-md border border-green-600 bg-white px-4 py-2 text-green-600 hover:bg-green-50 dark:border-green-400 dark:bg-gray-700 dark:text-green-400 dark:hover:bg-gray-600"
                                >
                                    Nova Operação
                                </button>
                                <button class="rounded-md border border-gray-600 bg-white px-4 py-2 text-gray-600 hover:bg-gray-50 dark:border-gray-400 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600">
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
                </div>

                <!-- Card da tabela -->
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Ativo
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Operação
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Categoria
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Qtd.
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Cotação
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Valor Total
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Corretora
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Data
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                <tr v-for="operacao in operacoes" :key="operacao.ativo + operacao.data">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ operacao.ativo }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <span :class="{
                                            'rounded-full px-2 py-1 text-xs font-medium': true,
                                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': operacao.operacao === 'Compra',
                                            'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': operacao.operacao === 'Venda'
                                        }">
                                            {{ operacao.operacao }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ operacao.categoria }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ operacao.quantidade }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ operacao.cotacao }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ operacao.valorTotal }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ operacao.corretora }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ operacao.data }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <!-- Botão Visualizar -->
                                            <button
                                                @click="handleVisualizarOperacao(operacao)"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <!-- Botão Editar -->
                                            <button
                                                @click="handleEditarOperacao(operacao)"
                                                class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <button
                                                @click="handleExcluirOperacao(operacao)"
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
                    </div>
                </div>

                <!-- Card da paginação separado -->
                <div class="mt-6 overflow-hidden">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <select
                                v-model="perPage"
                                class="rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
                            >
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="rounded-md border border-gray-300 bg-white px-3 py-1 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                Anterior
                            </button>
                            <div class="flex gap-1">
                                <button
                                    v-for="page in 6"
                                    :key="page"
                                    :class="[
                                        'px-3 py-1 text-sm rounded-md border',
                                        currentPage === page
                                            ? 'bg-blue-600 text-white border-blue-600'
                                            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600'
                                    ]"
                                >
                                    {{ page }}
                                </button>
                            </div>
                            <button class="rounded-md border border-gray-300 bg-white px-3 py-1 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                Próximo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Novo Aporte -->
        <NovoAporte
            :show="showNovoAporteModal"
            @close="showNovoAporteModal = false"
            @submit="handleNovoAporte"
        />

        <!-- Modal de Editar Operação -->
        <EditarOperacao
            :show="showEditarOperacaoModal"
            :operacao="operacaoSelecionada"
            @close="showEditarOperacaoModal = false"
            @submit="handleSubmitEdicao"
        />

        <!-- Modal de Visualizar Operação -->
        <VisualizarOperacao
            :show="showVisualizarOperacaoModal"
            :operacao="operacaoSelecionada"
            @close="showVisualizarOperacaoModal = false"
        />

        <!-- Modal de Excluir Operação -->
        <ExcluirOperacao
            :show="showExcluirOperacaoModal"
            :operacao="operacaoSelecionada"
            @close="showExcluirOperacaoModal = false"
            @confirm="handleConfirmarExclusao"
        />
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
