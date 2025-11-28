<template>
    <div class="min-h-screen space-y-6">
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-4"
        >
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">
                    Project
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400"
                        >Portfolio</span
                    >
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Manage your creative work.
                </p>
            </div>

            <button
                @click="openCreateModal"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg transition-all"
            >
                <Plus class="w-5 h-5" /> <span>Add Project</span>
            </button>
        </div>

        <div
            class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row gap-4 justify-between items-center shadow-sm"
        >
            <div class="relative w-full md:w-80 group">
                <Search
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 group-focus-within:text-blue-400 transition-colors"
                />
                <input
                    v-model="search"
                    @input="loadProjects('/api/admin/projects')"
                    type="text"
                    placeholder="Search projects..."
                    class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:border-blue-500/50 transition-all placeholder:text-slate-600"
                />
            </div>
        </div>

        <div
            class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-lg"
        >
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-950/50 border-b border-slate-800 text-xs font-semibold text-slate-400 uppercase tracking-wider"
                        >
                            <th class="p-5">Project Info</th>
                            <th class="p-5">Tech Stack</th>
                            <th class="p-5">Links</th>
                            <th class="p-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        <tr
                            v-for="project in projects"
                            :key="project.id"
                            class="group hover:bg-slate-800/40 transition-colors"
                        >
                            <td class="p-5">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-16 h-12 rounded-lg bg-slate-800 border border-slate-700 overflow-hidden shrink-0 relative"
                                    >
                                        <img
                                            v-if="project.thumbnail"
                                            :src="
                                                getThumbnailUrl(
                                                    project.thumbnail
                                                )
                                            "
                                            class="w-full h-full object-cover"
                                            alt="thumb"
                                        />
                                        <div
                                            v-else
                                            class="w-full h-full flex items-center justify-center text-slate-600"
                                        >
                                            <Image class="w-5 h-5" />
                                        </div>
                                    </div>
                                    <div>
                                        <h3
                                            class="font-bold text-slate-200 group-hover:text-white transition-colors"
                                        >
                                            {{ project.title }}
                                        </h3>
                                        <span class="text-xs text-slate-500"
                                            >ID: {{ project.id }}</span
                                        >
                                    </div>
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="flex flex-wrap gap-1.5 max-w-xs">
                                    <span
                                        class="text-[10px] font-medium px-2 py-1 rounded bg-blue-500/10 text-blue-400 border border-blue-500/20"
                                        >{{ project.tech_stack }}</span
                                    >
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="flex gap-2">
                                    <a
                                        v-if="project.github_link"
                                        :href="project.github_link"
                                        target="_blank"
                                        class="p-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-slate-400 hover:text-white"
                                        ><Github class="w-4 h-4"
                                    /></a>
                                    <a
                                        v-if="project.live_link"
                                        :href="project.live_link"
                                        target="_blank"
                                        class="p-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-slate-400 hover:text-white"
                                        ><ExternalLink class="w-4 h-4"
                                    /></a>
                                </div>
                            </td>
                            <td class="p-5 text-right">
                                <div
                                    class="flex items-center justify-end gap-2"
                                >
                                    <button
                                        @click="editProject(project)"
                                        class="p-2 text-amber-400 bg-amber-500/10 hover:bg-amber-500/20 rounded-lg"
                                    >
                                        <Edit3 class="w-4 h-4" />
                                    </button>
                                    <button
                                        @click="confirmDelete(project.id)"
                                        class="p-2 text-rose-400 bg-rose-500/10 hover:bg-rose-500/20 rounded-lg"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
            >
                <div
                    class="bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col max-h-[90vh]"
                    @click.stop
                >
                    <div
                        class="p-6 border-b border-slate-800 flex justify-between items-center bg-slate-900"
                    >
                        <h2 class="text-xl font-bold text-white">
                            {{ editMode ? "Edit Project" : "New Project" }}
                        </h2>
                        <button
                            @click="closeModal"
                            class="text-slate-400 hover:text-white"
                        >
                            <X class="w-6 h-6" />
                        </button>
                    </div>

                    <div class="p-6 overflow-y-auto custom-scrollbar space-y-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label
                                    class="text-xs font-semibold text-slate-400 uppercase"
                                    >Title</label
                                >
                                <input
                                    v-model="form.title"
                                    type="text"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50"
                                />
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-xs font-semibold text-slate-400 uppercase"
                                    >Slug</label
                                >
                                <input
                                    v-model="form.slug"
                                    type="text"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50"
                                />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Tech Stack</label
                            >
                            <input
                                v-model="form.tech_stack"
                                type="text"
                                placeholder="Vue, Laravel..."
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50"
                            />
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Thumbnail</label
                            >
                            <div
                                class="relative group w-full h-32 bg-slate-950 border border-dashed border-slate-700 rounded-xl hover:border-blue-500/50 hover:bg-slate-900 transition-all flex flex-col items-center justify-center cursor-pointer overflow-hidden"
                            >
                                <input
                                    type="file"
                                    @change="handleFileChange"
                                    accept="image/*"
                                    class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                />

                                <img
                                    v-if="previewImage"
                                    :src="previewImage"
                                    class="absolute inset-0 w-full h-full object-cover z-0"
                                />

                                <div
                                    v-else
                                    class="flex flex-col items-center justify-center text-slate-500"
                                >
                                    <UploadCloud class="w-8 h-8 mb-2" />
                                    <span class="text-xs">Upload Image</span>
                                </div>

                                <button
                                    v-if="previewImage"
                                    @click.prevent="removeImage"
                                    class="absolute top-2 right-2 p-1 bg-red-500/80 text-white rounded-full z-20"
                                >
                                    <X class="w-4 h-4" />
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label
                                    class="text-xs font-semibold text-slate-400 uppercase"
                                    >GitHub Link</label
                                >
                                <input
                                    v-model="form.github_link"
                                    type="text"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50"
                                />
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-xs font-semibold text-slate-400 uppercase"
                                    >Live Link</label
                                >
                                <input
                                    v-model="form.live_link"
                                    type="text"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50"
                                />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Description</label
                            >
                            <textarea
                                v-model="form.description"
                                rows="4"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50 custom-scrollbar"
                            ></textarea>
                        </div>
                    </div>

                    <div
                        class="p-6 border-t border-slate-800 bg-slate-900 flex justify-end gap-3"
                    >
                        <button
                            @click="closeModal"
                            class="px-5 py-2.5 rounded-xl font-medium text-slate-300 hover:text-white hover:bg-slate-800"
                        >
                            Cancel
                        </button>
                        <button
                            @click="
                                editMode ? updateProject() : createProject()
                            "
                            class="px-5 py-2.5 rounded-xl font-medium bg-blue-600 hover:bg-blue-500 text-white shadow-lg"
                            :disabled="isSubmitting"
                        >
                            <span v-if="isSubmitting">Saving...</span>
                            <span v-else>{{
                                editMode ? "Update" : "Create"
                            }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import Swal from "sweetalert2";
import api from "../services/api";
import {
    Plus,
    Search,
    Edit3,
    Trash2,
    X,
    Image,
    Github,
    ExternalLink,
    UploadCloud,
} from "lucide-vue-next";

const toast = useToast();
const projects = ref([]);
const showModal = ref(false);
const editMode = ref(false);
const search = ref("");
const isSubmitting = ref(false);

// Image States
const previewImage = ref(null);
const selectedFile = ref(null);

const form = ref({
    id: null,
    title: "",
    slug: "",
    description: "",
    tech_stack: "",
    thumbnail: "",
    github_link: "",
    live_link: "",
});

// ✅ URL Helper: Fixes broken images from backend
const getThumbnailUrl = (path) => {
    if (!path) return null;
    return path.startsWith("http") ? path : `http://127.0.0.1:8000${path}`;
};

const loadProjects = async (url = "/api/admin/projects") => {
    try {
        const res = await api.get(url, { params: { search: search.value } });
        projects.value = res.data.data;
    } catch (err) {
        toast.error("Failed to load projects");
    }
};

onMounted(() => loadProjects());

/* --- Image Handlers --- */
const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        selectedFile.value = file;
        previewImage.value = URL.createObjectURL(file);
    }
};

