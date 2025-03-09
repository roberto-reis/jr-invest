<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import EditarClasseRebalanceamento from './EditarClasseRebalanceamento.vue';
import EditarAtivoRebalanceamento from './EditarAtivoRebalanceamento.vue';
import ExcluirClasseRebalanceamento from './ExcluirClasseRebalanceamento.vue';
import ExcluirAtivoRebalanceamento from './ExcluirAtivoRebalanceamento.vue';

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

// Estado para controlar os modais
const showEditarClasseModal = ref(false);
const classeSelecionada = ref(null);
const showEditarAtivoModal = ref(false);
const ativoSelecionado = ref(null);
const showExcluirClasseModal = ref(false);
const showExcluirAtivoModal = ref(false);

// Função para incluir nova classe
const incluirClasse = () => {
    console.log('Incluindo classe:', novaClasse.value, novoPercentualClasse.value);
    // Implementar lógica para incluir nova classe
    novaClasse.value = '';
    novoPercentualClasse.value = '';
};

// Função para incluir novo ativo
const incluirAtivo = () => {
    console.log('Incluindo ativo:', novoAtivo.value, novoPercentualAtivo.value);
    // Implementar lógica para incluir novo ativo
    novoAtivo.value = '';
    novoPercentualAtivo.value = '';
};

// Funções para editar e excluir classes
const editarClasse = (classe) => {
    classeSelecionada.value = classe;
    showEditarClasseModal.value = true;
};

const excluirClasse = (classe) => {
    classeSelecionada.value = classe;
    showExcluirClasseModal.value = true;
};

const handleSubmitEdicaoClasse = (data) => {
    showEditarClasseModal.value = false;
};

const handleConfirmarExclusaoClasse = () => {
    // Aqui você implementa a lógica para excluir a classe
    console.log('Excluindo classe:', classeSelecionada.value);
    showExcluirClasseModal.value = false;
};

// Funções para editar e excluir ativos
const editarAtivo = (ativo) => {
    ativoSelecionado.value = ativo;
    showEditarAtivoModal.value = true;
};

const excluirAtivo = (ativo) => {
    ativoSelecionado.value = ativo;
    showExcluirAtivoModal.value = true;
};

const handleSubmitEdicaoAtivo = (data) => {
    showEditarAtivoModal.value = false;
};

const handleConfirmarExclusaoAtivo = () => {
    // Aqui você implementa a lógica para excluir o ativo
    console.log('Excluindo ativo:', ativoSelecionado.value);
    showExcluirAtivoModal.value = false;
};
</script>

<template>
    <Head title="Rebalanceamento" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Rebalanceamento
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Abas -->
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                        <li class="mr-2">
                            <button
                                @click="activeTab = 'classe'"
                                class="inline-block p-4 rounded-t-lg"
                                :class="activeTab === 'classe' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'"
                            >
                                Por Classe
                            </button>
                        </li>
                        <li class="mr-2">
                            <button
                                @click="activeTab = 'ativo'"
                                class="inline-block p-4 rounded-t-lg"
                                :class="activeTab === 'ativo' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'"
                            >
                                Por Ativo
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Conteúdo da aba Por Classe -->
                <div v-if="activeTab === 'classe'">
                    <div class="bg-white p-4 shadow-sm dark:bg-gray-800 sm:rounded-lg mb-4">
                        <form @submit.prevent="incluirClasse" class="flex flex-col md:flex-row gap-4 items-end">
                            <div class="flex-1">
                                <label for="classe" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Classe</label>
                                <select
                                    id="classe"
                                    v-model="novaClasse"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                    required
                                >
                                    <option value="">Selecione uma classe...</option>
                                    <option value="ACAO">ACAO</option>
                                    <option value="FII">FII</option>
                                    <option value="CRIPTO">CRIPTO</option>
                                    <option value="STABLECOIN">STABLECOIN</option>
                                    <option value="RENDA_FIXA">RENDA FIXA</option>
                                </select>
                            </div>
                            <div class="md:w-1/4">
                                <label for="percentualMeta" class="block text-sm font-medium text-gray-700 dark:text-gray-300">% Meta/Objetivo</label>
                                <input
                                    id="percentualMeta"
                                    type="text"
                                    v-model="novoPercentualClasse"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                    placeholder="Ex: 15,00"
                                    required
                                />
                            </div>
                            <div>
                                <button
                                    type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                >
                                    Incluir
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50 border-b border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                            Classe
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                            % Meta/Objetivo
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                            Ações
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                    <tr v-for="(classe, index) in classesRebalanceamento" :key="index">
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            {{ classe.classe }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                            {{ classe.percentualMeta }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                            <button
                                                @click="editarClasse(classe)"
                                                class="mr-2 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button
                                                @click="excluirClasse(classe)"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Conteúdo da aba Por Ativo -->
                <div v-if="activeTab === 'ativo'">
                    <div class="bg-white p-4 shadow-sm dark:bg-gray-800 sm:rounded-lg mb-4">
                        <form @submit.prevent="incluirAtivo" class="flex flex-col md:flex-row gap-4 items-end">
                            <div class="flex-1">
                                <label for="ativo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ativo</label>
                                <select
                                    id="ativo"
                                    v-model="novoAtivo"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                    required
                                >
                                    <option value="">Selecione um ativo...</option>
                                    <option value="BTC">BTC</option>
                                    <option value="XYZF11">XYZF11</option>
                                    <option value="ADA">ADA</option>
                                    <option value="USDC">USDC</option>
                                </select>
                            </div>
                            <div class="md:w-1/4">
                                <label for="percentualMetaAtivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">% Meta/Objetivo</label>
                                <input
                                    id="percentualMetaAtivo"
                                    type="text"
                                    v-model="novoPercentualAtivo"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                    placeholder="Ex: 15,00"
                                    required
                                />
                            </div>
                            <div>
                                <button
                                    type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                >
                                    Incluir
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
                                            % Meta/Objetivo
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                            Ações
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                    <tr v-for="(ativo, index) in ativosRebalanceamento" :key="index">
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            {{ ativo.ativo }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                            {{ ativo.classe }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                            {{ ativo.percentualMeta }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                            <button
                                                @click="editarAtivo(ativo)"
                                                class="mr-2 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button
                                                @click="excluirAtivo(ativo)"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Editar Classe de Rebalanceamento -->
        <EditarClasseRebalanceamento
            :show="showEditarClasseModal"
            :classe="classeSelecionada"
            @close="showEditarClasseModal = false"
            @submit="handleSubmitEdicaoClasse"
        />

        <!-- Modal de Editar Ativo de Rebalanceamento -->
        <EditarAtivoRebalanceamento
            :show="showEditarAtivoModal"
            :ativo="ativoSelecionado"
            @close="showEditarAtivoModal = false"
            @submit="handleSubmitEdicaoAtivo"
        />

        <!-- Modal de Excluir Classe de Rebalanceamento -->
        <ExcluirClasseRebalanceamento
            :show="showExcluirClasseModal"
            :classe="classeSelecionada"
            @close="showExcluirClasseModal = false"
            @confirm="handleConfirmarExclusaoClasse"
        />

        <!-- Modal de Excluir Ativo de Rebalanceamento -->
        <ExcluirAtivoRebalanceamento
            :show="showExcluirAtivoModal"
            :ativo="ativoSelecionado"
            @close="showExcluirAtivoModal = false"
            @confirm="handleConfirmarExclusaoAtivo"
        />
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
