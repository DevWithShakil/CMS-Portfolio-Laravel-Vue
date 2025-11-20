<template>
    <div class="flex">
        <Sidebar />
        <div class="flex-1 ml-64">
            <Topbar />
            <div class="p-6">
                <h1 class="text-3xl font-bold">Dashboard</h1>
                <p class="text-gray-600 mt-2">Welcome to your admin panel!</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import Sidebar from "../components/Sidebar.vue";
import Topbar from "../components/Topbar.vue";
</script>
