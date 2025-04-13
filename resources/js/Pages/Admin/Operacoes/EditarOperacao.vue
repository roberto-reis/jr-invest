<script setup lang="ts">
import { ref, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Operacao, Ativo, Corretora, TipoOperacao } from '@/types';
import { formatCurrency, parseCurrency } from '@/Utils/formatters';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    show: boolean;
    operacao?: Operacao | null;
    ativos: Ativo[];
    corretoras: Corretora[];
    tiposOperacoes: TipoOperacao[];
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const closeModal = () => {
    emit('close');
};

const form = useForm({
    ativo_uid: '',
    tipo_operacao_uid: '',
    corretora_uid: '',
    data_operacao: '',
    cotacao_preco: '',
    quantidade: '',
});

// Atualiza o formulário quando a operação é passada para o modal
watch(() => props.operacao, (newOperacao) => {
    if (newOperacao) {
        form.ativo_uid = newOperacao.ativo_uid || '';
        form.tipo_operacao_uid = newOperacao.tipo_operacao_uid || '';
        form.corretora_uid = newOperacao.corretora_uid || '';
        form.data_operacao = newOperacao.data_operacao || '';
        form.cotacao_preco = String(newOperacao.cotacao_preco || 0);
        form.quantidade = String(newOperacao.quantidade || 0);
    }
}, { immediate: true });


const submit = () => {
    // Converte strings para números antes de enviar
    form.put(route('operacoes.update', props.operacao?.uid), {
        preserveScroll: true,
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
                Editar Operação
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
                    <InputLabel for="tipo_operacao" value="Tipo de Operação" />
                    <select
                        id="tipo_operacao"
                        v-model="form.tipo_operacao_uid"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        required
                    >
                        <option value="">Selecione o tipo</option>
                        <option v-for="tipoOperacao in props.tiposOperacoes" :key="tipoOperacao.uid" :value="tipoOperacao.uid">
                            {{ tipoOperacao.nome }}
                        </option>
                    </select>
                    <InputError class="mt-2" v-if="form.errors.tipo_operacao_uid" :message="form.errors.tipo_operacao_uid" />
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
                        <option v-for="corretora in props.corretoras" :key="corretora.uid" :value="corretora.uid">
                            {{ corretora.nome }}
                        </option>
                    </select>
                    <InputError class="mt-2" v-if="form.errors.corretora_uid" :message="form.errors.corretora_uid" />
                </div>

                <div>
                    <InputLabel for="data_operacao" value="Data da Operação" />
                    <TextInput
                        id="data_operacao"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="form.data_operacao"
                        required
                    />
                    <InputError class="mt-2" v-if="form.errors.data_operacao" :message="form.errors.data_operacao" />
                </div>

                <div>
                    <InputLabel for="cotacao" value="Cotação" />
                    <TextInput
                        id="cotacao_preco"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.cotacao_preco"
                        required
                    />
                    <InputError class="mt-2" v-if="form.errors.cotacao_preco" :message="form.errors.cotacao_preco" />
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
                    <InputError class="mt-2" v-if="form.errors.quantidade" :message="form.errors.quantidade" />
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
