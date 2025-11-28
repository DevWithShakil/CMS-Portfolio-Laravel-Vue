<template>
    <div class="min-h-screen space-y-6 pb-12">
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-4"
        >
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">
                    System
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400"
                        >Settings</span
                    >
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Configure your portfolio details and personal information.
                </p>
            </div>

            <button
                @click="updateSettings"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5"
                :disabled="isSubmitting"
            >
                <Save class="w-5 h-5" />
                <span v-if="!isSubmitting">Save Changes</span>
                <span v-else>Saving...</span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="space-y-8">
                <div
                    class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-lg text-center relative overflow-hidden group"
                >
                    <div
                        class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-blue-600/20 to-purple-600/20"
                    ></div>

                    <div class="relative z-10 mt-8">
                        <div class="relative w-36 h-36 mx-auto mb-4">
                            <div
                                class="w-full h-full rounded-full border-4 border-slate-900 overflow-hidden bg-slate-800 shadow-2xl relative group-hover:border-blue-500/50 transition-colors"
                            >
                                <img
                                    v-if="previewImage"
                                    :src="previewImage"
                                    class="w-full h-full object-cover"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center text-slate-600"
                                >
                                    <User class="w-16 h-16" />
                                </div>
                            </div>

                            <label
                                class="absolute bottom-1 right-1 p-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-full cursor-pointer shadow-lg transition-transform hover:scale-110 border-4 border-slate-900"
                            >
                                <Camera class="w-5 h-5" />
                                <input
                                    type="file"
                                    @change="handleFileChange"
                                    accept="image/*"
                                    class="hidden"
                                />
                            </label>
                        </div>

                        <h3 class="text-xl font-bold text-white">
                            {{ form.site_title || "Your Name" }}
                        </h3>
                        <p class="text-sm text-slate-400 mt-1">
                            {{ form.hero_title || "Software Engineer" }}
                        </p>
                    </div>
                </div>

                <div
                    class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-lg"
                >
                    <h3
                        class="text-lg font-bold text-white mb-4 flex items-center gap-2"
                    >
                        <FileText class="w-5 h-5 text-blue-400" /> Resume / CV
                    </h3>

                    <div class="space-y-4">
                        <div class="relative group">
                            <input
                                type="file"
                                @change="handleResumeChange"
                                accept=".pdf,.doc,.docx"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            />
                            <div
                                class="w-full border-2 border-dashed border-slate-700 hover:border-blue-500/50 rounded-xl p-8 text-center transition-colors bg-slate-950/50 group-hover:bg-slate-900"
                            >
                                <UploadCloud
                                    class="w-10 h-10 text-slate-500 mx-auto mb-3 group-hover:text-blue-400 transition-colors"
                                />
                                <p class="text-sm text-slate-300 font-medium">
                                    {{
                                        selectedResume
                                            ? selectedResume.name
                                            : "Click to upload or drag file"
                                    }}
                                </p>
                                <p class="text-xs text-slate-500 mt-1">
                                    PDF, DOC (Max 5MB)
                                </p>
                            </div>
                        </div>

                        <div
                            v-if="form.resume_file"
                            class="flex items-center justify-between bg-slate-800/50 p-3 rounded-lg border border-slate-700"
                        >
                            <div
                                class="flex items-center gap-3 overflow-hidden"
                            >
                                <div
                                    class="p-2 bg-red-500/10 text-red-400 rounded-lg"
                                >
                                    <FileText class="w-4 h-4" />
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-xs text-slate-500"
                                        >Current File</span
                                    >
                                    <a
                                        :href="getAssetUrl(form.resume_file)"
                                        target="_blank"
                                        class="text-sm text-blue-400 hover:text-blue-300 truncate hover:underline font-medium"
                                    >
                                        Download Resume
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                <div
                    class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-lg"
                >
                    <h3
                        class="text-lg font-bold text-white mb-6 flex items-center gap-2 border-b border-slate-800 pb-4"
                    >
                        <Settings class="w-5 h-5 text-cyan-400" /> General
                        Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Site Title / Name</label
                            >
                            <input
                                v-model="form.site_title"
                                type="text"
                                placeholder="e.g. Shakil Portfolio"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                            />
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Hero Title</label
                            >
                            <input
                                v-model="form.hero_title"
                                type="text"
                                placeholder="e.g. Hi, I'm Shakil"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                            />
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Hero Subtitle / Tagline</label
                            >
                            <input
                                v-model="form.hero_subtitle"
                                type="text"
                                placeholder="e.g. Building digital experiences that matter."
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                            />
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >About Description</label
                            >
                            <textarea
                                v-model="form.about"
                                rows="5"
                                placeholder="Brief bio about yourself..."
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600 custom-scrollbar leading-relaxed"
                            ></textarea>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-lg"
                >
                    <h3
                        class="text-lg font-bold text-white mb-6 flex items-center gap-2 border-b border-slate-800 pb-4"
                    >
                        <Globe class="w-5 h-5 text-purple-400" /> Social
                        Connections
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Facebook URL</label
                            >
                            <div class="relative">
                                <Facebook
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                                />
                                <input
                                    v-model="form.facebook"
                                    type="text"
                                    placeholder="https://facebook.com/..."
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >GitHub URL</label
                            >
                            <div class="relative">
                                <Github
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                                />
                                <input
                                    v-model="form.github"
                                    type="text"
                                    placeholder="https://github.com/..."
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >LinkedIn URL</label
                            >
                            <div class="relative">
                                <Linkedin
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                                />
                                <input
                                    v-model="form.linkedin"
                                    type="text"
                                    placeholder="https://linkedin.com/in/..."
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >YouTube URL</label
                            >
                            <div class="relative">
                                <Youtube
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                                />
                                <input
                                    v-model="form.youtube"
                                    type="text"
                                    placeholder="https://youtube.com/..."
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import api from "../services/api";
import {
    Save,
    Camera,
    User,
    FileText,
    UploadCloud,
    Settings,
    Globe,
    Facebook,
    Github,
    Linkedin,
    Youtube,
} from "lucide-vue-next";

