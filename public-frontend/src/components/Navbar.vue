<template>
    <header
        class="fixed top-0 w-full z-50 transition-all duration-300 border-b"
        :class="
            isScrolled
                ? 'bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-slate-200 dark:border-slate-800 shadow-sm'
                : 'bg-transparent border-transparent py-2'
        "
    >
        <div
            class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between"
        >
            <router-link
                to="/"
                class="text-2xl font-bold tracking-tight group text-slate-900 dark:text-white"
            >
                {{ siteTitle
                }}<span
                    class="text-emerald-500 group-hover:text-emerald-400 transition-colors"
                    >.Dev</span
                >
            </router-link>

            <nav class="hidden lg:flex items-center gap-8">
                <router-link
                    to="/"
                    class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors"
                    active-class="text-emerald-600 dark:text-emerald-400 font-bold"
                    >Home</router-link
                >
                <router-link
                    to="/about"
                    class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors"
                    active-class="text-emerald-600 dark:text-emerald-400 font-bold"
                    >About</router-link
                >
                <router-link
                    to="/portfolio"
                    class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors"
                    active-class="text-emerald-600 dark:text-emerald-400 font-bold"
                    >Work</router-link
                >
                <router-link
                    to="/blog"
                    class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors"
                    active-class="text-emerald-600 dark:text-emerald-400 font-bold"
                    >Blog</router-link
                >
            </nav>

            <div class="flex items-center gap-3">
                <div
                    class="hidden md:flex items-center gap-3 mr-2 border-r border-slate-300 dark:border-slate-700 pr-4"
                >
                    <a
                        v-if="settings.github"
                        :href="settings.github"
                        target="_blank"
                        class="text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white transition-colors"
                        ><Github class="w-5 h-5"
                    /></a>
                    <a
                        v-if="settings.linkedin"
                        :href="settings.linkedin"
                        target="_blank"
                        class="text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 transition-colors"
                        ><Linkedin class="w-5 h-5"
                    /></a>
                    <a
                        v-if="settings.facebook"
                        :href="settings.facebook"
                        target="_blank"
                        class="text-slate-500 hover:text-blue-500 dark:text-slate-400 dark:hover:text-blue-400 transition-colors"
                        ><Facebook class="w-5 h-5"
                    /></a>
                </div>

                <button
                    @click="openSearch"
                    class="p-2 rounded-full text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all"
                >
                    <Search class="w-5 h-5" />
                </button>

                <button
                    @click="toggleDark()"
                    class="p-2 rounded-full text-slate-600 dark:text-yellow-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all"
                >
                    <component :is="isDark ? Sun : Moon" class="w-5 h-5" />
                </button>

                <router-link
                    to="/contact"
                    class="hidden md:inline-flex px-5 py-2 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold hover:bg-emerald-600 dark:hover:bg-emerald-400 dark:hover:text-white transition-all shadow-lg"
                >
                    Let's Talk
                </router-link>

                <button
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                    class="lg:hidden p-2 text-slate-600 dark:text-slate-300"
                >
                    <component
                        :is="isMobileMenuOpen ? X : Menu"
                        class="w-6 h-6"
                    />
                </button>
            </div>
        </div>

        <transition name="slide-fade">
            <div
                v-if="isMobileMenuOpen"
                class="lg:hidden absolute top-20 left-0 w-full bg-white dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800 shadow-xl p-6 flex flex-col gap-4"
            >
                <router-link
                    to="/"
                    @click="isMobileMenuOpen = false"
                    class="text-lg font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-500"
                    >Home</router-link
                >
                <router-link
                    to="/about"
                    @click="isMobileMenuOpen = false"
                    class="text-lg font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-500"
                    >About</router-link
                >
                <router-link
                    to="/portfolio"
                    @click="isMobileMenuOpen = false"
                    class="text-lg font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-500"
                    >Work</router-link
                >
                <router-link
                    to="/blog"
                    @click="isMobileMenuOpen = false"
                    class="text-lg font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-500"
                    >Blog</router-link
                >

                <div
                    class="border-t border-slate-200 dark:border-slate-700 my-2"
                ></div>

                <div class="flex gap-6 justify-center py-2">
                    <a
                        v-if="settings.github"
                        :href="settings.github"
                        target="_blank"
                        class="text-slate-500 dark:text-slate-400 hover:text-emerald-500"
                        ><Github class="w-6 h-6"
                    /></a>
                    <a
                        v-if="settings.linkedin"
                        :href="settings.linkedin"
                        target="_blank"
                        class="text-slate-500 dark:text-slate-400 hover:text-emerald-500"
                        ><Linkedin class="w-6 h-6"
                    /></a>
                    <a
                        v-if="settings.facebook"
                        :href="settings.facebook"
                        target="_blank"
                        class="text-slate-500 dark:text-slate-400 hover:text-emerald-500"
                        ><Facebook class="w-6 h-6"
                    /></a>
                    <a
                        v-if="settings.youtube"
                        :href="settings.youtube"
                        target="_blank"
                        class="text-slate-500 dark:text-slate-400 hover:text-emerald-500"
                        ><Youtube class="w-6 h-6"
                    /></a>
                </div>

                <router-link
                    to="/contact"
                    @click="isMobileMenuOpen = false"
                    class="text-center w-full py-3 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold text-lg"
                    >Let's Talk</router-link
                >
            </div>
        </transition>

        <transition name="fade">
            <div
                v-if="isSearchOpen"
                class="fixed inset-0 z-[60] bg-white/95 dark:bg-slate-950/95 backdrop-blur-xl flex flex-col p-6"
            >
                <button
                    @click="closeSearch"
                    class="absolute top-6 right-6 p-2 text-slate-500 hover:text-rose-500 transition-colors"
                >
                    <X class="w-8 h-8" />
                </button>

                <div class="mt-20 max-w-3xl mx-auto w-full">
                    <input
                        ref="searchInputRef"
                        v-model="searchQuery"
                        @input="handleSearch"
                        type="text"
                        placeholder="Search projects, skills or articles..."
                        class="w-full bg-transparent border-b-2 border-slate-200 dark:border-slate-700 text-3xl md:text-5xl font-bold text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 pb-4 placeholder:text-slate-300 dark:placeholder:text-slate-700 transition-all"
                    />

                    <div
                        v-if="searchResults.length > 0"
                        class="mt-10 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar"
                    >
                        <div
                            v-for="(item, index) in searchResults"
                            :key="index"
                            @click="navigateTo(item.url)"
                            class="group flex items-center gap-4 p-4 rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-900 transition-all cursor-pointer border border-transparent hover:border-slate-200 dark:hover:border-slate-800"
                        >
                            <div
                                class="p-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 group-hover:bg-white dark:group-hover:bg-slate-950 shadow-sm"
                            >
                                <component
                                    :is="getIcon(item.type)"
                                    class="w-6 h-6"
                                />
                            </div>
                            <div>
                                <h3
                                    class="text-lg font-bold text-slate-800 dark:text-slate-200 group-hover:text-emerald-500 transition-colors"
                                >
                                    {{ item.data.title || item.data.name }}
                                </h3>
                                <span
                                    class="text-xs font-medium uppercase tracking-wider text-slate-500"
                                    >{{ item.type }}</span
                                >
                            </div>
                            <ArrowRight
                                class="w-5 h-5 ml-auto text-slate-300 group-hover:text-emerald-500 -translate-x-2 group-hover:translate-x-0 transition-all opacity-0 group-hover:opacity-100"
                            />
                        </div>
                    </div>

                    <div
                        v-else-if="searchQuery.length > 1 && !isLoading"
                        class="mt-10 text-center text-slate-400"
                    >
                        No results found for "{{ searchQuery }}"
                    </div>
                </div>
            </div>
        </transition>
    </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from "vue";
