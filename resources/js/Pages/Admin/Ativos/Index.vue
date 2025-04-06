<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import NovoAtivo from '@/Pages/Admin/Ativos/NovoAtivo.vue';
import EditarAtivo from '@/Pages/Admin/Ativos/EditarAtivo.vue';
import VisualizarAtivo from '@/Pages/Admin/Ativos/VisualizarAtivo.vue';
import ExcluirAtivo from '@/Pages/Admin/Ativos/ExcluirAtivo.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import SearchInput from '@/Components/SearchInput.vue';

// Define interface for ativo object
interface Ativo {
    codigo: string;
    classe_ativo_uid: string;
    nome: string;
    setor: string;
    created_at: string;
    uid: string;
    classe_nome: string;
}

// Define interface for paginated data
interface PaginatedData<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
}

const currentPage = ref(1);
const perPage = ref(10);
const showNovoAtivoModal = ref(false);
const showEditarAtivoModal = ref(false);
const showVisualizarAtivoModal = ref(false);
const showExcluirAtivoModal = ref(false);
const ativoSelecionado = ref<Ativo | null>(null);
const isLoading = ref(false);

const props = defineProps({
    classes: {
        type: Array,
        default: () => []
    },
    ativos: {
        type: Object as () => PaginatedData<Ativo>,
        default: () => ({
            data: [],
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
            from: 0,
            to: 0,
            links: []
        })
    }
});

// Computed for visible page links
const pageLinks = computed(() => {
    // Get available page numbers
    const availablePages = [];
    for (let i = 1; i <= props.ativos.last_page; i++) {
        availablePages.push(i);
    }
    return availablePages;
});

// Watch for perPage changes
watch(perPage, (newValue) => {
    handlePageChange(1, newValue);
});

// Breadcrumbs data
const breadcrumbItems = [
    { label: 'Início', url: route('dashboard') },
    { label: 'Ativos' }
];

const handleEditarAtivo = (ativo: any) => {
    ativoSelecionado.value = ativo;
    showEditarAtivoModal.value = true;
};

const handleSubmitEdicao = (data: any) => {
    showEditarAtivoModal.value = false;
};

const handleVisualizarAtivo = (ativo: any) => {
    ativoSelecionado.value = ativo;
    showVisualizarAtivoModal.value = true;
};

const handleExcluirAtivo = (ativo: any) => {
    ativoSelecionado.value = ativo;
    showExcluirAtivoModal.value = true;
};

const handleConfirmarExclusao = () => {
    showExcluirAtivoModal.value = false;
};

const handlePageChange = (page: number, itemsPerPage: number = perPage.value) => {
    isLoading.value = true;
    currentPage.value = page;

    router.get(
        route('ativos.index'),
        {
            page: page,
            per_page: itemsPerPage
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ['ativos'],
            onSuccess: () => {
                isLoading.value = false;
            },
            onError: () => {
                isLoading.value = false;
            }
        }
    );
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Ativos" />
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Ativos
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
                                    @click="showNovoAtivoModal = true"
                                    class="rounded-md border border-green-600 bg-white px-4 py-2 text-green-600 hover:bg-green-50 dark:border-green-400 dark:bg-gray-700 dark:text-green-400 dark:hover:bg-gray-600"
                                >
                                    Novo Ativo
                                </button>
                                <button class="rounded-md border border-gray-600 bg-white px-4 py-2 text-gray-600 hover:bg-gray-50 dark:border-gray-400 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600">
                                    Exportar
                                </button>
                            </div>
                            <div class="flex-1 md:max-w-sm">
                                <SearchInput
                                    route="ativos.index"
                                    :only-params="['ativos']"
                                    @update:loading="(val) => isLoading = val"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card da tabela -->
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <!-- Tabela -->
                    <div class="overflow-x-auto">
                        <table v-if="props.ativos.data.length > 0" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Ativo
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Classe
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Descrição
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Setor/Segmento
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
                                <tr v-for="ativo in props.ativos.data" :key="ativo.uid">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ ativo.codigo }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ ativo.classe_nome }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ ativo.nome }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ ativo.setor }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                        {{ ativo.created_at }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <button
                                                @click="handleVisualizarAtivo(ativo)"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <button
                                                @click="handleEditarAtivo(ativo)"
                                                class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <button
                                                @click="handleExcluirAtivo(ativo)"
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
                            <p>Nenhum ativo encontrado</p>
                        </div>
                    </div>
                </div>

                <!-- Card da paginação separado -->
                <div v-if="props.ativos.data.length > 0" class="mt-6 overflow-hidden">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <select
                                v-model="perPage"
                                class="rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
                            >
                                <option :value="10">10</option>
                                <option :value="25">25</option>
                                <option :value="50">50</option>
                                <option :value="100">100</option>
                            </select>
                            <span class="ml-3 text-sm text-gray-500 dark:text-gray-400">
                                Mostrando {{ props.ativos.from }} a {{ props.ativos.to }} de {{ props.ativos.total }} registros
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                :disabled="props.ativos.current_page === 1"
                                @click="handlePageChange(props.ativos.current_page - 1)"
                                :class="[
                                    'rounded-md border px-3 py-1 text-sm',
                                    props.ativos.current_page === 1
                                        ? 'border-gray-200 bg-gray-100 text-gray-400 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-500'
                                        : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600'
                                ]"
                            >
                                Anterior
                            </button>
                            <div class="flex gap-1">
                                <button
                                    v-for="page in pageLinks"
                                    :key="page"
                                    @click="handlePageChange(page)"
                                    :class="[
                                        'px-3 py-1 text-sm rounded-md border',
                                        props.ativos.current_page === page
                                            ? 'bg-blue-600 text-white border-blue-600'
                                            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600'
                                    ]"
                                >
                                    {{ page }}
                                </button>
                            </div>
                            <button
                                :disabled="props.ativos.current_page === props.ativos.last_page"
                                @click="handlePageChange(props.ativos.current_page + 1)"
                                :class="[
                                    'rounded-md border px-3 py-1 text-sm',
                                    props.ativos.current_page === props.ativos.last_page
                                        ? 'border-gray-200 bg-gray-100 text-gray-400 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-500'
                                        : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600'
                                ]"
                            >
                                Próximo
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal de Novo Ativo -->
                <NovoAtivo
                    :show="showNovoAtivoModal"
                    @close="showNovoAtivoModal = false"
                    :classes="props.classes"
                />

                <!-- Modal de Editar Ativo -->
                <EditarAtivo
                    :show="showEditarAtivoModal"
                    :ativo="ativoSelecionado"
                    :classes="props.classes"
                    @close="showEditarAtivoModal = false"
                    @submit="handleSubmitEdicao"
                />

                <!-- Modal de Visualizar Ativo -->
                <VisualizarAtivo
                    :show="showVisualizarAtivoModal"
                    :ativo="ativoSelecionado"
                    @close="showVisualizarAtivoModal = false"
                />

                <!-- Modal de Excluir Ativo -->
                <ExcluirAtivo
                    :show="showExcluirAtivoModal"
                    :ativo="ativoSelecionado"
                    @close="showExcluirAtivoModal = false"
                    @confirm="handleConfirmarExclusao"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
