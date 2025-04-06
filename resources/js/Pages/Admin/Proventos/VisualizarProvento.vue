<script setup lang="ts">
import Modal from '@/Components/Modal.vue';

const props = defineProps<{
    show: boolean;
    provento?: {
        ativo: string;
        tipo: string;
        dataCom: string;
        dataPagamento: string;
        qtd: string;
        valor: string;
        valorTotal: string;
        yield: string;
    } | null;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const closeModal = () => {
    emit('close');
};
</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Detalhes do Provento
            </h2>

            <div class="mt-6 space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Ativo
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ provento?.ativo }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Tipo de Provento
                        </h3>
                        <p class="mt-1">
                            <span class="rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ provento?.tipo }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Data Com
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ provento?.dataCom }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Data de Pagamento
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ provento?.dataPagamento }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Quantidade
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ provento?.qtd }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Valor Unitário
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ provento?.valor }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Valor Total
                        </h3>
                        <p class="mt-1 text-base font-medium text-green-600 dark:text-green-400">
                            {{ provento?.valorTotal }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Yield On Cost
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ provento?.yield }}
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        @click="closeModal"
                    >
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </Modal>
</template>
