<template>
    <div class="flex">
        <Sidebar />

        <div class="flex-1 ml-64">
            <Topbar />

            <div class="p-6">
                <h1 class="text-2xl font-bold mb-4">Settings</h1>

                <div class="bg-white shadow p-6 rounded">
                    <!-- Settings Form -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="font-semibold">Site Title</label>
                            <input
                                v-model="form.site_title"
                                class="input"
                                type="text"
                            />
                        </div>

                        <div>
                            <label class="font-semibold">Subtitle</label>
                            <input
                                v-model="form.subtitle"
                                class="input"
                                type="text"
                            />
                        </div>

                        <div>
                            <label class="font-semibold">Tagline</label>
                            <input
                                v-model="form.tagline"
                                class="input"
                                type="text"
                            />
                        </div>

                        <div class="col-span-2">
                            <label class="font-semibold">Description</label>
                            <textarea
                                v-model="form.description"
                                class="input"
                            ></textarea>
                        </div>

                        <div>
                            <label class="font-semibold"
                                >Profile Image (URL)</label
                            >
                            <input
                                v-model="form.profile_image"
                                class="input"
                                type="text"
                            />
                        </div>

                        <div>
                            <label class="font-semibold">Resume (URL)</label>
                            <input
                                v-model="form.resume"
                                class="input"
                                type="text"
                            />
                        </div>

                        <div>
                            <label class="font-semibold">Facebook</label>
                            <input
                                v-model="form.facebook"
                                class="input"
                                type="text"
                            />
                        </div>

                        <div>
                            <label class="font-semibold">YouTube</label>
                            <input
                                v-model="form.youtube"
                                class="input"
                                type="text"
                            />
                        </div>

                        <div>
                            <label class="font-semibold">GitHub</label>
                            <input
                                v-model="form.github"
                                class="input"
                                type="text"
                            />
                        </div>

                        <div>
                            <label class="font-semibold">LinkedIn</label>
                            <input
                                v-model="form.linkedin"
                                class="input"
                                type="text"
                            />
                        </div>
                    </div>

                    <!-- Update Button -->
                    <button
                        @click="updateSettings"
                        class="mt-5 bg-blue-600 text-white px-4 py-2 rounded"
                    >
                        Save Settings
                    </button>

                    <!-- Profile Image Preview -->
                    <div v-if="form.profile_image" class="mt-5">
                        <h3 class="font-semibold mb-1">Profile Preview</h3>
                        <img
                            :src="form.profile_image"
                            class="h-32 rounded shadow"
                        />
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

import Sidebar from "../components/Sidebar.vue";
import Topbar from "../components/Topbar.vue";

const toast = useToast();

const form = ref({
    id: null,
    site_title: "",
    subtitle: "",
    tagline: "",
    description: "",
    profile_image: "",
    facebook: "",
    youtube: "",
    github: "",
    linkedin: "",
    resume: "",
});

/* Load Settings */
const loadSettings = async () => {
    const res = await api.get("/api/admin/settings");
    const data = res.data.data ?? res.data;

    // API returns single row
    form.value = { ...data };
};

onMounted(loadSettings);

/* Update Settings */
const updateSettings = async () => {
    await api.put(`/api/admin/settings/${form.value.id}`, form.value);
    toast.success("Settings updated successfully!");
};
</script>

<style>
.input {
    @apply w-full p-2 border rounded mt-1;
}
</style>
