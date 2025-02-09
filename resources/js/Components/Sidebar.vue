<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps<{
    isOpen: boolean;
}>();

defineEmits<{
    (e: 'close'): void;
}>();
</script>

<template>
    <!-- Sidebar -->
    <div
        :class="[
            'fixed left-0 top-0 z-40 h-screen w-64 transform transition-transform duration-300 ease-in-out',
            isOpen ? 'translate-x-0' : '-translate-x-full'
        ]"
        class="bg-white shadow-lg dark:bg-gray-800"
    >
        <div class="h-full overflow-y-auto py-4">
            <h2 class="mb-4 px-3 text-lg font-semibold text-gray-800 dark:text-white mt-1">JRinvest</h2>
            <ul class="space-y-2 border-t border-gray-100 dark:border-gray-700 px-3">
                <li class="mt-4">
                    <ResponsiveNavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                    >
                        Dashboard
                    </ResponsiveNavLink>
                </li>
                <li>
                    <ResponsiveNavLink
                        href="route('operacoes')"
                        :active="route().current('operacoes')"
                    >
                        Operações
                    </ResponsiveNavLink>
                </li>
                <li>
                    <Link
                        href="route('ativos')"
                        class="flex items-center rounded-lg p-2 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        <span>Ativos</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="route('portfolio')"
                        class="flex items-center rounded-lg p-2 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        <span>Portifólio</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="route('rebalanceamento')"
                        class="flex items-center rounded-lg p-2 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        <span>Rebalanceamento</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="route('imposto-renda')"
                        class="flex items-center rounded-lg p-2 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        <span>Imposto de Renda</span>
                    </Link>
                </li>
            </ul>
        </div>
    </div>

    <!-- Overlay para fechar o sidebar em telas menores -->
    <div
        v-if="isOpen"
        @click="$emit('close')"
        class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 transition-opacity lg:hidden"
    ></div>
</template>
