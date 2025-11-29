<template>
    <div class="relative">
        <section
            id="home"
            class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden"
        >
            <div
                class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-b from-emerald-500/10 to-transparent -z-10 blur-3xl opacity-50"
            ></div>
            <div
                class="absolute bottom-0 left-0 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl -z-10 opacity-50"
            ></div>

            <div
                class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center"
            >
                <div
                    class="space-y-8 text-center lg:text-left"
                    data-aos="fade-up"
                >
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs font-bold tracking-widest uppercase"
                    >
                        <span
                            class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"
                        ></span>
                        Available for hire
                    </div>

                    <h1
                        class="text-5xl lg:text-7xl font-extrabold leading-tight text-slate-900 dark:text-white"
                    >
                        {{ settings.hero_title || "Hi, I'm Developer" }} <br />
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-cyan-500"
                        >
                            {{ settings.hero_subtitle || "Building Solutions" }}
                        </span>
                    </h1>

                    <p
                        class="text-lg text-slate-600 dark:text-slate-400 max-w-xl mx-auto lg:mx-0 leading-relaxed"
                    >
                        {{
                            settings.about ||
                            "I create premium digital experiences with modern web technologies."
                        }}
                    </p>

                    <div
                        class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4"
                    >
                        <a
                            href="#portfolio"
                            class="px-8 py-4 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold hover:bg-emerald-600 dark:hover:bg-emerald-400 dark:hover:text-white transition-all shadow-xl active:scale-95"
                        >
                            View My Work
                        </a>

                        <a
                            v-if="settings.resume_file"
                            :href="getAssetUrl(settings.resume_file)"
                            target="_blank"
                            class="px-8 py-4 rounded-full border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-white font-bold hover:border-emerald-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all flex items-center justify-center gap-2 group bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm"
                        >
                            <span>Download CV</span>
                            <Download
                                class="w-4 h-4 group-hover:translate-y-1 transition-transform"
                            />
                        </a>
                    </div>

                    <div
                        class="flex justify-center lg:justify-start gap-6 pt-4"
                    >
                        <a
                            v-if="settings.github"
                            :href="settings.github"
                            target="_blank"
                            class="text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors"
                            ><Github class="w-6 h-6"
                        /></a>
                        <a
                            v-if="settings.linkedin"
                            :href="settings.linkedin"
                            target="_blank"
                            class="text-slate-400 hover:text-blue-500 transition-colors"
                            ><Linkedin class="w-6 h-6"
                        /></a>
                        <a
                            v-if="settings.facebook"
                            :href="settings.facebook"
                            target="_blank"
                            class="text-slate-400 hover:text-blue-600 transition-colors"
                            ><Facebook class="w-6 h-6"
                        /></a>
                        <a
                            v-if="settings.youtube"
                            :href="settings.youtube"
                            target="_blank"
                            class="text-slate-400 hover:text-red-500 transition-colors"
                            ><Youtube class="w-6 h-6"
                        /></a>
                    </div>
                </div>

                <div
                    class="flex justify-center lg:justify-end relative"
                    data-aos="fade-left"
                    data-aos-delay="200"
                >
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-tr from-emerald-500/20 to-purple-500/20 rounded-full blur-[100px] -z-10"
                    ></div>
                    <div class="relative w-72 h-72 md:w-96 md:h-96">
                        <div
                            class="absolute inset-0 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-full animate-spin-slow"
                        ></div>
                        <div
                            class="absolute inset-4 bg-white dark:bg-slate-800 rounded-full shadow-2xl overflow-hidden border-4 border-white dark:border-slate-700"
                        >
                            <img
                                :src="
                                    getAssetUrl(settings.profile_image) ||
                                    'https://ui-avatars.com/api/?name=User&background=0f172a&color=fff'
                                "
                                class="w-full h-full object-cover hover:scale-110 transition-transform duration-700"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section
            id="skills"
            class="py-20 bg-slate-50 dark:bg-slate-900/50 transition-colors"
        >
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2
                        class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-4"
                    >
                        Technical
                        <span class="text-emerald-500">Expertise</span>
                    </h2>
                    <p
                        class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto"
                    >
                        Tools and technologies I use to bring ideas to life.
                    </p>
                </div>

                <div
                    v-if="isLoading"
                    class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6"
                >
                    <div
                        v-for="n in 6"
                        :key="n"
                        class="h-32 bg-slate-200 dark:bg-slate-800 rounded-2xl animate-pulse"
                    ></div>
                </div>

                <div
                    v-else
                    class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6"
                >
                    <div
                        v-for="skill in skills"
                        :key="skill.id"
                        class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm hover:shadow-xl border border-slate-200 dark:border-slate-800 text-center group transition-all duration-300 hover:-translate-y-2"
                        data-aos="zoom-in"
                    >
                        <div
                            class="w-12 h-12 mx-auto mb-4 p-2 bg-slate-100 dark:bg-slate-800 rounded-xl group-hover:scale-110 transition-transform"
                        >
                            <img
                                :src="getSkillIcon(skill.name)"
                                class="w-full h-full object-contain"
                            />
                        </div>
                        <h3
                            class="font-bold text-slate-800 dark:text-slate-200"
                        >
                            {{ skill.name }}
                        </h3>
                        <p class="text-xs text-emerald-500 font-medium mt-1">
                            {{ skill.percentage }}%
                        </p>
                        <div
                            class="w-full h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full mt-3 overflow-hidden"
                        >
                            <div
                                class="h-full bg-emerald-500 rounded-full"
                                :style="{ width: skill.percentage + '%' }"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="portfolio" class="py-20">
            <div class="max-w-7xl mx-auto px-6">
                <div
                    class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4"
                    data-aos="fade-up"
                >
                    <div>
                        <h2
                            class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-2"
                        >
                            Featured
                            <span class="text-purple-500">Projects</span>
                        </h2>
                        <p class="text-slate-600 dark:text-slate-400">
                            A selection of my recent work.
                        </p>
                    </div>
                    <router-link
                        to="/portfolio"
                        class="text-emerald-500 font-bold hover:underline flex items-center gap-1"
                        >View All <ArrowRight class="w-4 h-4"
                    /></router-link>
                </div>

                <div
                    v-if="isLoading"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        v-for="n in 3"
                        :key="n"
                        class="h-96 bg-slate-200 dark:bg-slate-800 rounded-2xl animate-pulse"
                    ></div>
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        v-for="project in projects"
                        :key="project.id"
                        class="group bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1"
                        data-aos="fade-up"
                    >
                        <div class="relative h-48 overflow-hidden">
                            <div
                                class="absolute inset-0 bg-slate-900/10 dark:bg-slate-900/20 group-hover:bg-transparent transition-colors z-10"
                            ></div>
                            <img
                                :src="getAssetUrl(project.thumbnail)"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                            />
                            <div
                                v-if="!project.thumbnail"
                                class="w-full h-full flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-400"
                            >
                                <Image class="w-10 h-10" />
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    v-if="project.tech_stack"
                                    class="text-[10px] font-bold px-2 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded uppercase tracking-wider"
                                    >{{
                                        project.tech_stack.split(",")[0]
                                    }}</span
                                >
                            </div>
                            <h3
                                class="text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-emerald-500 transition-colors"
                            >
                                {{ project.title }}
                            </h3>
                            <p
                                class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 mb-6"
                            >
                                {{ project.description }}
                            </p>

                            <div
                                class="flex gap-4 pt-4 border-t border-slate-100 dark:border-slate-800"
                            >
                                <a
                                    v-if="project.github_link"
                                    :href="project.github_link"
                                    target="_blank"
                                    class="flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-emerald-500 transition-colors"
                                    ><Github class="w-4 h-4" /> Code</a
                                >
                                <a
                                    v-if="project.live_link"
                                    :href="project.live_link"
                                    target="_blank"
                                    class="flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-emerald-500 transition-colors"
                                    ><ExternalLink class="w-4 h-4" /> Live
                                    Demo</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section
            id="blog"
            class="py-20 bg-slate-50 dark:bg-slate-900/50 transition-colors"
        >
            <div class="max-w-7xl mx-auto px-6">
                <div
                    class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4"
                    data-aos="fade-up"
                >
                    <div>
                        <h2
                            class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-2"
                        >
                            Latest <span class="text-pink-500">Articles</span>
                        </h2>
                        <p class="text-slate-600 dark:text-slate-400">
                            Thoughts, tutorials and insights.
                        </p>
                    </div>
                    <router-link
                        to="/blog"
                        class="text-emerald-500 font-bold hover:underline flex items-center gap-1"
                        >Read Blog <ArrowRight class="w-4 h-4"
                    /></router-link>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        v-for="blog in blogs"
                        :key="blog.id"
                        class="group bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1"
                        data-aos="fade-up"
                    >
                        <div class="relative h-48 overflow-hidden">
                            <img
                                v-if="blog.thumbnail"
                                :src="getAssetUrl(blog.thumbnail)"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                            />
                            <div
                                v-else
                                class="w-full h-full flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-400"
                            >
                                <FileText class="w-10 h-10" />
                            </div>
                            <div
                                class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-sm text-white text-xs px-3 py-1 rounded-full uppercase tracking-wider font-bold"
                            >
                                {{
                                    new Date(
                                        blog.created_at
                                    ).toLocaleDateString()
                                }}
                            </div>
                        </div>

                        <div class="p-6">
                            <h3
                                class="text-xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-emerald-500 transition-colors line-clamp-2"
                            >
                                {{ blog.title }}
                            </h3>
                            <p
                                class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 mb-4"
                            >
                                {{
                                    blog.content
                                        .replace(/<[^>]*>?/gm, "")
                                        .substring(0, 100)
                                }}...
                            </p>
                            <router-link
                                :to="`/blog/${blog.slug}`"
                                class="inline-flex items-center gap-2 text-sm font-bold text-emerald-500 hover:text-emerald-400 transition-colors"
                                >Read More <ArrowRight class="w-4 h-4"
                            /></router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="py-20 relative overflow-hidden">
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/10 rounded-full blur-[120px] -z-10"
            ></div>
            <div class="max-w-4xl mx-auto px-6">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2
                        class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-4"
                    >
                        Get In <span class="text-emerald-500">Touch</span>
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400">
                        Have a project in mind? Let's build something together.
                    </p>
                </div>

                <div
                    class="bg-white dark:bg-slate-900 p-8 md:p-10 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800"
                    data-aos="zoom-in"
                >
                    <form @submit.prevent="sendMessage" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider"
                                    >Name</label
                                >
                                <input
                                    v-model="contactForm.name"
                                    type="text"
                                    placeholder="Your Name"
                                    class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-emerald-500 transition-colors"
                                    required
                                />
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider"
                                    >Email</label
                                >
                                <input
                                    v-model="contactForm.email"
                                    type="email"
                                    placeholder="your@email.com"
                                    class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-emerald-500 transition-colors"
                                    required
                                />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label
                                class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider"
                                >Subject</label
                            >
                            <input
                                v-model="contactForm.subject"
                                type="text"
                                placeholder="Project Inquiry"
                                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-emerald-500 transition-colors"
                                required
                            />
                        </div>

                        <div class="space-y-2">
                            <label
                                class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider"
                                >Message</label
                            >
                            <textarea
                                v-model="contactForm.message"
                                rows="5"
                                placeholder="Tell me about your project..."
                                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-emerald-500 transition-colors resize-none"
                                required
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            class="w-full py-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-lg shadow-lg shadow-emerald-500/25 transition-all active:scale-95 flex justify-center items-center gap-2"
                            :disabled="isSending"
                        >
                            <span v-if="isSending" class="animate-spin"
                                >⌛</span
                            >
                            <span v-else>Send Message</span>
                            <Send v-if="!isSending" class="w-5 h-5" />
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";
import { useToast } from "vue-toastification";
import {
    Download,
    Github,
    Linkedin,
    Facebook,
    Youtube,
    ArrowRight,
    ExternalLink,
    Image,
    FileText,
    Send,
} from "lucide-vue-next";

