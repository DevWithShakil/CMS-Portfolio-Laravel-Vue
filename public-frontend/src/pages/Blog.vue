<template>
    <div class="pt-32 pb-20 min-h-screen">
        <div
            class="max-w-7xl mx-auto px-6 mb-16 text-center"
            data-aos="fade-down"
        >
            <h1
                class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-4"
            >
                Latest
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-pink-500"
                    >Articles</span
                >
            </h1>
            <p class="text-slate-600 dark:text-slate-400 max-w-xl mx-auto">
                Insights, tutorials, and thoughts on modern web development.
            </p>
        </div>

        <div class="max-w-2xl mx-auto px-6 mb-12">
            <div class="relative group">
                <Search
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-purple-500 transition-colors"
                />
                <input
                    v-model="search"
                    @input="loadBlogs"
                    type="text"
                    placeholder="Search articles..."
                    class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-full py-3 pl-12 pr-6 focus:outline-none focus:border-purple-500 dark:focus:border-purple-500 transition-all shadow-sm text-slate-700 dark:text-slate-300"
                />
            </div>
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
            <div v-if="blogs.length === 0" class="text-center py-20">
                <div
                    class="inline-block p-4 rounded-full bg-slate-100 dark:bg-slate-800 mb-4"
                >
                    <FileText class="w-8 h-8 text-slate-400" />
                </div>
                <h3
                    class="text-xl font-bold text-slate-700 dark:text-slate-300"
                >
                    No articles found
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    v-for="(blog, index) in blogs"
                    :key="blog.id"
                    class="group bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 flex flex-col"
                    data-aos="fade-up"
                    :data-aos-delay="index * 100"
                >
                    <div class="relative h-52 overflow-hidden shrink-0">
                        <img
                            :src="getAssetUrl(blog.thumbnail)"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                        />

                        <div class="absolute top-4 right-4">
                            <span
                                class="bg-purple-600/90 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-lg"
                            >
                                {{ blog.category?.name || "Tech" }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <div
                            class="flex items-center gap-2 text-xs text-slate-500 mb-3"
                        >
                            <Calendar class="w-3.5 h-3.5" />
                            <span>{{
                                new Date(blog.created_at).toLocaleDateString()
                            }}</span>
                        </div>

                        <h3
                            class="text-xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-purple-500 transition-colors line-clamp-2"
                        >
                            {{ blog.title }}
                        </h3>

                        <p
                            class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 mb-6 flex-grow"
                        >
                            {{
                                blog.content
                                    .replace(/<[^>]*>?/gm, "")
                                    .substring(0, 120)
                            }}...
                        </p>

                        <router-link
                            :to="`/blog/${blog.slug}`"
                            class="inline-flex items-center gap-2 text-sm font-bold text-purple-600 dark:text-purple-400 hover:underline mt-auto"
                        >
                            Read Article <ArrowRight class="w-4 h-4" />
                        </router-link>
                    </div>
                </div>
            </div>

            <div
                v-if="pagination.prev_page_url || pagination.next_page_url"
                class="flex justify-center gap-4 mt-16"
            >
                <button
                    @click="loadBlogs(pagination.prev_page_url)"
                    :disabled="!pagination.prev_page_url"
                    class="px-6 py-2 rounded-full border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center gap-2"
                >
                    <ChevronLeft class="w-4 h-4" /> Previous
                </button>

                <button
                    @click="loadBlogs(pagination.next_page_url)"
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
    Search,
    FileText,
    Calendar,
    ArrowRight,
    ChevronLeft,
    ChevronRight,
} from "lucide-vue-next";

const blogs = ref([]);
const pagination = ref({});
const isLoading = ref(true);
const search = ref("");
let searchTimeout = null;

const getAssetUrl = (path) => {
    if (!path) return null;
    return path.startsWith("http") ? path : `http://127.0.0.1:8000${path}`;
};

const loadBlogs = async (url = "/api/blogs") => {
    // Debounce search if typing
    if (search.value) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => fetchBlogs(url), 500);
    } else {
        fetchBlogs(url);
    }
};

const fetchBlogs = async (url) => {
    isLoading.value = true;
    try {
        // Handle URL construction
        const targetUrl = url.startsWith("http") ? url : url;

        const res = await api.get(targetUrl, {
            params: { search: search.value },
        });

        blogs.value = res.data.data;
        pagination.value = res.data;

        window.scrollTo({ top: 0, behavior: "smooth" });
    } catch (e) {
        console.error("Failed to load blogs", e);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => fetchBlogs("/api/blogs"));
</script>
