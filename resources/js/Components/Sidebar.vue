<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { ref, onMounted } from 'vue';
import { initTheme } from '@/dark-mode';

defineProps<{
    isOpen: boolean;
}>();

defineEmits<{
    (e: 'close'): void;
}>();

const isDark = ref(false);

onMounted(() => {
    isDark.value = initTheme();
});

const toggleDarkMode = () => {
    isDark.value = !isDark.value;
    if (isDark.value) {
        document.documentElement.classList.add('dark');
        localStorage.theme = 'dark';
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.theme = 'light';
    }
};
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
            <!-- Header com título e botão de fechar -->
            <div class="mb-4 px-3 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">JRinvest</h2>
                <button
                    @click="$emit('close')"
                    class="p-1 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 rounded-lg"
                >
                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            <!-- Dark Mode Switch -->
            <div class="px-3 mb-4 flex items-center justify-between border-t border-b border-gray-100 dark:border-gray-700 py-3">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Modo Escuro</span>
                <button
                    @click="toggleDarkMode"
                    class="relative inline-flex h-6 w-11 items-center rounded-full"
                    :class="isDark ? 'bg-indigo-600' : 'bg-gray-200'"
                >
                    <span class="sr-only">Alternar tema</span>
                    <span
                        class="inline-block h-4 w-4 transform rounded-full bg-white transition"
                        :class="isDark ? 'translate-x-6' : 'translate-x-1'"
                    ></span>
                </button>
            </div>

            <ul class="space-y-2 px-3">
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
