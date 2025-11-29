<template>
    <div class="pt-32 pb-20 min-h-screen">
        <div
            class="max-w-7xl mx-auto px-6 mb-16 text-center"
            data-aos="fade-down"
        >
            <h1
                class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-4"
            >
                All
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-500"
                    >Projects</span
                >
            </h1>
            <p class="text-slate-600 dark:text-slate-400 max-w-xl mx-auto">
                A complete collection of my works, side projects, and
                experiments.
            </p>
        </div>

        <div
            v-if="isLoading"
            class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
        >
            <div
                v-for="n in 6"
                :key="n"
                class="h-96 bg-slate-200 dark:bg-slate-800 rounded-2xl animate-pulse"
            ></div>
        </div>

        <div v-else class="max-w-7xl mx-auto px-6">
            <div v-if="projects.length === 0" class="text-center py-20">
                <div
                    class="inline-block p-4 rounded-full bg-slate-100 dark:bg-slate-800 mb-4"
                >
                    <FolderOpen class="w-8 h-8 text-slate-400" />
                </div>
                <h3
                    class="text-xl font-bold text-slate-700 dark:text-slate-300"
                >
                    No projects found
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    v-for="(project, index) in projects"
                    :key="project.id"
                    class="group bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 flex flex-col"
                    data-aos="fade-up"
                    :data-aos-delay="index * 100"
                >
                    <div class="relative h-56 overflow-hidden shrink-0">
                        <div
                            class="absolute inset-0 bg-slate-900/10 dark:bg-slate-900/20 group-hover:bg-transparent transition-colors z-10"
                        ></div>

                        <img
                            v-if="project.thumbnail"
                            :src="getAssetUrl(project.thumbnail)"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                        />
                        <div
                            v-else
                            class="w-full h-full flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-400"
                        >
                            <Image class="w-10 h-10" />
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span
                                class="text-[10px] font-bold px-2 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded uppercase tracking-wider"
                            >
                                {{
                                    project.tech_stack
                                        ? project.tech_stack.split(",")[0]
                                        : "Web"
                                }}
                            </span>
                            <span
                                v-if="
                                    project.tech_stack &&
                                    project.tech_stack.split(',')[1]
                                "
                                class="text-[10px] font-bold px-2 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded uppercase tracking-wider"
                            >
                                {{ project.tech_stack.split(",")[1] }}
                            </span>
                        </div>

                        <h3
                            class="text-xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-blue-500 transition-colors"
                        >
                            {{ project.title }}
                        </h3>

                        <p
                            class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 mb-6 flex-grow"
                        >
                            {{ project.description }}
                        </p>

                        <div
                            class="flex gap-4 pt-4 border-t border-slate-100 dark:border-slate-800 mt-auto"
                        >
                            <a
                                v-if="project.github_link"
                                :href="project.github_link"
                                target="_blank"
                                class="flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-blue-500 transition-colors"
                            >
                                <Github class="w-4 h-4" /> Code
                            </a>
                            <a
                                v-if="project.live_link"
                                :href="project.live_link"
                                target="_blank"
                                class="flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-blue-500 transition-colors"
                            >
                                <ExternalLink class="w-4 h-4" /> Live Demo
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div
                v-if="pagination.prev_page_url || pagination.next_page_url"
                class="flex justify-center gap-4 mt-16"
            >
                <button
                    @click="loadProjects(pagination.prev_page_url)"
                    :disabled="!pagination.prev_page_url"
                    class="px-6 py-2 rounded-full border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center gap-2"
                >
                    <ChevronLeft class="w-4 h-4" /> Previous
                </button>

                <button
                    @click="loadProjects(pagination.next_page_url)"
                    :disabled="!pagination.next_page_url"
                    class="px-6 py-2 rounded-full border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center gap-2"
                >
                    Next <ChevronRight class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";
import {
    Github,
    ExternalLink,
    ChevronLeft,
    ChevronRight,
    Image,
    FolderOpen,
} from "lucide-vue-next";

const projects = ref([]);
const pagination = ref({});
const isLoading = ref(true);

const getAssetUrl = (path) => {
    if (!path) return null;
    return path.startsWith("http") ? path : `http://127.0.0.1:8000${path}`;
};

// Load Projects (with pagination support)
const loadProjects = async (url = "/api/projects") => {
    isLoading.value = true;
    try {
        // Fix: Laravel returns full URL (http://localhost...), we need to ensure axios handles it
        // If url starts with http, use it directly. If not (initial load), append to base.
        // Since api.js has baseURL, we should pass relative path if possible, or full URL if pagination

        // Trick: If URL is full, api.get will use it and ignore baseURL
        const res = await api.get(url);

        projects.value = res.data.data;
        pagination.value = res.data; // Meta data (links, etc.)

        // Scroll top smoothly on page change
        window.scrollTo({ top: 0, behavior: "smooth" });
    } catch (e) {
        console.error("Failed to load projects", e);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => loadProjects());
</script>
