<script setup lang="ts">
import { watch } from 'vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps<{
    show: boolean;
    ativo?: {
        codigo: string;
        nome: string;
        classe_nome: string;
        setor: string;
        created_at: string;
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
                Detalhes do Ativo
            </h2>

            <div class="mt-6 space-y-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Código do Ativo
                    </h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                        {{ ativo?.codigo }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Descrição
                    </h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                        {{ ativo?.nome }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Classe do Ativo
                    </h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                        {{ ativo?.classe_nome }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Setor
                    </h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                        {{ ativo?.setor }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Data de Cadastro
                    </h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                        {{ ativo?.created_at }}
                    </p>
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        @click="emit('close')"
                    >
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </Modal>
</template>
