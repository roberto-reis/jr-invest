<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    show: boolean;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const closeModal = () => emit('close');

const form = useForm({
    file: null as File | null,
});

const handleFile = (e: Event) => {
    const target = e.target as HTMLInputElement;
    form.file = target.files && target.files.length ? target.files[0] : null;
};

const submit = () => {
    if (!form.file) return;

    const data = new FormData();
    data.append('file', form.file);

    // use Inertia form to post with multipart
    form.post(route('operacoes.import'), {
        preserveScroll: true,
        _method: 'post',
        body: data,
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
                Importar Operações
            </h2>

            <div class="mt-6">
                <InputLabel for="file" value="Arquivo (CSV ou XLSX)" />
                <input id="file" type="file" @change="handleFile" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300" />
                <InputError class="mt-2" v-if="form.errors.file" :message="form.errors.file" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <SecondaryButton @click="emit('close')">Cancelar</SecondaryButton>
                <DefaultButton @click="submit">Importar</DefaultButton>
            </div>
        </div>
    </Modal>
</template>
