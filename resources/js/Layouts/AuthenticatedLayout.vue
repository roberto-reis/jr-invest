<script setup lang="ts">
import NavBar from '@/Components/NavBar.vue';
import Sidebar from '@/Components/Sidebar.vue';
import { ref, computed, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(false);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

// Pegar as mensagens da sessão
const flash = computed(() => usePage().props.flash);
const showFlash = ref(false);
const flashMessage = ref('');
const flashType = ref('success');

// Monitorar mudanças nas mensagens flash
onMounted(() => {
    if (flash.value && flash.value.success) {
        flashMessage.value = flash.value.success;
        flashType.value = 'success';
        showFlash.value = true;
    } else if (flash.value && flash.value.error) {
        flashMessage.value = flash.value.error;
        flashType.value = 'error';
        showFlash.value = true;
    }
});

// Fechar a mensagem flash
const closeFlash = () => {
    showFlash.value = false;
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
            :show="showFlash"
            @close="closeFlash"
        />
    </div>
</template>

<style scoped>
/* Adicione se necessário */
</style>
