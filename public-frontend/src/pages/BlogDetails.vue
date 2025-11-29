<template>
    <div
        class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors pb-20"
    >
        <div
            v-if="isLoading"
            class="pt-32 max-w-4xl mx-auto px-6 space-y-8 animate-pulse"
        >
            <div class="h-8 bg-slate-200 dark:bg-slate-800 rounded w-3/4"></div>
            <div class="h-96 bg-slate-200 dark:bg-slate-800 rounded-2xl"></div>
            <div class="space-y-4">
                <div
                    class="h-4 bg-slate-200 dark:bg-slate-800 rounded w-full"
                ></div>
                <div
                    class="h-4 bg-slate-200 dark:bg-slate-800 rounded w-5/6"
                ></div>
                <div
                    class="h-4 bg-slate-200 dark:bg-slate-800 rounded w-full"
                ></div>
            </div>
        </div>

        <div v-else-if="blog">
            <div class="relative h-[60vh] w-full overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/60 to-transparent z-10"
                ></div>

                <img
                    :src="getAssetUrl(blog.thumbnail)"
                    class="w-full h-full object-cover"
                    alt="Cover Image"
                />

                <div class="absolute bottom-0 left-0 w-full z-20 p-6 pb-16">
                    <div class="max-w-4xl mx-auto">
                        <span
                            class="inline-block px-3 py-1 mb-4 rounded-full bg-emerald-500 text-white text-xs font-bold uppercase tracking-widest shadow-lg"
                        >
                            {{ blog.category?.name || "Tech" }}
                        </span>
                        <h1
                            class="text-3xl md:text-5xl font-extrabold text-white leading-tight mb-4 drop-shadow-lg"
                        >
                            {{ blog.title }}
                        </h1>
                        <div
                            class="flex items-center gap-4 text-slate-300 text-sm"
                        >
                            <div class="flex items-center gap-2">
                                <Calendar class="w-4 h-4" />
                                <span>{{
                                    new Date(
                                        blog.created_at
                                    ).toLocaleDateString("en-US", {
                                        dateStyle: "long",
                                    })
                                }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <User class="w-4 h-4" />
                                <span>By Admin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto px-6 -mt-10 relative z-30">
                <div
                    class="bg-white dark:bg-slate-900 rounded-3xl p-8 md:p-12 shadow-2xl border border-slate-200 dark:border-slate-800"
                >
                    <router-link
                        to="/blog"
                        class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-emerald-500 mb-8 transition-colors"
                    >
                        <ArrowLeft class="w-4 h-4" /> Back to Articles
                    </router-link>

                    <div
                        class="prose prose-lg dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 leading-relaxed"
                        v-html="formatContent(blog.content)"
                    ></div>

                    <div
                        class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4"
                    >
                        <p class="text-slate-500 italic">Thanks for reading!</p>

                        <div class="flex gap-3">
                            <button
                                class="p-2 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-blue-500 hover:text-white transition-all"
                            >
                                <Facebook class="w-5 h-5" />
                            </button>
                            <button
                                class="p-2 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-sky-500 hover:text-white transition-all"
                            >
                                <Twitter class="w-5 h-5" />
                            </button>
                            <button
                                class="p-2 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-blue-700 hover:text-white transition-all"
                            >
                                <Linkedin class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-else-if="!isLoading"
            class="min-h-screen flex items-center justify-center text-slate-500"
        >
            <p>Article not found.</p>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import api from "../services/api";
import {
    Calendar,
    User,
    ArrowLeft,
    Facebook,
    Twitter,
    Linkedin,
} from "lucide-vue-next";

const route = useRoute();
const blog = ref(null);
const isLoading = ref(true);

const getAssetUrl = (path) => {
    if (!path) return null;
    return path.startsWith("http") ? path : `http://127.0.0.1:8000${path}`;
};

// Simple text formatting (In real projects, you'd use a markdown renderer if content is markdown)
const formatContent = (content) => {
    // If content is plain text, convert newlines to <br>. If HTML, leave as is.
    return content.replace(/\n/g, "<br>");
};

const loadBlog = async () => {
    isLoading.value = true;
    try {
        // URL থেকে Slug নেওয়া হচ্ছে
        const slug = route.params.slug;
        const res = await api.get(`/api/blogs/${slug}`);
        blog.value = res.data.data;
    } catch (e) {
        console.error("Failed to load blog", e);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    loadBlog();
    window.scrollTo(0, 0);
});
</script>

<style>
/* Custom Typography for Blog Content */
.prose p {
    margin-bottom: 1.5em;
}
.prose h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-top: 2em;
    margin-bottom: 1em;
    color: inherit;
}
.prose a {
    color: #10b981; /* emerald-500 */
    text-decoration: underline;
}
</style>