const toast = useToast();

// Data States
const settings = ref({});
const skills = ref([]);
const projects = ref([]);
const blogs = ref([]);
const isLoading = ref(true);
const isSending = ref(false);

// Contact Form State
const contactForm = ref({ name: "", email: "", subject: "", message: "" });

// Helper: Fix Image URL
const getAssetUrl = (path) => {
    if (!path) return null;
    return path.startsWith("http") ? path : `http://127.0.0.1:8000${path}`;
};

// Helper: Get Skill Icon
const getSkillIcon = (name) => {
    if (!name) return "https://cdn.simpleicons.org/codeigniter/gray";
    let slug = name.toLowerCase().replace(/\s+/g, "").replace(/\./g, "");
    const map = {
        vuejs: "vuejs",
        vue: "vuejs",
        reactjs: "react",
        react: "react",
        node: "nodejs",
        nodejs: "nodejs",
        "c++": "cplusplus",
        "c#": "csharp",
        css: "css3",
        html: "html5",
        aws: "amazonwebservices",
        express: "express",
        expressjs: "express",
        laravel: "laravel",
        php: "php",
        python: "python",
        java: "java",
        js: "javascript",
        javascript: "javascript",
        tailwind: "tailwindcss",
        tailwindcss: "tailwindcss",
    };
    const finalSlug = map[slug] || slug;
    return `https://cdn.jsdelivr.net/gh/devicons/devicon/icons/${finalSlug}/${finalSlug}-original.svg`;
};

