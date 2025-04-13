<script setup lang="ts">
import { ref, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Operacao } from '@/types';

const props = defineProps<{
    show: boolean;
    operacao?: Operacao | null;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
    (e: 'submit', data: any): void;
}>();

const closeModal = () => {
    emit('close');
};

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
            ativo: newOperacao.ativo_codigo || '',
            tipo_operacao: newOperacao.tipo_operacao_nome || '',
            classe: newOperacao.classe_nome || '',
            banco_corretora: newOperacao.corretora_nome || '',
            data_operacao: formatDateToLocal(newOperacao.data_operacao || ''),
            cotacao: String(newOperacao.cotacao_preco || 0),
            quantidade: String(newOperacao.quantidade || 0),
        };
    }
}, { immediate: true });

// Função auxiliar para formatar a data
const formatDateToLocal = (dateStr: string) => {
    if (!dateStr) return '';

    try {
        // Check if the date is already in ISO format
        if (dateStr.includes('-') && !dateStr.includes('/')) {
            return dateStr; // Already in the right format
        }

        // Handle 'DD/MM/YYYY HH:mm:ss' format
        if (dateStr.includes('/')) {
            const parts = dateStr.split(' ');
            const datePart = parts[0];
            const timePart = parts.length > 1 ? parts[1] : '';

            const [day, month, year] = datePart.split('/');
            return timePart
                ? `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}T${timePart}`
                : `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
        }

        // If it's in another format, just return it
        return dateStr;
    } catch (error) {
        console.error('Error formatting date:', error, dateStr);
        return '';
    }
};

const submit = () => {
    emit('submit', form.value);
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

                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton @click="emit('close')">
                        Cancelar
                    </SecondaryButton>
                    <DefaultButton>
                        Salvar
                    </DefaultButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
