<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { formatNumber } from '@/Utils/formatters';
import { RebalanceamentoClasse } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    show: boolean;
    classe?: RebalanceamentoClasse | null;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const closeModal = () => {
    emit('close');
};

const form = useForm({});

const confirmarExclusao = () => {
    form.delete(route('rebalanceamento-classe.delete', props.classe?.uid), {
        onSuccess: () => {
            emit('close');
        },
    });
};
</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <button @click="emit('close')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Excluir Meta de Classe
            </h2>

            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <p>
                    Tem certeza que deseja excluir a meta de rebalanceamento para a classe <strong class="text-gray-900 dark:text-gray-200">{{ classe?.classe_nome }}</strong>?
                </p>
                <p class="mt-2">
                    <span class="font-medium">Detalhes da meta:</span>
                    <br>
                    Percentual Meta/Objetivo: {{ classe?.percentual ? formatNumber(classe.percentual) + ' %' : '' }}
                </p>
                <p class="mt-3 font-medium text-red-600 dark:text-red-400">
                    Esta ação não pode ser desfeita.
                </p>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <SecondaryButton @click="emit('close')">
                    Cancelar
                </SecondaryButton>
                <DangerButton @click="confirmarExclusao">
                    Excluir
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
