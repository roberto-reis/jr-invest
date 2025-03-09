<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

// Estado para controlar a aba ativa
const activeTab = ref('classe'); // 'classe' ou 'ativo'

// Dados de exemplo para a tabela de classes
const classesRebalanceamento = [
    { classe: 'CRIPTO', percentualMeta: '15,00%' },
    { classe: 'FII', percentualMeta: '15,00%' },
    { classe: 'STABLECOIN', percentualMeta: '15,00%' }
];

// Dados de exemplo para a tabela de ativos
const ativosRebalanceamento = [
    { ativo: 'BTC', classe: 'CRIPTO', percentualMeta: '15,00%' },
    { ativo: 'XYZF11', classe: 'FII', percentualMeta: '15,00%' },
    { ativo: 'ADA', classe: 'CRIPTO', percentualMeta: '15,00%' },
    { ativo: 'USDC', classe: 'STABLECOIN', percentualMeta: '15,00%' }
];

// Formulário para adicionar nova classe
const novaClasse = ref('');
const novoPercentualClasse = ref('');

// Formulário para adicionar novo ativo
const novoAtivo = ref('');
const novoPercentualAtivo = ref('');

// Função para incluir nova classe
const incluirClasse = () => {
    if (novaClasse.value && novoPercentualClasse.value) {
        // Aqui você implementaria a lógica para salvar no backend
        console.log('Nova classe:', {
            classe: novaClasse.value,
            percentualMeta: novoPercentualClasse.value + '%'
        });

        // Limpar formulário
        novaClasse.value = '';
        novoPercentualClasse.value = '';
    }
};

// Função para incluir novo ativo
const incluirAtivo = () => {
    if (novoAtivo.value && novoPercentualAtivo.value) {
        // Aqui você implementaria a lógica para salvar no backend
        console.log('Novo ativo:', {
            ativo: novoAtivo.value,
            percentualMeta: novoPercentualAtivo.value + '%'
        });

        // Limpar formulário
        novoAtivo.value = '';
        novoPercentualAtivo.value = '';
    }
};

// Funções para editar e excluir
const editarItem = (item) => {
    console.log('Editar item:', item);
};

const excluirItem = (item) => {
    console.log('Excluir item:', item);
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Rebalanceamento" />

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Abas -->
                <div class="mb-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="flex border-b border-gray-200 dark:border-gray-700">
                        <button
                            @click="activeTab = 'classe'"
                            :class="[
                                'px-4 py-3 text-sm font-medium',
                                activeTab === 'classe'
                                    ? 'border-b-2 border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400'
                                    : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'
                            ]"
                        >
                            Classe de Ativo
                        </button>
                        <button
                            @click="activeTab = 'ativo'"
                            :class="[
                                'px-4 py-3 text-sm font-medium',
                                activeTab === 'ativo'
                                    ? 'border-b-2 border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400'
                                    : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'
                            ]"
                        >
                            Ativo
                        </button>
                    </div>
                </div>

                <!-- Conteúdo da aba Classe de Ativo -->
                <div v-if="activeTab === 'classe'">
                    <div class="mb-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                                Selecione uma classe e percentual(%) Meta/Objetivo
                            </h2>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Classe:
                                    </label>
                                    <select
                                        v-model="novaClasse"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                    >
                                        <option value="">Selecione uma classe...</option>
                                        <option value="ACAO">ACAO</option>
                                        <option value="FII">FII</option>
                                        <option value="CRIPTO">CRIPTO</option>
                                        <option value="STABLECOIN">STABLECOIN</option>
                                        <option value="RENDA_FIXA">RENDA FIXA</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        % Meta/Objetivo:
                                    </label>
                                    <input
                                        v-model="novoPercentualClasse"
                                        type="text"
                                        placeholder="Ex: 15,00"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                    />
                                </div>

                                <div class="flex items-end">
                                    <button
                                        @click="incluirClasse"
                                        class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-700 dark:hover:bg-green-600"
                                    >
                                        Incluir
                                    </button>
                                </div>
                            </div>

                            <!-- Tabela de classes -->
                            <div class="mt-6 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                                Classe
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                                % Meta/Objetivo
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                        <tr v-for="classe in classesRebalanceamento" :key="classe.classe">
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                                {{ classe.classe }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                                {{ classe.percentualMeta }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                <div class="flex gap-2">
                                                    <button
                                                        @click="editarItem(classe)"
                                                        class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300"
                                                    >
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </button>
                                                    <button
                                                        @click="excluirItem(classe)"
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
                    </div>
                </div>

                <!-- Conteúdo da aba Ativo -->
                <div v-if="activeTab === 'ativo'">
                    <div class="mb-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                                Selecione um ativo e percentual(%) Meta/Objetivo
                            </h2>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Ativo:
                                    </label>
                                    <select
                                        v-model="novoAtivo"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                    >
                                        <option value="">Digite para pesquisar...</option>
                                        <option value="BTC">BTC</option>
                                        <option value="XYZF11">XYZF11</option>
                                        <option value="ADA">ADA</option>
                                        <option value="USDC">USDC</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        % Meta/Objetivo:
                                    </label>
                                    <input
                                        v-model="novoPercentualAtivo"
                                        type="text"
                                        placeholder="Ex: 15,00"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                    />
                                </div>

                                <div class="flex items-end">
                                    <button
                                        @click="incluirAtivo"
                                        class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-700 dark:hover:bg-green-600"
                                    >
                                        Incluir
                                    </button>
                                </div>
                            </div>

                            <!-- Tabela de ativos -->
                            <div class="mt-6 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                                Ativo
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                                Classe
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                                % Meta/Objetivo
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                        <tr v-for="ativo in ativosRebalanceamento" :key="ativo.ativo">
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                                {{ ativo.ativo }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                                {{ ativo.classe }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                                {{ ativo.percentualMeta }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                <div class="flex gap-2">
                                                    <button
                                                        @click="editarItem(ativo)"
                                                        class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300"
                                                    >
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </button>
                                                    <button
                                                        @click="excluirItem(ativo)"
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
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
