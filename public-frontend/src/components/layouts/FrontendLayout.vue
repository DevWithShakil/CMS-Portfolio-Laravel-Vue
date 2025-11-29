<template>
    <div
        class="min-h-screen flex flex-col transition-colors duration-300 ease-in-out bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-sans"
    >
        <Navbar />

        <main class="flex-grow">
            <router-view v-slot="{ Component }">
                <transition name="fade" mode="out-in">
                    <component :is="Component" />
                </transition>
            </router-view>
        </main>

        <footer
            class="border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 py-12 mt-20"
        >
            <div class="max-w-7xl mx-auto px-6 text-center">
                <p class="text-sm text-slate-500">
                    &copy; {{ new Date().getFullYear() }} All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import Navbar from "../../components/Navbar.vue"; // Import Navbar
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