const toast = useToast();
const isSubmitting = ref(false);

// State Management (Matches your DB Schema)
const form = ref({
    id: null,
    site_title: "",
    hero_title: "",
    hero_subtitle: "",
    about: "",
    profile_image: "", // String URL from DB
    resume_file: "", // String URL from DB (Fixed Name)
    facebook: "",
    youtube: "",
    github: "",
    linkedin: "",
});

// File Handling State
const previewImage = ref(null);
const selectedProfileImage = ref(null);
const selectedResume = ref(null);

// ✅ Helper: Fix Image URL
const getAssetUrl = (path) => {
    if (!path) return null;
    return path.startsWith("http") ? path : `http://127.0.0.1:8000${path}`;
};

/* -------------------------------------
   📥 Load Settings
   ------------------------------------- */
const loadSettings = async () => {
    try {
        const res = await api.get("/api/admin/settings");
        // Handle array or object response
        const data = Array.isArray(res.data)
            ? res.data[0]
            : res.data.data || res.data;

        if (data) {
            form.value = { ...data };
            // Set initial preview if exists
            previewImage.value = getAssetUrl(data.profile_image);
        }
    } catch (e) {
        toast.error("Failed to load settings");
    }
};

onMounted(loadSettings);

/* -------------------------------------
   📁 File Selection Handlers
   ------------------------------------- */
const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        selectedProfileImage.value = file;
        previewImage.value = URL.createObjectURL(file); // Show instant preview
    }
};

const handleResumeChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        selectedResume.value = file;
        toast.info(`Selected: ${file.name}`);
    }
};

/* -------------------------------------
   💾 Update Settings (FormData Logic)
   ------------------------------------- */
const updateSettings = async () => {
    isSubmitting.value = true;
    try {
        const formData = new FormData();

        // 1. Append all text fields
        Object.keys(form.value).forEach((key) => {
            // Don't append nulls or the old image strings directly
            if (
                form.value[key] !== null &&
                key !== "profile_image" &&
                key !== "resume_file"
            ) {
                formData.append(key, form.value[key]);
            }
        });

        // 2. Append Profile Image (if new one selected)
        if (selectedProfileImage.value) {
            formData.append("profile_image", selectedProfileImage.value);
        }

        // 3. Append Resume File (if new one selected)
        if (selectedResume.value) {
            formData.append("resume_file", selectedResume.value);
        }

        // 4. Method Spoofing for Laravel PUT
        formData.append("_method", "PUT");

        // 5. Send Request
        // Note: Using POST method with _method: PUT
        await api.post(`/api/admin/settings/${form.value.id}`, formData);

        toast.success("Settings updated successfully!");

        // Reset file inputs
        selectedProfileImage.value = null;
        selectedResume.value = null;

        // Reload to get fresh URLs from backend
        loadSettings();
    } catch (err) {
        console.error(err);
        toast.error("Failed to update settings. Check console.");
    } finally {
        isSubmitting.value = false;
    }
};
</script>
