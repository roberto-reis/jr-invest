<script setup lang="ts">
import { ref, computed } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps<{
    show: boolean;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
    (e: 'submit', data: any): void;
}>();

const form = ref({
    ativo: '',
    tipo_provento: '',
    data_com: '',
    data_pagamento: '',
    quantidade: '',
    valor_unitario: '',
});

const submit = () => {
    emit('submit', form.value);
};

// Calcula o valor total baseado na quantidade e valor unitário
const valorTotal = computed(() => {
    if (!form.value.quantidade || !form.value.valor_unitario) return 'R$ 0,00';

    const quantidade = parseFloat(form.value.quantidade.replace(',', '.'));
    const valorUnitario = parseFloat(form.value.valor_unitario.replace(',', '.'));

    if (isNaN(quantidade) || isNaN(valorUnitario)) return 'R$ 0,00';

    return `R$ ${(quantidade * valorUnitario).toFixed(2).replace('.', ',')}`;
});
</script>

<template>
    <Modal :show="show" @click="emit('close')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Novo Recebimento
            </h2>
            <button @click="emit('close')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <form @submit.prevent="submit" class="mt-6 space-y-6">
                <div>
                    <InputLabel for="ativo" value="Ativo" />
                    <select
                        id="ativo"
                        v-model="form.ativo"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required
                    >
                        <option value="">Digite para pesquisar...</option>
                        <option value="URPR11">URPR11</option>
                        <option value="YXZK11">YXZK11</option>
                        <option value="AFHI11">AFHI11</option>
                        <option value="JURO11">JURO11</option>
                        <option value="MANA11">MANA11</option>
                        <option value="BTC">BTC</option>
                    </select>
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="tipo_provento" value="Tipo de Provento" />
                    <select
                        id="tipo_provento"
                        v-model="form.tipo_provento"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required
                    >
                        <option value="">Selecione o tipo</option>
                        <option value="Rendimento">Rendimento</option>
                        <option value="Dividendo">Dividendo</option>
                        <option value="JCP">JCP</option>
                        <option value="Amortização">Amortização</option>
                    </select>
                    <InputError class="mt-2" />
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
                    <InputError class="mt-2" />
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
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="quantidade" value="Quantidade" />
                    <TextInput
                        id="quantidade"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.quantidade"
                        required
                    />
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="valor_unitario" value="Valor Unitário" />
                    <TextInput
                        id="valor_unitario"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.valor_unitario"
                        required
                    />
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel value="Valor Total" />
                    <div class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        {{ valorTotal }}
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton @click="emit('close')">
                        Cancelar
                    </SecondaryButton>
                    <DefaultButton>
                        Cadastrar
                    </DefaultButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
