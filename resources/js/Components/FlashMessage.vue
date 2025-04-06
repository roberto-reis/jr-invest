<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
    message: String,
    type: {
        type: String,
        default: 'success' // success, error, warning, info
    },
    duration: {
        type: Number,
        default: 6000 // 6 segundos
    },
    show: {
        type: Boolean,
        default: true
    }
});

const emit = defineEmits(['close']);

const isVisible = ref(props.show);
let timer = null;

const closeMessage = () => {
    isVisible.value = false;
    emit('close');
};

const startTimer = () => {
    if (timer) clearTimeout(timer);

    if (props.duration > 0) {
        timer = setTimeout(() => {
            closeMessage();
        }, props.duration);
    }
};

onMounted(() => {
    if (props.message) {
        startTimer();
    }
});

// Reiniciar o timer se a mensagem mudar
watch(() => props.message, (newMessage) => {
    if (newMessage) {
        isVisible.value = true;
        startTimer();
    }
});

// Limpar o timer quando o componente for destruído
onUnmounted(() => {
    if (timer) clearTimeout(timer);
});
</script>

<template>
    <transition
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-300"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="isVisible && message" class="fixed inset-x-0 top-14 z-50 flex justify-end px-4 sm:px-6 lg:px-8 pointer-events-none">
            <div
                class="pointer-events-auto max-w-md w-full shadow-lg rounded-lg overflow-hidden"
                :class="{
                    'bg-green-50 dark:bg-green-900': type === 'success',
                    'bg-red-50 dark:bg-red-900': type === 'error',
                    'bg-yellow-50 dark:bg-yellow-900': type === 'warning',
                    'bg-blue-50 dark:bg-blue-900': type === 'info'
                }"
            >
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <!-- Ícone de sucesso -->
                            <svg v-if="type === 'success'" class="h-6 w-6 text-green-400 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <!-- Ícone de erro -->
                            <svg v-else-if="type === 'error'" class="h-6 w-6 text-red-400 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <!-- Ícone de aviso -->
                            <svg v-else-if="type === 'warning'" class="h-6 w-6 text-yellow-400 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <!-- Ícone de informação -->
                            <svg v-else class="h-6 w-6 text-blue-400 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p
                                class="text-sm font-medium"
                                :class="{
                                    'text-green-800 dark:text-green-200': type === 'success',
                                    'text-red-800 dark:text-red-200': type === 'error',
                                    'text-yellow-800 dark:text-yellow-200': type === 'warning',
                                    'text-blue-800 dark:text-blue-200': type === 'info'
                                }"
                            >
                                {{ message }}
                            </p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button
                                @click="closeMessage"
                                class="inline-flex rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2"
                                :class="{
                                    'text-green-500 hover:text-green-700 focus:ring-green-500 dark:text-green-400 dark:hover:text-green-300': type === 'success',
                                    'text-red-500 hover:text-red-700 focus:ring-red-500 dark:text-red-400 dark:hover:text-red-300': type === 'error',
                                    'text-yellow-500 hover:text-yellow-700 focus:ring-yellow-500 dark:text-yellow-400 dark:hover:text-yellow-300': type === 'warning',
                                    'text-blue-500 hover:text-blue-700 focus:ring-blue-500 dark:text-blue-400 dark:hover:text-blue-300': type === 'info'
                                }"
                            >
                                <span class="sr-only">Fechar</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
