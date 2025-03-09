<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps<{
    show: boolean;
    ativo?: {
        ativo: string;
        classe: string;
        percentualMeta: string;
    };
}>();

const emit = defineEmits<{
    (e: 'close'): void;
    (e: 'confirm'): void;
}>();

const closeModal = () => {
    emit('close');
};

const confirmarExclusao = () => {
    emit('confirm');
};
</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Excluir Meta de Ativo
            </h2>

            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <p>
                    Tem certeza que deseja excluir a meta de rebalanceamento para o ativo <strong class="text-gray-900 dark:text-gray-200">{{ ativo?.ativo }}</strong>?
                </p>
                <p class="mt-2">
                    <span class="font-medium">Detalhes da meta:</span>
                    <br>
                    Classe: {{ ativo?.classe }}
                    <br>
                    Percentual Meta/Objetivo: {{ ativo?.percentualMeta }}
                </p>
                <p class="mt-3 font-medium text-red-600 dark:text-red-400">
                    Esta ação não pode ser desfeita.
                </p>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                    @click="closeModal"
                >
                    Cancelar
                </button>
                <DangerButton @click="confirmarExclusao">
                    Excluir
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
