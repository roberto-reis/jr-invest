<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import EditarClasseRebalanceamento from './EditarClasseRebalanceamento.vue';
import EditarAtivoRebalanceamento from './EditarAtivoRebalanceamento.vue';
import ExcluirClasseRebalanceamento from './ExcluirClasseRebalanceamento.vue';
import ExcluirAtivoRebalanceamento from './ExcluirAtivoRebalanceamento.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { ClasseAtivo, Ativo, RebalanceamentoClasse, RebalanceamentoAtivo } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { formatNumber } from '@/Utils/formatters';
import InputError from '@/Components/InputError.vue';

const props = defineProps<{
    rebalanceamentoClasses: RebalanceamentoClasse[];
    rebalanceamentoAtivos: RebalanceamentoAtivo[];
    classeAtivos: ClasseAtivo[];
    ativos: Ativo[];
}>();

// Estado para controlar a aba ativa
const activeTab = ref('classe'); // 'classe' ou 'ativo'

// Breadcrumbs data
const breadcrumbItems = [
    { label: 'Início', url: route('dashboard') },
    { label: 'Rebalanceamento' }
];

// Estado para controlar os modais
const showEditarClasseModal = ref(false);
const classeSelecionada = ref(null);
const showEditarAtivoModal = ref(false);
const ativoSelecionado = ref(null);
const showExcluirClasseModal = ref(false);
const showExcluirAtivoModal = ref(false);

// Função para incluir nova classe
const formClasse = useForm({
    classe_ativo_uid: '',
    percentual: '',
});

const formAtivo = useForm({
    ativo_uid: '',
    percentual: '',
});

const incluirClasse = () => {
    formClasse.post(route('rebalanceamento-classe.store'), {
        onSuccess: () => {
            formClasse.reset();
        }
    });
};

// Função para incluir novo ativo
const incluirAtivo = () => {
    formAtivo.post(route('rebalanceamento-ativo.store'), {
        onSuccess: () => {
            formAtivo.reset();
        }
    });
};

// Funções para editar e excluir classes
const editarClasse = (classe: any) => {
    classeSelecionada.value = classe;
    showEditarClasseModal.value = true;
};

const excluirClasse = (classe: any) => {
    classeSelecionada.value = classe;
    showExcluirClasseModal.value = true;
};

// Funções para editar e excluir ativos
const editarAtivo = (ativo: any) => {
    ativoSelecionado.value = ativo;
    showEditarAtivoModal.value = true;
};

const excluirAtivo = (ativo: any) => {
    ativoSelecionado.value = ativo;
    showExcluirAtivoModal.value = true;
};

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
            <!-- Abas -->
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center dark:text-gray-300">
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
                                v-model="formClasse.classe_ativo_uid"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                required
                            >
                                <option value="">Selecione uma classe...</option>
                                <option v-for="classe in props.classeAtivos" :key="classe.uid" :value="classe.uid">{{ classe.nome }}</option>
                            </select>
                            <InputError class="mt-2" v-if="formClasse.errors.classe_ativo_uid" :message="formClasse.errors.classe_ativo_uid" />
                        </div>
                        <div class="md:w-1/4">
                            <label for="percentualMeta" class="block text-sm font-medium text-gray-700 dark:text-gray-300">% Meta/Objetivo</label>
                            <input
                                id="percentualMeta"
                                type="text"
                                v-model="formClasse.percentual"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                placeholder="Ex: 15,00"
                                required
                            />
                            <InputError class="mt-2" v-if="formClasse.errors.percentual" :message="formClasse.errors.percentual" />
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

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table v-if="rebalanceamentoClasses.length > 0" class="min-w-full">
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
                                <tr v-for="classe in props.rebalanceamentoClasses" :key="classe.uid">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        {{ classe.classe_nome }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                        {{ formatNumber(classe.percentual) }} %
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                        <div class="flex space-x-2">
                                            <button
                                                @click="editarClasse(classe)"
                                                class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <button
                                                @click="excluirClasse(classe)"
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
                        <div v-else class="flex justify-center items-center h-full p-4">
                            <p class="text-gray-500 dark:text-gray-300">Nenhuma classe de rebalanceamento definida</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conteúdo da aba Por Ativo -->
            <div v-if="activeTab === 'ativo'">
                <div class="bg-white  p-4 shadow-sm dark:bg-gray-800 sm:rounded-lg mb-4">
                    <form @submit.prevent="incluirAtivo" class="flex flex-col md:flex-row gap-4 items-end">
                        <div class="flex-1">
                            <label for="ativo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ativo</label>
                            <select
                                id="ativo"
                                v-model="formAtivo.ativo_uid"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                required
                            >
                                <option value="">Selecione um ativo...</option>
                                <option v-for="ativo in props.ativos" :key="ativo.uid" :value="ativo.uid">{{ ativo.codigo }}</option>
                            </select>
                            <InputError class="mt-2" v-if="formAtivo.errors.ativo_uid" :message="formAtivo.errors.ativo_uid" />
                        </div>
                        <div class="md:w-1/4">
                            <label for="percentualMetaAtivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">% Meta/Objetivo</label>
                            <input
                                id="percentualMetaAtivo"
                                type="text"
                                v-model="formAtivo.percentual"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                placeholder="Ex: 15,00"
                                required
                            />
                            <InputError class="mt-2" v-if="formAtivo.errors.percentual" :message="formAtivo.errors.percentual" />
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

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table v-if="rebalanceamentoAtivos.length > 0" class="min-w-full">
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
                                <tr v-for="ativo in props.rebalanceamentoAtivos" :key="ativo.uid">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        {{ ativo.ativo_codigo }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                        {{ ativo.classe_nome }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                        {{ formatNumber(ativo.percentual) }} %
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                        <div class="flex space-x-2">
                                            <button
                                                @click="editarAtivo(ativo)"
                                                class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <button
                                                @click="excluirAtivo(ativo)"
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
                        <div v-else class="flex justify-center items-center h-full p-4">
                            <p class="text-gray-500 dark:text-gray-300">Nenhum ativo de rebalanceamento definido</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Editar Classe de Rebalanceamento -->
        <EditarClasseRebalanceamento
            :show="showEditarClasseModal"
            :classe="classeSelecionada"
            :classeAtivos="props.classeAtivos"
            @close="showEditarClasseModal = false"
        />

        <!-- Modal de Editar Ativo de Rebalanceamento -->
        <EditarAtivoRebalanceamento
            :show="showEditarAtivoModal"
            :ativo="ativoSelecionado"
            :ativos="props.ativos"
            @close="showEditarAtivoModal = false"
        />

        <!-- Modal de Excluir Classe de Rebalanceamento -->
        <ExcluirClasseRebalanceamento
            :show="showExcluirClasseModal"
            :classe="classeSelecionada"
            @close="showExcluirClasseModal = false"
        />

        <!-- Modal de Excluir Ativo de Rebalanceamento -->
        <ExcluirAtivoRebalanceamento
            :show="showExcluirAtivoModal"
            :ativo="ativoSelecionado"
            @close="showExcluirAtivoModal = false"
        />
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
