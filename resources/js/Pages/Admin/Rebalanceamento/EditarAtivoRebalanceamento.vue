<script setup lang="ts">
import { ref, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { formatNumber } from '@/Utils/formatters';

const props = defineProps<{
    show: boolean;
    ativo?: {
        uid?: string;
        ativo_codigo?: string;
        classe_nome?: string;
        percentual?: number;
        ativo_uid?: string;
    } | null;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
    (e: 'submit', data: any): void;
}>();

const form = ref({
    uid: '',
    ativo: '',
    classe: '',
    percentualMeta: '',
});

// Atualiza o formulário quando o ativo é passado para o modal
watch(() => props.ativo, (novoAtivo) => {
    if (novoAtivo) {
        form.value = {
            uid: novoAtivo.uid || '',
            ativo: novoAtivo.ativo_codigo || '',
            classe: novoAtivo.classe_nome || '',
            percentualMeta: novoAtivo.percentual ? String(novoAtivo.percentual) : '',
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
            <button @click="emit('close')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Editar Meta de Ativo
            </h2>

            <form @submit.prevent="submit" class="mt-6 space-y-6">
                <div>
                    <InputLabel for="ativo" value="Ativo" />
                    <TextInput
                        id="ativo"
                        v-model="form.ativo"
                        class="mt-1 block w-full"
                        disabled
                    />
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="classe" value="Classe" />
                    <TextInput
                        id="classe"
                        v-model="form.classe"
                        class="mt-1 block w-full"
                        disabled
                    />
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

                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton @click="emit('close')">
                        Cancelar
                    </SecondaryButton>
                    <DefaultButton>Salvar</DefaultButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
