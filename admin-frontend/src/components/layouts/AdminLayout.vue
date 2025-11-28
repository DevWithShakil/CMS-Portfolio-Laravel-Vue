<template>
    <div
        class="flex h-screen bg-slate-950 text-slate-200 font-sans overflow-hidden selection:bg-blue-500/30"
    >
        <Sidebar
            :isOpen="isSidebarOpen"
            @toggleSidebar="toggleSidebar"
            @closeSidebar="isSidebarOpen = false"
        />

        <div
            class="flex-1 flex flex-col transition-all duration-300 ease-in-out w-full"
            :class="isSidebarOpen ? 'lg:ml-72' : 'lg:ml-20'"
        >
            <Topbar @toggleSidebar="toggleSidebar" />

            <main
                class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-950 p-4 md:p-6 scroll-smooth custom-scrollbar relative"
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
import { ref, onMounted, onUnmounted } from "vue";
import Sidebar from "../Sidebar.vue";
import Topbar from "../Topbar.vue";

const isSidebarOpen = ref(true);

const checkScreenSize = () => {
    if (window.innerWidth < 1024) {
        isSidebarOpen.value = false;
    } else {
        isSidebarOpen.value = true;
    }
};

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

onMounted(() => {
    checkScreenSize();
    window.addEventListener("resize", checkScreenSize);
});

onUnmounted(() => {
    window.removeEventListener("resize", checkScreenSize);
});
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
