<template>
    <div class="min-h-screen space-y-8 pb-12">
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-4"
        >
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">
                    Admin
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500"
                        >Profile</span
                    >
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Manage your account credentials and security.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div
                class="bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-lg relative overflow-hidden"
            >
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl"
                ></div>

                <h3
                    class="text-lg font-bold text-white mb-6 flex items-center gap-2 border-b border-slate-800 pb-4"
                >
                    <User class="w-5 h-5 text-blue-400" /> Account Details
                </h3>

                <form @submit.prevent="updateProfile" class="space-y-5">
                    <div class="space-y-1.5">
                        <label
                            class="text-xs font-semibold text-slate-400 uppercase"
                            >Full Name</label
                        >
                        <div class="relative">
                            <User
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                            />
                            <input
                                v-model="form.name"
                                type="text"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                            />
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label
                            class="text-xs font-semibold text-slate-400 uppercase"
                            >Email Address</label
                        >
                        <div class="relative">
                            <Mail
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                            />
                            <input
                                v-model="form.email"
                                type="email"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                            />
                        </div>
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            :disabled="isSubmitting"
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-blue-600/20 transition-all disabled:opacity-70 disabled:cursor-not-allowed"
                        >
                            <Save class="w-4 h-4" />
                            <span v-if="isSubmitting">Updating...</span>
                            <span v-else>Update Info</span>
                        </button>
                    </div>
                </form>
            </div>

            <div
                class="bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-lg relative overflow-hidden"
            >
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 rounded-full blur-3xl"
                ></div>

                <h3
                    class="text-lg font-bold text-white mb-6 flex items-center gap-2 border-b border-slate-800 pb-4"
                >
                    <ShieldCheck class="w-5 h-5 text-emerald-400" /> Security &
                    Password
                </h3>

                <form @submit.prevent="updatePassword" class="space-y-5">
                    <div class="space-y-1.5">
                        <label
                            class="text-xs font-semibold text-slate-400 uppercase"
                            >Current Password</label
                        >
                        <div class="relative">
                            <Lock
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                            />
                            <input
                                v-model="passForm.current_password"
                                type="password"
                                placeholder="••••••••"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-slate-200 focus:outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/50 transition-all placeholder:text-slate-600"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >New Password</label
                            >
                            <div class="relative">
                                <Key
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                                />
                                <input
                                    v-model="passForm.password"
                                    type="password"
                                    placeholder="New Password"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-slate-200 focus:outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Confirm Password</label
                            >
                            <div class="relative">
                                <Key
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                                />
                                <input
                                    v-model="passForm.password_confirmation"
                                    type="password"
                                    placeholder="Confirm Password"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-slate-200 focus:outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            :disabled="isPassSubmitting"
                            class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-emerald-600/20 transition-all disabled:opacity-70 disabled:cursor-not-allowed"
                        >
                            <Shield class="w-4 h-4" />
                            <span v-if="isPassSubmitting">Updating...</span>
                            <span v-else>Change Password</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import api from "../services/api";
import {
    User,
    Mail,
    Save,
    Lock,
    ShieldCheck,
    Key,
    Shield,
} from "lucide-vue-next";

const toast = useToast();
const isSubmitting = ref(false);
const isPassSubmitting = ref(false);

const form = ref({
    name: "",
    email: "",
});

const passForm = ref({
    current_password: "",
    password: "",
    password_confirmation: "",
});

// Load Current Profile Data
const loadProfile = async () => {
    try {
        const res = await api.get("/api/admin/profile");
        form.value.name = res.data.name;
        form.value.email = res.data.email;
    } catch (e) {
        toast.error("Failed to load profile data.");
    }
};

onMounted(loadProfile);

// Update Info (Name/Email)
const updateProfile = async () => {
    isSubmitting.value = true;
    try {
        const res = await api.put("/api/admin/profile", {
            name: form.value.name,
            email: form.value.email,
        });

        toast.success("Profile updated successfully!");
        const updatedUser = {
            name: form.value.name,
            email: form.value.email,
        };
        localStorage.setItem("admin_name", form.value.name);
        localStorage.setItem("admin_email", form.value.email);
        window.dispatchEvent(new Event("profile-updated"));
    } catch (err) {
        // ... error handling
        toast.error("Failed to update.");
    } finally {
        isSubmitting.value = false;
    }
};

// Update Password
const updatePassword = async () => {
    // Basic validation
    if (!passForm.value.current_password || !passForm.value.password) {
        toast.warning("Please fill in required password fields.");
        return;
    }
    if (passForm.value.password !== passForm.value.password_confirmation) {
        toast.error("New passwords do not match!");
        return;
    }

    isPassSubmitting.value = true;
    try {
        // Send all data, but only password fields matter here
        await api.put("/api/admin/profile", {
            name: form.value.name,
            email: form.value.email,
            current_password: passForm.value.current_password,
            password: passForm.value.password,
            password_confirmation: passForm.value.password_confirmation,
        });

        toast.success("Password changed successfully!");

        // Clear fields
        passForm.value.current_password = "";
        passForm.value.password = "";
        passForm.value.password_confirmation = "";
    } catch (err) {
        if (err.response && err.response.status === 422) {
            // Show specific error (e.g. Current password incorrect)
            const errors = err.response.data.errors;
            if (errors.current_password)
                toast.error(errors.current_password[0]);
            else if (errors.password) toast.error(errors.password[0]);
            else toast.error(err.response.data.message);
        } else {
            toast.error("Failed to update password.");
        }
    } finally {
        isPassSubmitting.value = false;
    }
};
</script>
