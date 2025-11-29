<template>
    <footer
        class="bg-slate-950 pt-16 pb-8 border-t border-slate-800 relative overflow-hidden"
    >
        <div
            class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-emerald-500/50 to-transparent"
        ></div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <div class="space-y-4">
                    <router-link
                        to="/"
                        class="text-2xl font-bold tracking-tight text-white group inline-block"
                    >
                        {{ settings.site_title }}
                    </router-link>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
                        {{
                            settings.hero_subtitle ||
                            "Building digital experiences with passion and code."
                        }}
                    </p>
                </div>

                <div class="flex flex-col space-y-3">
                    <h3 class="text-white font-bold mb-2">Quick Links</h3>
                    <router-link
                        to="/"
                        class="text-slate-400 hover:text-emerald-400 text-sm transition-colors w-fit"
                        >Home</router-link
                    >
                    <router-link
                        to="/about"
                        class="text-slate-400 hover:text-emerald-400 text-sm transition-colors w-fit"
                        >About Me</router-link
                    >
                    <router-link
                        to="/portfolio"
                        class="text-slate-400 hover:text-emerald-400 text-sm transition-colors w-fit"
                        >Portfolio</router-link
                    >
                    <router-link
                        to="/blog"
                        class="text-slate-400 hover:text-emerald-400 text-sm transition-colors w-fit"
                        >Articles</router-link
                    >
                    <router-link
                        to="/contact"
                        class="text-slate-400 hover:text-emerald-400 text-sm transition-colors w-fit"
                        >Contact</router-link
                    >
                </div>

                <div>
                    <h3 class="text-white font-bold mb-4">Connect</h3>
                    <div class="flex gap-4">
                        <a
                            v-if="settings.github"
                            :href="settings.github"
                            target="_blank"
                            class="w-10 h-10 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:border-emerald-500 hover:bg-emerald-500/10 transition-all"
                        >
                            <Github class="w-5 h-5" />
                        </a>
                        <a
                            v-if="settings.linkedin"
                            :href="settings.linkedin"
                            target="_blank"
                            class="w-10 h-10 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:border-blue-500 hover:bg-blue-500/10 transition-all"
                        >
                            <Linkedin class="w-5 h-5" />
                        </a>
                        <a
                            v-if="settings.facebook"
                            :href="settings.facebook"
                            target="_blank"
                            class="w-10 h-10 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:border-blue-600 hover:bg-blue-600/10 transition-all"
                        >
                            <Facebook class="w-5 h-5" />
                        </a>
                        <a
                            v-if="settings.youtube"
                            :href="settings.youtube"
                            target="_blank"
                            class="w-10 h-10 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:border-red-500 hover:bg-red-500/10 transition-all"
                        >
                            <Youtube class="w-5 h-5" />
                        </a>
                    </div>

                    <div class="mt-6">
                        <a
                            v-if="settings.email"
                            :href="`mailto:${settings.email}`"
                            class="text-sm text-slate-400 hover:text-emerald-400 transition-colors flex items-center gap-2"
                        >
                            <Mail class="w-4 h-4" />
                            {{ settings.email }}
                        </a>

                        <a
                            v-else
                            href="mailto:admin@example.com"
                            class="text-sm text-slate-400 hover:text-emerald-400 transition-colors flex items-center gap-2"
                        >
                            <Mail class="w-4 h-4" />
                            admin@example.com
                        </a>
                    </div>
                </div>
            </div>

            <div
                class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4"
            >
                <p class="text-slate-500 text-sm">
                    &copy; {{ new Date().getFullYear() }}
                    {{ settings.site_title || "Portfolio" }}. All rights
                    reserved.
                </p>

                <div class="flex items-center gap-4">
                    <p class="text-slate-600 text-xs flex items-center gap-1">
                        Made with
                        <Heart class="w-3 h-3 text-rose-500 animate-pulse" />
                        using Vue & Laravel
                    </p>

                    <a
                        href="http://localhost:5173"
                        target="_blank"
                        class="text-slate-700 hover:text-emerald-500 transition-colors"
                        title="Admin Login"
                    >
                        <Lock class="w-3 h-3" />
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";
import {
    Github,
    Linkedin,
    Facebook,
    Youtube,
    Mail,
    Heart,
    Lock,
} from "lucide-vue-next";

const settings = ref({});

const loadSettings = async () => {
    try {
        const res = await api.get("/api/settings");
        // API returns object directly or array, handle both
        const data = Array.isArray(res.data)
            ? res.data[0]
            : res.data.data || res.data;
        if (data) settings.value = data;
    } catch (e) {}
};

onMounted(loadSettings);
</script>
