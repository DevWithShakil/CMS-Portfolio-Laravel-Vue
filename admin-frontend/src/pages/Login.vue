<template>
    <div
        class="min-h-screen flex items-center justify-center bg-slate-900 relative overflow-hidden"
    >
        <div
            class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-600/20 rounded-full blur-3xl animate-pulse"
        ></div>
        <div
            class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-600/20 rounded-full blur-3xl animate-pulse delay-1000"
        ></div>

        <div
            class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl relative z-10 mx-4"
        >
            <div class="text-center mb-8">
                <div
                    class="w-12 h-12 bg-blue-600 rounded-xl mx-auto flex items-center justify-center text-white mb-4 shadow-lg shadow-blue-500/30"
                >
                    <LockKeyhole class="w-6 h-6" />
                </div>
                <h2 class="text-2xl font-bold text-slate-800">Welcome Back</h2>
                <p class="text-slate-500 text-sm mt-2">
                    Sign in to manage your portfolio.
                </p>
            </div>

            <form @submit.prevent="handleLogin" class="space-y-5">
                <div>
                    <label
                        class="block text-sm font-medium text-slate-700 mb-1.5"
                        >Email Address</label
                    >
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors"
                        >
                            <Mail class="w-5 h-5" />
                        </div>
                        <input
                            v-model="email"
                            type="email"
                            placeholder="admin@example.com"
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 placeholder:text-slate-400"
                            required
                        />
                    </div>
                </div>

                <div>
                    <label
                        class="block text-sm font-medium text-slate-700 mb-1.5"
                        >Password</label
                    >
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors"
                        >
                            <Lock class="w-5 h-5" />
                        </div>
                        <input
                            v-model="password"
                            :type="showPassword ? 'text' : 'password'"
                            placeholder="••••••••"
                            class="w-full pl-10 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 placeholder:text-slate-400"
                            required
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none"
                        >
                            <Eye v-if="!showPassword" class="w-5 h-5" />
                            <EyeOff v-else class="w-5 h-5" />
                        </button>
                    </div>
                </div>

                <button
                    type="submit"
                    :disabled="isLoading"
                    class="w-full bg-blue-600 text-white py-3 rounded-xl font-medium shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-blue-600/40 active:scale-[0.98] transition-all disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                >
                    <Loader2 v-if="isLoading" class="w-5 h-5 animate-spin" />
                    <span v-if="!isLoading">Sign In</span>
                    <span v-else>Signing in...</span>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-400">
                    Secure Admin Panel &copy; {{ new Date().getFullYear() }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import api from "../services/api";
import { Mail, Lock, LockKeyhole, Eye, EyeOff, Loader2 } from "lucide-vue-next";

const router = useRouter();
const toast = useToast();

const email = ref("");
const password = ref("");
const showPassword = ref(false);
const isLoading = ref(false);

const handleLogin = async () => {
    // Basic validation
    if (!email.value || !password.value) {
        toast.warning("Please enter both email and password.");
        return;
    }

    isLoading.value = true;

    try {
        // API Call
        const res = await api.post("/api/login", {
            email: email.value,
            password: password.value,
        });

        // Handle Response (Support different structures)
        const token = res.data.token || res.data.data?.token;
        const user = res.data.user || res.data.data?.user;

        if (token) {
            // Save Token
            localStorage.setItem("token", token);

            // Save User Info (For Sidebar/Topbar)
            if (user) {
                localStorage.setItem("admin_name", user.name);
                localStorage.setItem("admin_email", user.email);
            } else {
                // Fallback if user object isn't in immediate response
                // It's better to rely on the API response, but this prevents blank UI
                localStorage.setItem("admin_email", email.value);
            }

            toast.success("Login successful! Redirecting...", {
                timeout: 2000,
            });
            router.push("/admin/dashboard");
        } else {
            throw new Error("Token missing in response");
        }
    } catch (err) {
        console.error("Login Error:", err);
        const msg = err.response?.data?.message || "Invalid email or password.";
        toast.error(msg);
    } finally {
        isLoading.value = false;
    }
};
</script>
