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
                    Manage and organize your creative work.
                </p>
            </div>

            <button
                @click="openCreateModal"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5"
            >
                <Plus class="w-5 h-5" />
                <span>Add Project</span>
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
                    class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                />
            </div>
            <div class="text-xs text-slate-500 font-medium">
                Portfolio Manager
            </div>
        </div>

        <div v-if="loading" class="space-y-4">
            <div
                v-for="n in 5"
                :key="n"
                class="bg-slate-900 border border-slate-800 rounded-2xl p-5 flex flex-col md:flex-row items-center gap-4 animate-pulse"
            >
                <div class="w-16 h-12 bg-slate-800 rounded-lg shrink-0"></div>

                <div class="flex-1 w-full space-y-2">
                    <div class="h-4 bg-slate-800 rounded w-1/4"></div>
                    <div class="h-3 bg-slate-800 rounded w-1/3"></div>
                </div>

                <div class="flex gap-2">
                    <div class="h-6 w-12 bg-slate-800 rounded"></div>
                    <div class="h-6 w-16 bg-slate-800 rounded"></div>
                </div>

                <div class="flex gap-2">
                    <div class="h-8 w-8 bg-slate-800 rounded-lg"></div>
                    <div class="h-8 w-8 bg-slate-800 rounded-lg"></div>
                </div>
            </div>
        </div>

        <div
            v-else
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
                                            :src="project.thumbnail"
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
                                        <span
                                            class="text-xs text-slate-500 bg-slate-800 px-2 py-0.5 rounded border border-slate-700/50 mt-1 inline-block"
                                            >ID: {{ project.id }}</span
                                        >
                                    </div>
                                </div>
                            </td>

                            <td class="p-5">
                                <div class="flex flex-wrap gap-1.5 max-w-xs">
                                    <span
                                        v-for="(tag, idx) in project.tech_stack
                                            ? project.tech_stack.split(',')
                                            : []"
                                        :key="idx"
                                        class="text-[10px] font-medium px-2 py-1 rounded bg-blue-500/10 text-blue-400 border border-blue-500/20"
                                    >
                                        {{ tag.trim() }}
                                    </span>
                                    <span
                                        v-if="!project.tech_stack"
                                        class="text-slate-500 text-sm"
                                        >-</span
                                    >
                                </div>
                            </td>

                            <td class="p-5">
                                <div class="flex gap-2">
                                    <a
                                        v-if="project.github_link"
                                        :href="project.github_link"
                                        target="_blank"
                                        class="p-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-slate-400 hover:text-white transition-colors"
                                        title="GitHub"
                                    >
                                        <Github class="w-4 h-4" />
                                    </a>
                                    <a
                                        v-if="project.live_link"
                                        :href="project.live_link"
                                        target="_blank"
                                        class="p-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-slate-400 hover:text-white transition-colors"
                                        title="Live Site"
                                    >
                                        <ExternalLink class="w-4 h-4" />
                                    </a>
                                </div>
                            </td>

                            <td class="p-5 text-right">
                                <div
                                    class="flex items-center justify-end gap-2"
                                >
                                    <button
                                        @click="editProject(project)"
                                        class="p-2 text-amber-400 bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/20 rounded-lg transition-colors"
                                        title="Edit"
                                    >
                                        <Edit3 class="w-4 h-4" />
                                    </button>

                                    <button
                                        @click="confirmDelete(project.id)"
                                        class="p-2 text-rose-400 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 rounded-lg transition-colors"
                                        title="Delete"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="!loading && projects.length === 0">
                            <td colspan="4" class="p-12 text-center">
                                <div
                                    class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <Layers class="w-8 h-8 text-slate-600" />
                                </div>
                                <h3 class="text-slate-300 font-medium">
                                    No projects found
                                </h3>
                                <p class="text-slate-500 text-sm mt-1">
                                    Try adding a new project or adjust your
                                    search.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                v-if="!loading"
                class="p-4 border-t border-slate-800 bg-slate-900/50 flex justify-between items-center"
            >
                <button
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                    :class="
                        !pagination.prev_page_url
                            ? 'text-slate-600 cursor-not-allowed'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    "
                    :disabled="!pagination.prev_page_url"
                    @click="loadProjects(pagination.prev_page_url)"
                >
                    <ChevronLeft class="w-4 h-4" /> Previous
                </button>

                <button
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                    :class="
                        !pagination.next_page_url
                            ? 'text-slate-600 cursor-not-allowed'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    "
                    :disabled="!pagination.next_page_url"
                    @click="loadProjects(pagination.next_page_url)"
                >
                    Next <ChevronRight class="w-4 h-4" />
                </button>
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
                            {{ editMode ? "Edit Project" : "Add New Project" }}
                        </h2>
                        <button
                            @click="closeModal"
                            class="text-slate-400 hover:text-white transition-colors"
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
                                    placeholder="e.g. E-Commerce App"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
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
                                    placeholder="e.g. e-commerce-app"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Tech Stack (Comma separated)</label
                            >
                            <input
                                v-model="form.tech_stack"
                                type="text"
                                placeholder="Vue.js, Laravel, Tailwind"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                            />
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Thumbnail URL</label
                            >
                            <div class="relative">
                                <Image
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                                />
                                <input
                                    v-model="form.thumbnail"
                                    type="text"
                                    placeholder="https://..."
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
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
                                        v-model="form.github_link"
                                        type="text"
                                        placeholder="https://github.com/..."
                                        class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                                    />
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-xs font-semibold text-slate-400 uppercase"
                                    >Live URL</label
                                >
                                <div class="relative">
                                    <ExternalLink
                                        class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                                    />
                                    <input
                                        v-model="form.live_link"
                                        type="text"
                                        placeholder="https://mysite.com"
                                        class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600"
                                    />
                                </div>
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
                                placeholder="Project details..."
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all placeholder:text-slate-600 custom-scrollbar"
                            ></textarea>
                        </div>
                    </div>

                    <div
                        class="p-6 border-t border-slate-800 bg-slate-900 flex justify-end gap-3"
                    >
                        <button
                            @click="closeModal"
                            class="px-5 py-2.5 rounded-xl font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-colors"
                        >
                            Cancel
                        </button>
                        <button
                            @click="
                                editMode ? updateProject() : createProject()
                            "
                            class="px-5 py-2.5 rounded-xl font-medium bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-600/20 transition-all"
                        >
                            {{ editMode ? "Update Changes" : "Create Project" }}
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