// Load All Data
const loadData = async () => {
    try {
        // 1. Settings
        const setRes = await api.get("/api/settings");
        const setData = Array.isArray(setRes.data)
            ? setRes.data[0]
            : setRes.data.data || setRes.data;
        if (setData) settings.value = setData;

        // 2. Skills (Get All)
        const skillRes = await api.get("/api/skills?all=true");
        skills.value = skillRes.data;

        // 3. Projects (Get Latest 3)
        const projRes = await api.get("/api/projects?limit=3");
        projects.value = projRes.data;

        // 4. Blogs (Get Latest 3)
        const blogRes = await api.get("/api/blogs?limit=3");
        blogs.value = blogRes.data;
    } catch (e) {
        console.error("Data load failed", e);
    } finally {
        isLoading.value = false;
    }
};

// Send Message Logic
const sendMessage = async () => {
    isSending.value = true;
    try {
        await api.post("/api/contacts", contactForm.value);
        toast.success("Message sent successfully!");
        contactForm.value = { name: "", email: "", subject: "", message: "" }; // Reset
    } catch (e) {
        toast.error("Failed to send message. Try again.");
    } finally {
        isSending.value = false;
    }
};

onMounted(loadData);
</script>

<style scoped>
.animate-spin-slow {
    animation: spin 10s linear infinite;
}
@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
