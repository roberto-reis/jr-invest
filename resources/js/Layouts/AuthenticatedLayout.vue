<script setup lang="ts">
import NavBar from '@/Components/NavBar.vue';
import Sidebar from '@/Components/Sidebar.vue';
import { ref, watch, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(false);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

// Flash message state
const flashMessage = ref('');
const showFlashMessage = ref(false);
const flashType = ref('success');

// Acessar as mensagens flash usando o hook usePage
const page = usePage();

// Monitorar mudanças nas mensagens flash
onMounted(() => {
    checkFlashMessages();
});

// Observar mudanças nas props de flash para atualizar mensagens
watch(() => page.props.flash, () => {
    checkFlashMessages();
}, { deep: true });

function checkFlashMessages() {
    // Verificar de várias formas para garantir que encontraremos a mensagem
    const flash = page.props.flash || {};

    if (flash.success) {
        flashMessage.value = flash.success;
        flashType.value = 'success';
        showFlashMessage.value = true;
    }
    else if (flash.error) {
        flashMessage.value = flash.error;
        flashType.value = 'error';
        showFlashMessage.value = true;
    }
    else if (flash.warning) {
        flashMessage.value = flash.warning;
        flashType.value = 'warning';
        showFlashMessage.value = true;
    }
    else if (flash.info) {
        flashMessage.value = flash.info;
        flashType.value = 'info';
        showFlashMessage.value = true;
    }
}

// Fechar a mensagem flash
const closeFlash = () => {
    showFlashMessage.value = false;
    flashMessage.value = '';
};
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <Sidebar
                :is-open="sidebarOpen"
                @close="sidebarOpen = false"
                @update:is-open="sidebarOpen = $event"
            />

            <NavBar @toggle-sidebar="toggleSidebar" />

            <!-- Page Heading -->
            <header
                class="bg-white shadow dark:bg-gray-800"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>

        <!-- Flash Message -->
        <FlashMessage
            :message="flashMessage"
            :type="flashType"
            :show="showFlashMessage"
            @close="closeFlash"
        />
    </div>
</template>

<style scoped>
/* Adicione se necessário */
</style>
