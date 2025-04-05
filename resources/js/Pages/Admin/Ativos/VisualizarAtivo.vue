<script setup lang="ts">
import { watch } from 'vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps<{
    show: boolean;
    ativo?: {
        ativo: string;
        descricao: string;
        classe: string;
        setor: string;
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
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Detalhes do Ativo
            </h2>

            <div class="mt-6 space-y-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Código do Ativo
                    </h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                        {{ ativo?.ativo }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Descrição
                    </h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                        {{ ativo?.descricao }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Classe do Ativo
                    </h3>
                    <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                        {{ ativo?.classe }}
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
                        {{ ativo?.data }}
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
