<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps<{
    show: boolean;
    operacao?: {
        ativo: string;
        operacao: string;
        categoria: string;
        quantidade: string;
        cotacao: string;
        valorTotal: string;
        corretora: string;
        data: string;
    };
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

</script>

<template>
    <Modal :show="show" @click="emit('close')">
        <div class="p-6">
            <button @click="emit('close')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Detalhes da Operação
            </h2>

            <div class="mt-6 space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Ativo
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ operacao?.ativo }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Tipo de Operação
                        </h3>
                        <p class="mt-1">
                            <span :class="{
                                'rounded-full px-2 py-1 text-xs font-medium': true,
                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': operacao?.operacao === 'Compra',
                                'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': operacao?.operacao === 'Venda'
                            }">
                                {{ operacao?.operacao }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Categoria
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ operacao?.categoria }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Quantidade
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ operacao?.quantidade }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Cotação
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ operacao?.cotacao }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Valor Total
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ operacao?.valorTotal }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Corretora
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ operacao?.corretora }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Data da Operação
                        </h3>
                        <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                            {{ operacao?.data }}
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="emit('close')">
                        Fechar
                    </SecondaryButton>
                </div>
            </div>
        </div>
    </Modal>
</template>
