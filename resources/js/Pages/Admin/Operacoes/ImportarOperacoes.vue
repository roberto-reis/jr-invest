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
                <InputLabel for="file" value="Arquivo (XLSX ou XLS)" />
                <input
                    id="file"
                    type="file"
                    @change="handleFile"
                    required
                    accept=".xlsx,.xls,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"
                    class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300"
                    :disabled="form.processing"
                />
                <InputError class="mt-2" v-if="form.errors.file" :message="form.errors.file" />
            </div>

            <!-- Loading Overlay -->
            <div v-if="form.processing" class="mt-4 flex items-center justify-center gap-3 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <svg class="animate-spin h-5 w-5 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-sm text-gray-600 dark:text-gray-300">Importando operações...</span>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <SecondaryButton @click="emit('close')" :disabled="form.processing">Cancelar</SecondaryButton>
                <DefaultButton @click="submit" :disabled="form.processing || !form.file">
                    <span v-if="form.processing" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Importando...
                    </span>
                    <span v-else>Importar</span>
                </DefaultButton>
            </div>
        </div>
    </Modal>
</template>