const removeImage = () => {
    selectedFile.value = null;
    previewImage.value = null;
};

/* --- CRUD Operations (FormData) --- */
const createProject = async () => {
    isSubmitting.value = true;
    try {
        const formData = new FormData();
        Object.keys(form.value).forEach((key) => {
            if (form.value[key] && key !== "thumbnail")
                formData.append(key, form.value[key]);
        });
        if (selectedFile.value)
            formData.append("thumbnail", selectedFile.value);

        await api.post("/api/admin/projects", formData);
        showModal.value = false;
        loadProjects();
        toast.success("Project created successfully!");
    } catch (err) {
        toast.error("Failed to create project");
    } finally {
        isSubmitting.value = false;
    }
};

const updateProject = async () => {
    isSubmitting.value = true;
    try {
        const formData = new FormData();
        Object.keys(form.value).forEach((key) => {
            if (form.value[key] && key !== "thumbnail")
                formData.append(key, form.value[key]);
        });
        if (selectedFile.value)
            formData.append("thumbnail", selectedFile.value);

        formData.append("_method", "PUT"); // Important for Laravel

        await api.post(`/api/admin/projects/${form.value.id}`, formData);
        showModal.value = false;
        loadProjects();
        toast.success("Project updated successfully!");
    } catch (err) {
        toast.error("Failed to update project");
    } finally {
        isSubmitting.value = false;
    }
};

const confirmDelete = (id) => {
    Swal.fire({
        title: "Delete?",
        icon: "warning",
        background: "#1e293b",
        color: "#fff",
        showCancelButton: true,
        confirmButtonColor: "#ef4444",
        cancelButtonColor: "#64748b",
        confirmButtonText: "Yes",
    }).then(async (result) => {
        if (result.isConfirmed) {
            await api.delete(`/api/admin/projects/${id}`);
            loadProjects();
            toast.success("Deleted!");
        }
    });
};

const openCreateModal = () => {
    editMode.value = false;
    showModal.value = true;
    selectedFile.value = null;
    previewImage.value = null;
    form.value = {
        id: null,
        title: "",
        slug: "",
        description: "",
        tech_stack: "",
        thumbnail: "",
        github_link: "",
        live_link: "",
    };
};

const editProject = (project) => {
    editMode.value = true;
    showModal.value = true;
    selectedFile.value = null;
    previewImage.value = getThumbnailUrl(project.thumbnail);
    form.value = { ...project };
};

const closeModal = () => (showModal.value = false);
</script>
