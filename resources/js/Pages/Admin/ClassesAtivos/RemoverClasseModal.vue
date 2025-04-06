<script setup>
import { useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    showModal: Boolean,
    classe: Object
});

const emit = defineEmits(['close']);

const form = useForm({});

const confirmarExclusao = () => {
    if (props.classe) {
        form.delete(route('classes-ativos.delete', props.classe.uid), {
            preserveScroll: true,
            onSuccess: () => {
                emit('close');
            },
        });
    }
};
</script>

<template>
    <div v-if="showModal && classe" class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Overlay de fundo escuro -->
        <div class="absolute inset-0 bg-black bg-opacity-50" @click="emit('close')"></div>

        <!-- Modal -->
        <div class="relative w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <button @click="emit('close')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <h2 class="text-xl font-bold mb-2 text-center text-gray-800 dark:text-white">
                Remover Classe de Ativo
            </h2>

            <p class="text-gray-600 dark:text-gray-300 text-center mb-6">
                Tem certeza que deseja remover a classe <span class="font-bold">{{ classe.nome }}</span>?
            </p>

            <p class="text-sm text-red-600 dark:text-red-400 text-center mb-6">
                Esta ação não pode ser desfeita e poderá afetar ativos relacionados a esta classe.
            </p>

            <div class="flex justify-center space-x-4">
                <SecondaryButton @click="emit('close')">
                    Cancelar
                </SecondaryButton>
                <DangerButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="confirmarExclusao">
                    Excluir
                </DangerButton>
            </div>
        </div>
    </div>
</template>
