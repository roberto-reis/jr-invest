<script setup lang="ts">
import { ref } from 'vue';
import { formatCurrency, formatNumber } from '@/Utils/formatters';

const props = defineProps({
    operacoes: {
        type: Object,
        default: () => ({})
    }
});

</script>

<template>
    <div class="overflow-x-auto sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Ativo
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Operação
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Categoria
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Qtd
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Valor Total
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <tr v-for="operacao in props.operacoes" :key="operacao.uid" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ operacao.ativo_codigo }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">
                        <span :class="{
                            'rounded-full px-2 py-1 text-xs font-medium': true,
                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': operacao.tipo_operacao_nome === 'Compra',
                            'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': operacao.tipo_operacao_nome === 'Venda'
                        }">
                            {{ operacao.tipo_operacao_nome }}
                        </span>
                    </td>

                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ operacao.classe_nome }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ formatNumber(operacao.quantidade) }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ formatCurrency(operacao.valor_total) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