// Icons
import {
    Plus,
    Search,
    Edit3,
    Trash2,
    X,
    Image,
    Github,
    ExternalLink,
    ChevronLeft,
    ChevronRight,
    Layers,
} from "lucide-vue-next";

const toast = useToast();

// State
const projects = ref([]);
const pagination = ref({});
const showModal = ref(false);
const editMode = ref(false);
const search = ref("");
const loading = ref(false); // New Loading State

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

function normalizeUrl(url) {
    if (typeof url !== "string") return url;
    try {
        if (url.startsWith("http")) {
            const u = new URL(url);
            return u.pathname + u.search;
        }
    } catch (e) {
        /* ignore */
    }
    return url;
}

/* Load Projects with Loader */
const loadProjects = async (url = "/api/admin/projects") => {
    loading.value = true; // Start loading
    const finalUrl = normalizeUrl(url);
    try {
        const res = await api.get(finalUrl, {
            params: { search: search.value },
        });
        projects.value = Array.isArray(res.data)
            ? res.data
            : res.data.data || [];
        pagination.value = res.data.meta || res.data;
    } catch (err) {
        toast.error("Failed to load projects");
    } finally {
        loading.value = false; // Stop loading
    }
};

onMounted(() => loadProjects());

/* Modal Logic */
const openCreateModal = () => {
    editMode.value = false;
    showModal.value = true;
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

const closeModal = () => {
    showModal.value = false;
};

/* CRUD Actions */
const createProject = async () => {
    try {
        await api.post("/api/admin/projects", form.value);
        showModal.value = false;
        loadProjects();
        toast.success("Project created successfully!");
    } catch (err) {
        toast.error("Failed to create project");
    }
};

const editProject = (project) => {
    editMode.value = true;
    showModal.value = true;
    form.value = { ...project };
};

const updateProject = async () => {
    try {
        await api.put(`/api/admin/projects/${form.value.id}`, form.value);
        showModal.value = false;
        loadProjects();
        toast.success("Project updated successfully!");
    } catch (err) {
        toast.error("Failed to update project");
    }
};

const confirmDelete = (id) => {
    Swal.fire({
        title: "Delete Project?",
        text: "This action cannot be undone.",
        icon: "warning",
        background: "#1e293b",
        color: "#fff",
        showCancelButton: true,
        confirmButtonColor: "#ef4444",
        cancelButtonColor: "#64748b",
        confirmButtonText: "Yes, delete it!",
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                await api.delete(`/api/admin/projects/${id}`);
                loadProjects();
                toast.success("Project deleted!");
            } catch (err) {
                toast.error("Failed to delete project");
            }
        }
    });
};
</script>
