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
    classes: {
        type: Array,
        default: () => []
    }
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

// Filter classes based on search
const filteredClasses = computed(() => {
    if (!search.value) return props.classes;

    const searchLower = search.value.toLowerCase();
    return props.classes.filter(classe =>
        classe.nome.toLowerCase().includes(searchLower) ||
        (classe.descricao && classe.descricao.toLowerCase().includes(searchLower))
    );
});

const openNovaClasseModal = () => {
    showNovaClasseModal.value = true;
};

// Funções para o modal de remover classe
const openRemoverClasseModal = (classe) => {
    classeParaRemover.value = classe;
    showRemoverClasseModal.value = true;
};

// Funções para o modal de editar classe
const openEditarClasseModal = (classe) => {
    classeParaEditar.value = classe;
    showEditarClasseModal.value = true;
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

        <div>
            <div class="mb-6 bg-white p-4 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <GreenButton @click="openNovaClasseModal">
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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table v-if="filteredClasses.length > 0" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                    Nome
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                    Descrição
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            <tr v-for="classe in filteredClasses" :key="classe.uid">
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                    {{ classe.nome }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                    {{ classe.descricao }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    <div class="flex gap-2">
                                        <button
                                            @click="openEditarClasseModal(classe)"
                                            class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300"
                                        >
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                        <button
                                            @click="openRemoverClasseModal(classe)"
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
                    <div v-else class="p-6 text-center text-gray-500">
                        <p v-if="search">Nenhuma classe encontrada com os termos pesquisados.</p>
                        <p v-else>Nenhuma classe de ativo cadastrada.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Nova Classe -->
        <NovaClasseModal
            :show-modal="showNovaClasseModal"
            @close="showNovaClasseModal = false"
        />

        <!-- Modal de Remover Classe -->
        <RemoverClasseModal
            :show-modal="showRemoverClasseModal"
            :classe="classeParaRemover"
            @close="showRemoverClasseModal = false"
        />

        <!-- Modal de Editar Classe -->
        <EditarClasseModal
            :show-modal="showEditarClasseModal"
            :classe="classeParaEditar"
            @close="showEditarClasseModal = false"
        />

    </AuthenticatedLayout>
</template>
