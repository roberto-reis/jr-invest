<script setup lang="ts">
import { watch, computed } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import { Provento, Ativo, TipoProvento, Corretora } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    show: boolean;
    provento?: Provento | null;
    ativos: Ativo[];
    tiposProventos: TipoProvento[];
    corretoras: Corretora[];
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const form = useForm({
    ativo_uid: '',
    tipo_provento_uid: '',
    corretora_uid: '',
    data_com: '',
    data_pagamento: '',
    quantidade_ativo: '',
    valor: '',
});

// Atualiza o formulário quando o provento é passado para o modal
watch(() => props.provento, (newProvento) => {
    if (newProvento) {
        form.ativo_uid = newProvento.ativo_uid;
        form.tipo_provento_uid = newProvento.tipo_provento_uid;
        form.corretora_uid = newProvento.corretora_uid;
        form.data_com = newProvento.data_com;
        form.data_pagamento = newProvento.data_pagamento;
        form.quantidade_ativo = String(newProvento.quantidade_ativo);
        form.valor = String(newProvento.valor);
    }
}, { immediate: true });

const closeModal = () => {
    emit('close');
};

const submit = () => {
    form.put(route('proventos.update', props.provento?.uid), {
        preserveScroll: true,
        onSuccess: () => {
            emit('close');
        },
    });
};

// Calcula o valor total baseado na quantidade e valor unitário
const valorTotal = computed(() => {
    if (!form.quantidade_ativo || !form.valor) return 'R$ 0,00';

    const quantidade = parseFloat(form.quantidade_ativo);
    const valorUnitario = parseFloat(form.valor);

    if (isNaN(quantidade) || isNaN(valorUnitario)) return 'R$ 0,00';

    return `R$ ${(quantidade * valorUnitario).toFixed(2).replace('.', ',')}`;
});
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
                Editar Provento
            </h2>

            <form @submit.prevent="submit" class="mt-6 space-y-6">
                <div>
                    <InputLabel for="ativo" value="Ativo" />
                    <select
                        id="ativo"
                        v-model="form.ativo_uid"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required
                    >
                        <option value="">Digite para pesquisar...</option>
                        <option v-for="ativo in props.ativos" :key="ativo.uid" :value="ativo.uid">
                            {{ ativo.codigo }}
                        </option>
                    </select>
                    <InputError class="mt-2" v-if="form.errors.ativo_uid" :message="form.errors.ativo_uid" />
                </div>

                <div>
                    <InputLabel for="tipo_provento" value="Tipo de Provento" />
                    <select
                        id="tipo_provento"
                        v-model="form.tipo_provento_uid"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required
                    >
                        <option value="">Selecione o tipo</option>
                        <option v-for="tipoProvento in props.tiposProventos" :key="tipoProvento.uid" :value="tipoProvento.uid">
                            {{ tipoProvento.nome }}
                        </option>
                    </select>
                    <InputError class="mt-2" v-if="form.errors.tipo_provento_uid" :message="form.errors.tipo_provento_uid" />
                </div>

                <div>
                    <InputLabel for="corretora" value="Corretora" />
                    <select
                        id="corretora"
                        v-model="form.corretora_uid"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required
                    >
                        <option value="">Selecione a corretora</option>
                        <option v-for="corretora in corretoras" :key="corretora.uid" :value="corretora.uid">
                            {{ corretora.nome }}
                        </option>
                    </select>
                    <InputError class="mt-2" v-if="form.errors.corretora_uid" :message="form.errors.corretora_uid" />
                </div>

                <div>
                    <InputLabel for="data_com" value="Data Com" />
                    <TextInput
                        id="data_com"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="form.data_com"
                        required
                    />
                    <InputError class="mt-2" v-if="form.errors.data_com" :message="form.errors.data_com" />
                </div>

                <div>
                    <InputLabel for="data_pagamento" value="Data de Pagamento" />
                    <TextInput
                        id="data_pagamento"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="form.data_pagamento"
                        required
                    />
                    <InputError class="mt-2" v-if="form.errors.data_pagamento" :message="form.errors.data_pagamento" />
                </div>

                <div>
                    <InputLabel for="quantidade" value="Quantidade" />
                    <TextInput
                        id="quantidade"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.quantidade_ativo"
                        required
                    />
                    <InputError class="mt-2" v-if="form.errors.quantidade_ativo" :message="form.errors.quantidade_ativo" />
                </div>

                <div>
                    <InputLabel for="valor_unitario" value="Valor Unitário" />
                    <TextInput
                        id="valor_unitario"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.valor"
                        required
                    />
                    <InputError class="mt-2" v-if="form.errors.valor" :message="form.errors.valor" />
                </div>

                <div>
                    <InputLabel value="Valor Total" />
                    <div class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        {{ valorTotal }}
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        class="mr-3 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        @click="emit('close')"
                    >
                        Cancelar
                    </button>
                    <DefaultButton>Salvar</DefaultButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
