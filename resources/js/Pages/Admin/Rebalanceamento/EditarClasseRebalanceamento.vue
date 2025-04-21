<script setup lang="ts">
import { ref, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { formatNumber } from '@/Utils/formatters';
import { RebalanceamentoClasse, ClasseAtivo } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    show: boolean;
    classe?: RebalanceamentoClasse | null;
    classeAtivos: ClasseAtivo[];
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const closeModal = () => {
    emit('close');
};

const form = useForm({
    uid: '',
    classe_ativo_uid: '',
    percentual: '',
});

// Atualiza o formulário quando a classe é passada para o modal
watch(() => props.classe, (novaClasse) => {
    if (novaClasse) {
        form.uid = novaClasse.uid || '';
        form.classe_ativo_uid = novaClasse.classe_ativo_uid || '';
        form.percentual = novaClasse.percentual ? String(novaClasse.percentual) : '';
    }
}, { immediate: true });

const submit = () => {
    form.put(route('rebalanceamento-classe.update', form.uid), {
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
                Editar Meta de Classe
            </h2>

            <form @submit.prevent="submit" class="mt-6 space-y-6">
                <div class="flex-1">
                    <label for="classe" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Classe</label>
                    <select
                        id="classe"
                        v-model="form.classe_ativo_uid"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required
                    >
                        <option value="">Selecione uma classe...</option>
                        <option v-for="classe in props.classeAtivos" :key="classe.uid" :value="classe.uid">{{ classe.nome }}</option>
                    </select>
                    <InputError class="mt-2" v-if="form.errors.classe_ativo_uid" :message="form.errors.classe_ativo_uid" />
                </div>

                <div>
                    <InputLabel for="percentual" value="% Meta/Objetivo" />
                    <TextInput
                        id="percentual"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.percentual"
                        placeholder="Ex: 15,00"
                        required
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
