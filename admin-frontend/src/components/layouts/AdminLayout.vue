<template>
    <div class="flex h-screen bg-slate-50 overflow-hidden">
        <Sidebar />

        <div class="flex-1 flex flex-col ml-72 transition-all duration-300">
            <Topbar />

            <main
                class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6"
            >
                <router-view v-slot="{ Component }">
                    <transition name="fade" mode="out-in">
                        <component :is="Component" />
                    </transition>
                </router-view>
            </main>
        </div>
    </div>
</template>

<script setup>
import Sidebar from "../Sidebar.vue";
import Topbar from "../Topbar.vue";
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
