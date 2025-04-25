<script setup lang="ts">
import { ref } from 'vue';
import { formatCurrency, formatNumber } from '@/Utils/formatters';

// Definindo o tipo para as operações
interface Operacao {
    id: number;
    ativo: string;
    operacao: string;
    categoria: string;
    quantidade: number;
    valorUnitario: number;
    valorTotal: number;
    data: string;
}

// Dados de exemplo para as últimas operações
const operacoes = ref<Operacao[]>([
    {
        id: 1,
        ativo: 'PETR4',
        operacao: 'Compra',
        categoria: 'Ações',
        quantidade: 100,
        valorUnitario: 28.50,
        valorTotal: 2850.00,
        data: '2023-06-15'
    },
    {
        id: 2,
        ativo: 'HGLG11',
        operacao: 'Compra',
        categoria: 'FIIs',
        quantidade: 20,
        valorUnitario: 175.30,
        valorTotal: 3506.00,
        data: '2023-06-10'
    },
    {
        id: 3,
        ativo: 'VALE3',
        operacao: 'Venda',
        categoria: 'Ações',
        quantidade: 50,
        valorUnitario: 68.75,
        valorTotal: 3437.50,
        data: '2023-06-05'
    },
    {
        id: 4,
        ativo: 'XPLG11',
        operacao: 'Compra',
        categoria: 'FIIs',
        quantidade: 30,
        valorUnitario: 102.45,
        valorTotal: 3073.50,
        data: '2023-05-28'
    },
    {
        id: 5,
        ativo: 'ITSA4',
        operacao: 'Compra',
        categoria: 'Ações',
        quantidade: 200,
        valorUnitario: 9.80,
        valorTotal: 1960.00,
        data: '2023-05-20'
    },
    {
        id: 6,
        ativo: 'MXRF11',
        operacao: 'Compra',
        categoria: 'FIIs',
        quantidade: 250,
        valorUnitario: 10.15,
        valorTotal: 2537.50,
        data: '2023-05-15'
    },
    {
        id: 7,
        ativo: 'BBAS3',
        operacao: 'Venda',
        categoria: 'Ações',
        quantidade: 80,
        valorUnitario: 45.20,
        valorTotal: 3616.00,
        data: '2023-05-10'
    },
    {
        id: 8,
        ativo: 'HGRU11',
        operacao: 'Compra',
        categoria: 'FIIs',
        quantidade: 15,
        valorUnitario: 138.90,
        valorTotal: 2083.50,
        data: '2023-05-05'
    }
]);

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
                <tr v-for="operacao in operacoes" :key="operacao.id" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ operacao.ativo }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">
                        <span :class="{
                            'rounded-full px-2 py-1 text-xs font-medium': true,
                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': operacao.operacao === 'Compra',
                            'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': operacao.operacao === 'Venda'
                        }">
                            {{ operacao.operacao }}
                        </span>
                    </td>

                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ operacao.categoria }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ formatNumber(operacao.quantidade) }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ formatCurrency(operacao.valorTotal) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
