<template>
    <div
        class="flex h-screen bg-slate-950 text-slate-200 font-sans overflow-hidden selection:bg-blue-500/30"
    >
        <Sidebar :isOpen="isSidebarOpen" @toggleSidebar="toggleSidebar" />

        <div
            class="flex-1 flex flex-col transition-all duration-300 ease-in-out"
            :class="isSidebarOpen ? 'ml-72' : 'ml-20'"
        >
            <Topbar />

            <main
                class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-950 p-6 scroll-smooth custom-scrollbar"
            >
                <router-view v-slot="{ Component }">
                    <transition
                        enter-active-class="transition ease-out duration-300"
                        enter-from-class="transform opacity-0 translate-y-2"
                        enter-to-class="transform opacity-100 translate-y-0"
                        leave-active-class="transition ease-in duration-200"
                        leave-from-class="transform opacity-100 translate-y-0"
                        leave-to-class="transform opacity-0 translate-y-2"
                    >
                        <component :is="Component" />
                    </transition>
                </router-view>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Sidebar from "../Sidebar.vue";
import Topbar from "../Topbar.vue";

// সাইডবার ডিফল্টভাবে ওপেন থাকবে
const isSidebarOpen = ref(true);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};
</script>

<style>
/* Global Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #0f172a;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #334155;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #475569;
}
</style>
