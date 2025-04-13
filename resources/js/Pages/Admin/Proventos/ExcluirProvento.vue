<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Provento } from '@/types';
import { formatDate, formatCurrency, formatNumber } from '@/Utils/formatters';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    show: boolean;
    provento: Provento | null;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const closeModal = () => {
    emit('close');
};

const form = useForm({});

const confirmarExclusao = () => {
    if (props.provento) {
        form.delete(route('proventos.delete', props.provento.uid), {
            preserveScroll: true,
            onSuccess: () => {
                emit('close');
            },
        });
    }
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
                Excluir Provento
            </h2>

            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <p>
                    Tem certeza que deseja excluir este provento
                    do ativo <strong class="text-gray-900 dark:text-gray-200">{{ provento?.ativo_codigo }}</strong>?
                </p>
                <p class="mt-2">
                    <span class="font-medium">Detalhes do provento:</span>
                    <br>
                    Data Com: {{ formatDate(provento?.data_com ?? '') }}
                    <br>
                    Data Pagamento: {{ formatDate(provento?.data_pagamento ?? '') }}
                    <br>
                    Quantidade: {{ formatNumber(provento?.quantidade_ativo ?? 0) }}
                    <br>
                    Valor Total: {{ formatCurrency(provento?.valor_total ?? 0) }}
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
