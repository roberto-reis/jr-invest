<script setup lang="ts">
import NavBar from '@/Components/NavBar.vue';
import Sidebar from '@/Components/Sidebar.vue';
import { ref } from 'vue';

const isSidebarOpen = ref(false);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <Sidebar
                :is-open="isSidebarOpen"
                @close="isSidebarOpen = false"
            />

            <NavBar @toggle-sidebar="toggleSidebar" />

            <!-- Page Heading -->
            <header
                class="bg-white shadow dark:bg-gray-800"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
/* Adicione se necessário */
</style>
