<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, watch } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    showModal: Boolean,
    classe: Object
});

const emit = defineEmits(['close']);

const form = useForm({
    nome: '',
    descricao: '',
});

// Atualiza o formulário quando a classe muda
watch(() => props.classe, (newClasse) => {
    if (newClasse) {
        form.nome = newClasse.nome || '';
        form.descricao = newClasse.descricao || '';
    }
}, { immediate: true });

const submitForm = () => {
    if (props.classe) {
        form.put(route('classes-ativos.update', props.classe.uid), {
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

            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Editar Classe de Ativo</h2>

            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <InputLabel for="nome" value="Nome" />
                    <TextInput
                        id="nome"
                        type="text"
                        v-model="form.nome"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        maxlength="255"
                    />
                    <InputError :message="form.errors.nome || form.errors.nome_interno" class="mt-2" />
                </div>

                <div class="mb-4">
                    <InputLabel for="descricao" value="Descrição" />
                    <textarea
                        id="descricao"
                        v-model="form.descricao"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                        rows="3"
                        placeholder="Descreva a classe de ativo..."
                    ></textarea>
                    <InputError :message="form.errors.descricao" class="mt-2" />
                </div>

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="emit('close')">
                        Cancelar
                    </SecondaryButton>

                    <DefaultButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Salvar Alterações
                    </DefaultButton>
                </div>
            </form>
        </div>
    </div>
</template>
