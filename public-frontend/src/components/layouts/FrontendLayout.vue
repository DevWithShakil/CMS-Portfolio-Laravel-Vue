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

        <Footer />
    </div>
</template>

<script setup>
import Navbar from "../../components/Navbar.vue";
import Footer from "../../components/Footer.vue";
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
