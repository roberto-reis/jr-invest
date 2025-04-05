<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    classes: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits<{
    (e: 'close'): void;
    (e: 'submit', data: any): void;
}>();

const closeModal = () => {
    emit('close');
};

const form = useForm({
    codigo: '',
    descricao: '',
    classe: '',
    setor: ''
});

const submit = () => {
    form.post(route('ativos.novo'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
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
                Novo Ativo
            </h2>

            <form @submit.prevent="submit" class="mt-6 space-y-6">
                <div>
                    <InputLabel for="codigo" value="Código do Ativo" />
                    <TextInput
                        id="codigo"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.codigo"
                        required
                        autofocus
                    />
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="descricao" value="Descrição" />
                    <TextInput
                        id="descricao"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.descricao"
                        required
                    />
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="classe" value="Classe do Ativo" />
                    <select
                        id="classe"
                        v-model="form.classe"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required
                    >
                        <option value="">Selecione uma classe</option>
                        <option v-for="classe in props.classes" :key="classe.id" :value="classe.id">
                            {{ classe.nome }}
                        </option>
                    </select>
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="setor" value="Setor" />
                    <TextInput
                        id="setor"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.setor"
                        required
                    />
                    <InputError class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton @click="emit('close')">
                        Cancelar
                    </SecondaryButton>
                    <DefaultButton>Cadastrar</DefaultButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
