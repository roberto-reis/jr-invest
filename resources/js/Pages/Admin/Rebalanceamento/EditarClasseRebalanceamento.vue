<script setup lang="ts">
import { ref, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps<{
    show: boolean;
    classe?: {
        classe: string;
        percentualMeta: string;
    };
}>();

const emit = defineEmits<{
    (e: 'close'): void;
    (e: 'submit', data: any): void;
}>();

const form = ref({
    classe: '',
    percentualMeta: '',
});

// Atualiza o formulário quando a classe é passada para o modal
watch(() => props.classe, (novaClasse) => {
    if (novaClasse) {
        form.value = {
            classe: novaClasse.classe,
            percentualMeta: novaClasse.percentualMeta.replace('%', ''),
        };
    }
}, { immediate: true });

const closeModal = () => {
    emit('close');
};

const submit = () => {
    emit('submit', form.value);
};
</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Editar Meta de Classe
            </h2>

            <form @submit.prevent="submit" class="mt-6 space-y-6">
                <div>
                    <InputLabel for="classe" value="Classe" />
                    <select
                        id="classe"
                        v-model="form.classe"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required
                        disabled
                    >
                        <option value="">Selecione uma classe...</option>
                        <option value="ACAO">ACAO</option>
                        <option value="FII">FII</option>
                        <option value="CRIPTO">CRIPTO</option>
                        <option value="STABLECOIN">STABLECOIN</option>
                        <option value="RENDA_FIXA">RENDA FIXA</option>
                    </select>
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="percentualMeta" value="% Meta/Objetivo" />
                    <TextInput
                        id="percentualMeta"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.percentualMeta"
                        placeholder="Ex: 15,00"
                        required
                    />
                    <InputError class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        class="mr-3 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        @click="closeModal"
                    >
                        Cancelar
                    </button>
                    <PrimaryButton>Salvar</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
