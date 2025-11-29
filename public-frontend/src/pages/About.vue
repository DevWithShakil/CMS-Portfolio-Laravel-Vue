<template>
    <div class="min-h-screen pt-32 pb-20">
        <div class="max-w-7xl mx-auto px-6 mb-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div
                    class="relative flex justify-center lg:justify-start"
                    data-aos="fade-right"
                >
                    <div class="relative w-64 h-64 md:w-80 md:h-80">
                        <div
                            class="absolute inset-0 bg-gradient-to-tr from-emerald-500 to-cyan-500 rounded-2xl rotate-6 opacity-50 blur-lg"
                        ></div>
                        <img
                            :src="
                                getAssetUrl(settings.profile_image) ||
                                'https://ui-avatars.com/api/?name=User&background=0f172a&color=fff'
                            "
                            class="relative w-full h-full object-cover rounded-2xl border-2 border-slate-200 dark:border-slate-700 shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-500"
                        />
                    </div>
                </div>

                <div data-aos="fade-left">
                    <h1
                        class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-6"
                    >
                        About
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-cyan-500"
                            >Me</span
                        >
                    </h1>
                    <p
                        class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line"
                    >
                        {{ settings.about || "Loading bio..." }}
                    </p>

                    <div class="mt-8 flex gap-4">
                        <a
                            v-if="settings.resume_file"
                            :href="getAssetUrl(settings.resume_file)"
                            target="_blank"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold hover:bg-emerald-600 dark:hover:bg-emerald-400 dark:hover:text-white transition-all shadow-lg"
                        >
                            <Download class="w-4 h-4" /> See Resume
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section class="py-12 bg-slate-50 dark:bg-slate-900/50 mb-20">
            <div class="max-w-4xl mx-auto px-6">
                <h2
                    class="text-3xl font-bold text-slate-900 dark:text-white mb-12 text-center flex items-center justify-center gap-3"
                >
                    <Briefcase class="w-8 h-8 text-purple-500" /> Work
                    Experience
                </h2>

                <div
                    class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:dark:via-slate-700 before:to-transparent"
                >
                    <div
                        v-for="(exp, index) in experiences"
                        :key="exp.id"
                        class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active"
                        data-aos="fade-up"
                    >
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-900 bg-slate-200 dark:bg-slate-800 text-slate-500 group-hover:bg-purple-500 group-hover:text-white transition-colors shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2"
                        >
                            <Briefcase class="w-4 h-4" />
                        </div>

                        <div
                            class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-lg hover:shadow-xl transition-shadow"
                        >
                            <div class="flex justify-between items-start mb-2">
                                <h3
                                    class="font-bold text-slate-900 dark:text-white text-lg"
                                >
                                    {{ exp.position }}
                                </h3>
                                <span
                                    class="text-xs font-bold px-2 py-1 rounded bg-purple-100 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 whitespace-nowrap"
                                >
                                    {{ exp.duration }}
                                </span>
                            </div>
                            <div
                                class="text-sm font-medium text-emerald-600 dark:text-emerald-400 mb-3"
                            >
                                {{ exp.company }}
                            </div>
                            <p
                                class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed"
                            >
                                {{ exp.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-6xl mx-auto px-6">
            <h2
                class="text-3xl font-bold text-slate-900 dark:text-white mb-12 text-center flex items-center justify-center gap-3"
            >
                <GraduationCap class="w-8 h-8 text-emerald-500" /> Education
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div
                    v-for="(edu, index) in education"
                    :key="edu.id"
                    class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-lg transition-all hover:-translate-y-1 flex gap-4"
                    data-aos="fade-up"
                    :data-aos-delay="index * 100"
                >
                    <div
                        class="w-12 h-12 bg-emerald-100 dark:bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0"
                    >
                        <School class="w-6 h-6" />
                    </div>
                    <div>
                        <h3
                            class="font-bold text-slate-900 dark:text-white text-lg"
                        >
                            {{ edu.degree }}
                        </h3>
                        <p
                            class="text-slate-500 dark:text-slate-400 text-sm font-medium"
                        >
                            {{ edu.institution }}
                        </p>
                        <p
                            class="text-xs text-slate-400 mt-1 flex items-center gap-1"
                        >
                            <Calendar class="w-3 h-3" /> {{ edu.duration }}
                        </p>
                        <p
                            class="text-slate-600 dark:text-slate-400 text-sm mt-3 leading-relaxed"
                        >
                            {{ edu.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";
import {
    Download,
    Briefcase,
    GraduationCap,
    Calendar,
    School,
} from "lucide-vue-next";

const settings = ref({});
const experiences = ref([]);
const education = ref([]);

const getAssetUrl = (path) => {
    if (!path) return null;
    return path.startsWith("http") ? path : `http://127.0.0.1:8000${path}`;
};

const loadData = async () => {
    try {
        // Parallel data fetching for better performance
        const [setRes, expRes, eduRes] = await Promise.all([
            api.get("/api/settings"),
            api.get("/api/experiences"),
            api.get("/api/education"),
        ]);

        const setData = Array.isArray(setRes.data)
            ? setRes.data[0]
            : setRes.data.data || setRes.data;
        if (setData) settings.value = setData;

        experiences.value = expRes.data.data || expRes.data;
        education.value = eduRes.data.data || eduRes.data;
    } catch (e) {
        console.error("Failed to load data", e);
    }
};

onMounted(() => {
    loadData();
    window.scrollTo(0, 0);
});
</script>
