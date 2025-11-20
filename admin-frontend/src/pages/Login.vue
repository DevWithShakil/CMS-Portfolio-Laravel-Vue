<template>
    <div class="h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-bold text-center mb-6">Admin Login</h2>

            <input
                v-model="email"
                type="email"
                placeholder="Email"
                class="w-full p-3 mb-4 border rounded"
            />

            <input
                v-model="password"
                type="password"
                placeholder="Password"
                class="w-full p-3 mb-4 border rounded"
            />

            <button
                @click="login"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700"
            >
                Login
            </button>

            <p class="text-red-500 mt-3 text-center">{{ error }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import api from "../services/api";
import { useRouter } from "vue-router";

const email = ref("");
const password = ref("");
const error = ref("");
const router = useRouter();

const login = async () => {
    if (!email.value || !password.value) {
        error.value = "Please enter email and password.";
        return;
    }

    try {
        const res = await api.post("/login", {
            email: email.value,
            password: password.value,
        });

        // Save token
        localStorage.setItem("token", res.data.data.token);

        router.push("/dashboard");
    } catch (err) {
        error.value = "Invalid email or password!";
    }
};
</script>
