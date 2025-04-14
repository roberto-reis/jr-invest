<script setup lang="ts">
import { ref, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { RebalanceamentoAtivo, Ativo } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    show: boolean;
    ativo?: RebalanceamentoAtivo | null;
    ativos: Ativo[];
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const form = useForm({
    uid: '',
    ativo_uid: '',
    percentual: '',
});

// Atualiza o formulário quando o ativo é passado para o modal
watch(() => props.ativo, (novoAtivo) => {
    if (novoAtivo) {
        form.uid = novoAtivo.uid || '';
        form.ativo_uid = novoAtivo.ativo_uid || '';
        form.percentual = novoAtivo.percentual ? String(novoAtivo.percentual) : '';
    }
}, { immediate: true });

const closeModal = () => {
    emit('close');
};

const submit = () => {
    form.put(route('rebalanceamento-ativo.update', form.uid), {
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
                Editar Meta de Ativo
            </h2>

            <form @submit.prevent="submit" class="mt-6 space-y-6">
                <div class="flex-1">
                    <label for="ativo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ativo</label>
                    <select
                        id="ativo"
                        v-model="form.ativo_uid"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required
                    >
                        <option value="">Selecione um ativo...</option>
                        <option v-for="ativo in props.ativos" :key="ativo.uid" :value="ativo.uid">{{ ativo.codigo }}</option>
                    </select>
                    <InputError class="mt-2" v-if="form.errors.ativo_uid" :message="form.errors.ativo_uid" />
                </div>

                <div>
                    <InputLabel for="percentual" value="% Meta/Objetivo" />
                    <TextInput
                        id="percentual"
                        v-model="form.percentual"
                        class="mt-1 block w-full"
                        placeholder="Ex: 15,00"
                    />
                    <InputError class="mt-2" v-if="form.errors.percentual" :message="form.errors.percentual" />
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
