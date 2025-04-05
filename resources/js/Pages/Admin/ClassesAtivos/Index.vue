<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import NovaClasseModal from './NovaClasseModal.vue';
import RemoverClasseModal from './RemoverClasseModal.vue';
import EditarClasseModal from './EditarClasseModal.vue';
import GreenButton from '@/Components/GreenButton.vue';

const props = defineProps({
    classes: Array
});

// Breadcrumbs data
const breadcrumbItems = [
    { label: 'Início', url: route('dashboard') },
    { label: 'Classes de Ativos' }
];

const search = ref('');
const showNovaClasseModal = ref(false);
const showRemoverClasseModal = ref(false);
const showEditarClasseModal = ref(false);
const classeParaRemover = ref(null);
const classeParaEditar = ref(null);

// Filtra as classes com base na busca
const filteredClasses = computed(() => {
    if (!search.value || !props.classes) return props.classes || [];

    const searchLower = search.value.toLowerCase();
    return props.classes.filter(classe =>
        classe.nome.toLowerCase().includes(searchLower) ||
        (classe.descricao && classe.descricao.toLowerCase().includes(searchLower))
    );
});

const openNovaClasseModal = () => {
    showNovaClasseModal.value = true;
};

const closeNovaClasseModal = () => {
    showNovaClasseModal.value = false;
};

// Funções para o modal de remover classe
const openRemoverClasseModal = (classe) => {
    classeParaRemover.value = classe;
    showRemoverClasseModal.value = true;
};

const closeRemoverClasseModal = () => {
    showRemoverClasseModal.value = false;
    classeParaRemover.value = null;
};

// Funções para o modal de editar classe
const openEditarClasseModal = (classe) => {
    classeParaEditar.value = classe;
    showEditarClasseModal.value = true;
};

const closeEditarClasseModal = () => {
    showEditarClasseModal.value = false;
    classeParaEditar.value = null;
};

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Classes de Ativos" />
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Classes de Ativos
                </h2>

                <Breadcrumbs :items="breadcrumbItems" />
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow-sm dark:bg-gray-800 sm:rounded-lg mb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <GreenButton  @click="openNovaClasseModal">
                                Nova Classe
                            </GreenButton>
                        </div>

                        <div class="flex-1 md:max-w-sm ml-4">
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

                <!-- Tabela de Classes de Ativos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table v-if="filteredClasses && filteredClasses.length > 0" class="min-w-full">
                            <thead class="bg-gray-50 border-b border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Nome
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Descrição
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        AÇÕES
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                <tr v-for="classe in filteredClasses" :key="classe.uid">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        <div class="flex items-center">
                                            {{ classe.nome }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                        {{ classe.descricao || 'Sem descrição' }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-center">
                                        <div class="flex justify-center space-x-3">
                                            <!-- Ícone de editar -->
                                            <button
                                                @click="openEditarClasseModal(classe)"
                                                class="text-yellow-500 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>

                                            <!-- Ícone de excluir -->
                                            <button
                                                @click="openRemoverClasseModal(classe)"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-else class="p-6 text-center text-gray-500 dark:text-gray-400">
                            <p v-if="search">Nenhuma classe encontrada com os termos pesquisados.</p>
                            <p v-else>Nenhuma classe de ativo cadastrada. Clique em "Nova Classe" para adicionar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Nova Classe -->
        <NovaClasseModal
            :show-modal="showNovaClasseModal"
            @close="closeNovaClasseModal"
        />

        <!-- Modal de Remover Classe -->
        <RemoverClasseModal
            :show-modal="showRemoverClasseModal"
            :classe="classeParaRemover"
            @close="closeRemoverClasseModal"
        />

        <!-- Modal de Editar Classe -->
        <EditarClasseModal
            :show-modal="showEditarClasseModal"
            :classe="classeParaEditar"
            @close="closeEditarClasseModal"
        />

    </AuthenticatedLayout>
</template>