import { useRouter } from "vue-router";
import { useDark, useToggle } from "@vueuse/core";
import {
    Sun,
    Moon,
    Menu,
    X,
    Search,
    ArrowRight,
    Layers,
    Award,
    FileText,
    Github,
    Linkedin,
    Facebook,
    Youtube,
} from "lucide-vue-next";
import api from "../services/api";

const router = useRouter();
const isDark = useDark();
const toggleDark = useToggle(isDark);
const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);
const siteTitle = ref("Shakil");
const settings = ref({}); // ✅ Settings state added

// Search States
const isSearchOpen = ref(false);
const searchQuery = ref("");
const searchResults = ref([]);
const searchInputRef = ref(null);
const isLoading = ref(false);
let searchTimeout = null;

const handleScroll = () => {
    isScrolled.value = window.scrollY > 50;
};

const getIcon = (type) => {
    if (type === "Project") return Layers;
    if (type === "Skill") return Award;
    return FileText;
};

const openSearch = async () => {
    isSearchOpen.value = true;
    isMobileMenuOpen.value = false;
    await nextTick();
    searchInputRef.value?.focus();
};

const closeSearch = () => {
    isSearchOpen.value = false;
    searchQuery.value = "";
    searchResults.value = [];
};

const handleSearch = () => {
    clearTimeout(searchTimeout);
    if (searchQuery.value.length < 2) {
        searchResults.value = [];
        return;
    }

    isLoading.value = true;
    searchTimeout = setTimeout(async () => {
        try {
            const res = await api.get("/api/public-search", {
                params: { q: searchQuery.value },
            });
            searchResults.value = res.data;
        } catch (e) {
            console.error(e);
        } finally {
            isLoading.value = false;
        }
    }, 300);
};

const navigateTo = (url) => {
    router.push(url.replace("#", "/")); // Simple fix for hash URLs to routes
    closeSearch();
};

// ✅ Load Settings (Updated to fetch full object)
const loadSettings = async () => {
    try {
        const res = await api.get("/api/settings");
        const data = Array.isArray(res.data)
            ? res.data[0]
            : res.data.data || res.data;
        if (data) {
            settings.value = data;
            if (data.site_title)
                siteTitle.value = data.site_title.split(" ")[0];
        }
    } catch (e) {}
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    loadSettings();
});

onUnmounted(() => window.removeEventListener("scroll", handleScroll));
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}
</style>
