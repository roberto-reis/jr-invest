<script setup lang="ts">
import { ref, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps<{
    show: boolean;
    operacao?: {
        ativo: string;
        operacao: string;
        categoria: string;
        quantidade: string;
        cotacao: string;
        valorTotal: string;
        corretora: string;
        data: string;
    };
}>();

const emit = defineEmits<{
    (e: 'close'): void;
    (e: 'submit', data: any): void;
}>();

const form = ref({
    ativo: '',
    tipo_operacao: '',
    classe: '',
    banco_corretora: '',
    data_operacao: '',
    cotacao: '',
    quantidade: '',
});

// Atualiza o formulário quando a operação é passada para o modal
watch(() => props.operacao, (newOperacao) => {
    if (newOperacao) {
        form.value = {
            ativo: newOperacao.ativo,
            tipo_operacao: newOperacao.operacao,
            classe: newOperacao.categoria,
            banco_corretora: newOperacao.corretora,
            data_operacao: formatDateToLocal(newOperacao.data),
            cotacao: newOperacao.cotacao.replace('R$ ', '').replace('.', '').replace(',', '.'),
            quantidade: newOperacao.quantidade.replace(',', '.'),
        };
    }
}, { immediate: true });

// Função auxiliar para formatar a data
const formatDateToLocal = (dateStr: string) => {
    const [date, time] = dateStr.split(' ');
    const [day, month, year] = date.split('/');
    return `${year}-${month}-${day}T${time}`;
};

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
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Editar Operação
            </h2>

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
                        <option value="BTC">BTC</option>
                        <option value="YXZK11">YXZK11</option>
                    </select>
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="tipo_operacao" value="Tipo de Operação" />
                    <select
                        id="tipo_operacao"
                        v-model="form.tipo_operacao"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required
                    >
                        <option value="">Selecione o tipo</option>
                        <option value="Compra">Compra</option>
                        <option value="Venda">Venda</option>
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
                    >
                        <option value="">Selecione uma classe</option>
                        <option value="ACAO">Ação</option>
                        <option value="FII">FII</option>
                        <option value="CRIPTO">Criptomoeda</option>
                        <option value="RENDA_FIXA">Renda Fixa</option>
                        <option value="BDR">BDR</option>
                        <option value="ETF">ETF</option>
                        <option value="STOCK">Stock</option>
                    </select>
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="banco_corretora" value="Banco/Corretora" />
                    <TextInput
                        id="banco_corretora"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.banco_corretora"
                        required
                    />
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="data_operacao" value="Data da Operação" />
                    <TextInput
                        id="data_operacao"
                        type="datetime-local"
                        class="mt-1 block w-full"
                        v-model="form.data_operacao"
                        required
                    />
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="cotacao" value="Cotação" />
                    <TextInput
                        id="cotacao"
                        type="number"
                        step="0.01"
                        class="mt-1 block w-full"
                        v-model="form.cotacao"
                        required
                    />
                    <InputError class="mt-2" />
                </div>

                <div>
                    <InputLabel for="quantidade" value="Quantidade" />
                    <TextInput
                        id="quantidade"
                        type="number"
                        step="0.00000001"
                        class="mt-1 block w-full"
                        v-model="form.quantidade"
                        required
                    />
                    <InputError class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        class="mr-3 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        @click="closeModal"
                    >
                        Cancelar
                    </button>
                    <PrimaryButton>Salvar</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
