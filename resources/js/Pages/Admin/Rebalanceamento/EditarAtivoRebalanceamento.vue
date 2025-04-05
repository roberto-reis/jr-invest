<script setup lang="ts">
import { ref, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps<{
    show: boolean;
    ativo?: {
        ativo: string;
        classe: string;
        percentualMeta: string;
    } | null;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
    (e: 'submit', data: any): void;
}>();

const form = ref({
    ativo: '',
    classe: '',
    percentualMeta: '',
});

// Atualiza o formulário quando o ativo é passado para o modal
watch(() => props.ativo, (novoAtivo) => {
    if (novoAtivo) {
        form.value = {
            ativo: novoAtivo.ativo,
            classe: novoAtivo.classe,
            percentualMeta: novoAtivo.percentualMeta.replace('%', ''),
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
    <Modal :show="show" @click="emit('close')">
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
                    <select
                        id="ativo"
                        v-model="form.ativo"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required
                        disabled
                    >
                        <option value="">Selecione um ativo...</option>
                        <option value="BTC">BTC</option>
                        <option value="XYZF11">XYZF11</option>
                        <option value="ADA">ADA</option>
                        <option value="USDC">USDC</option>
                    </select>
                    <InputError class="mt-2" />
                </div>

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
