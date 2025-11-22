<template>
    <div class="w-full bg-white shadow p-4 flex justify-end">
        <button
            @click="logout"
            class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600"
        >
            Logout
        </button>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router";
import api from "../services/api";
import { useToast } from "vue-toastification";

const toast = useToast();
const router = useRouter();

const logout = async () => {
    try {
        await api.post("/api/admin/logout");

        localStorage.removeItem("token");
        toast.success("Logged out successfully!");
        router.push("/");
    } catch (error) {
        toast.error("Logout failed!");
    }
};
</script>
