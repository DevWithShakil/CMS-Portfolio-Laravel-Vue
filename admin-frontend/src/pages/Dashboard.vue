<template>
    <div
        class="min-h-screen bg-slate-950 text-slate-200 p-6 space-y-8 relative overflow-hidden"
    >
        <div
            class="absolute top-0 left-0 w-[500px] h-[500px] bg-blue-600/10 rounded-full blur-[100px] pointer-events-none"
        ></div>
        <div
            class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-600/10 rounded-full blur-[100px] pointer-events-none"
        ></div>

        <div
            class="relative z-10 flex flex-col md:flex-row items-start md:items-end justify-between gap-4"
        >
            <div>
                <h1
                    class="text-3xl md:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 tracking-tight mb-2"
                >
                    Dashboard Overview
                </h1>
                <p class="text-slate-400">
                    Welcome back, Admin! You have
                    <span class="text-white font-semibold"
                        >{{ stats.unreadContacts }} new messages</span
                    >
                    and pending tasks.
                </p>
            </div>

            <div
                class="bg-slate-900/50 backdrop-blur-md border border-slate-800 px-4 py-2 rounded-xl flex items-center gap-3 shadow-lg"
            >
                <div class="p-2 bg-blue-500/20 rounded-lg text-blue-400">
                    <Calendar class="w-5 h-5" />
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">
                        Today
                    </p>
                    <p class="text-sm font-medium text-white">
                        {{
                            new Date().toLocaleDateString("en-US", {
                                weekday: "short",
                                day: "numeric",
                                month: "long",
                            })
                        }}
                    </p>
                </div>
            </div>
        </div>

        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10"
        >
            <router-link
                to="/admin/projects"
                class="group bg-slate-900 border border-slate-800 hover:border-blue-500/50 p-6 rounded-2xl shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden cursor-pointer"
            >
                <div
                    class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all"
                ></div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-400">
                            Total Projects
                        </p>
                        <h3 class="text-3xl font-bold text-white mt-2">
                            {{ stats.projects }}
                        </h3>
                        <div
                            class="flex items-center gap-1 mt-2 text-xs text-emerald-400"
                        >
                            <TrendingUp class="w-3 h-3" />
                            <span>Active Portfolio</span>
                        </div>
                    </div>
                    <div
                        class="p-3 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/10 text-blue-400 border border-blue-500/20"
                    >
                        <Briefcase class="w-6 h-6" />
                    </div>
                </div>
            </router-link>

            <router-link
                to="/admin/skills"
                class="group bg-slate-900 border border-slate-800 hover:border-emerald-500/50 p-6 rounded-2xl shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden cursor-pointer"
            >
                <div
                    class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all"
                ></div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-400">
                            Skills Acquired
                        </p>
                        <h3 class="text-3xl font-bold text-white mt-2">
                            {{ stats.skills }}
                        </h3>
                        <div
                            class="flex items-center gap-1 mt-2 text-xs text-slate-500"
                        >
                            <span>Tech Stack Count</span>
                        </div>
                    </div>
                    <div
                        class="p-3 rounded-xl bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 text-emerald-400 border border-emerald-500/20"
                    >
                        <Award class="w-6 h-6" />
                    </div>
                </div>
            </router-link>

            <router-link
                to="/admin/contacts"
                class="group bg-slate-900 border border-slate-800 hover:border-rose-500/50 p-6 rounded-2xl shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden cursor-pointer"
            >
                <div
                    class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-rose-500/10 rounded-full blur-2xl group-hover:bg-rose-500/20 transition-all"
                ></div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-400">
                            Unread Messages
                        </p>
                        <h3 class="text-3xl font-bold text-white mt-2">
                            {{ stats.unreadContacts }}
                        </h3>
                        <div
                            class="flex items-center gap-1 mt-2 text-xs"
                            :class="
                                stats.unreadContacts > 0
                                    ? 'text-rose-400'
                                    : 'text-slate-500'
                            "
                        >
                            <span v-if="stats.unreadContacts > 0"
                                >Needs Attention</span
                            >
                            <span v-else>All caught up</span>
                        </div>
                    </div>
                    <div
                        class="p-3 rounded-xl bg-gradient-to-br from-rose-500/20 to-rose-600/10 text-rose-400 border border-rose-500/20 relative"
                    >
                        <Mail class="w-6 h-6" />
                        <span
                            v-if="stats.unreadContacts > 0"
                            class="absolute top-0 right-0 w-3 h-3 bg-rose-500 border-2 border-slate-900 rounded-full"
                        ></span>
                    </div>
                </div>
            </router-link>

            <router-link
                to="/admin/blogs"
                class="group bg-slate-900 border border-slate-800 hover:border-purple-500/50 p-6 rounded-2xl shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden cursor-pointer"
            >
                <div
                    class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:bg-purple-500/20 transition-all"
                ></div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-400">
                            Published Blogs
                        </p>
                        <h3 class="text-3xl font-bold text-white mt-2">
                            {{ stats.publishedBlogs }}
                        </h3>
                        <div
                            class="flex items-center gap-1 mt-2 text-xs text-purple-400"
                        >
                            <TrendingUp class="w-3 h-3" />
                            <span>Content Growth</span>
                        </div>
                    </div>
                    <div
                        class="p-3 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-600/10 text-purple-400 border border-purple-500/20"
                    >
                        <FileText class="w-6 h-6" />
                    </div>
                </div>
            </router-link>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 relative z-10">
            <div class="xl:col-span-2 space-y-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <button
                        @click="router.push('/admin/projects')"
                        class="bg-slate-900 border border-slate-800 p-4 rounded-xl flex flex-col items-center justify-center gap-2 hover:bg-slate-800 hover:border-blue-500/30 transition-all group"
                    >
                        <div
                            class="p-2 rounded-full bg-blue-500/10 text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition-colors"
                        >
                            <Plus class="w-5 h-5" />
                        </div>
                        <span
                            class="text-xs font-medium text-slate-400 group-hover:text-white"
                            >New Project</span
                        >
                    </button>

                    <button
                        @click="router.push('/admin/blogs')"
                        class="bg-slate-900 border border-slate-800 p-4 rounded-xl flex flex-col items-center justify-center gap-2 hover:bg-slate-800 hover:border-purple-500/30 transition-all group"
                    >
                        <div
                            class="p-2 rounded-full bg-purple-500/10 text-purple-400 group-hover:bg-purple-500 group-hover:text-white transition-colors"
                        >
                            <PenTool class="w-5 h-5" />
                        </div>
                        <span
                            class="text-xs font-medium text-slate-400 group-hover:text-white"
                            >Write Blog</span
                        >
                    </button>

                    <button
                        @click="router.push('/admin/skills')"
                        class="bg-slate-900 border border-slate-800 p-4 rounded-xl flex flex-col items-center justify-center gap-2 hover:bg-slate-800 hover:border-emerald-500/30 transition-all group"
                    >
                        <div
                            class="p-2 rounded-full bg-emerald-500/10 text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition-colors"
                        >
                            <Award class="w-5 h-5" />
                        </div>
                        <span
                            class="text-xs font-medium text-slate-400 group-hover:text-white"
                            >Add Skill</span
                        >
                    </button>

                    <button
                        @click="router.push('/admin/settings')"
                        class="bg-slate-900 border border-slate-800 p-4 rounded-xl flex flex-col items-center justify-center gap-2 hover:bg-slate-800 hover:border-rose-500/30 transition-all group"
                    >
                        <div
                            class="p-2 rounded-full bg-rose-500/10 text-rose-400 group-hover:bg-rose-500 group-hover:text-white transition-colors"
                        >
                            <User class="w-5 h-5" />
                        </div>
                        <span
                            class="text-xs font-medium text-slate-400 group-hover:text-white"
                            >Profile</span
                        >
                    </button>
                </div>

                <div
                    class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-lg"
                >
                    <div
                        class="p-6 border-b border-slate-800 flex justify-between items-center"
                    >
                        <h3
                            class="text-lg font-bold text-white flex items-center gap-2"
                        >
                            <MessageSquare class="w-5 h-5 text-blue-500" />
                            Recent Inquiries
                        </h3>
                        <button
                            @click="loadRecentContacts"
                            class="text-slate-400 hover:text-white transition-colors"
                        >
                            <RefreshCw
                                class="w-4 h-4"
                                :class="{ 'animate-spin': contactsLoading }"
                            />
                        </button>
                    </div>

                    <div v-if="contactsLoading" class="p-6 space-y-4">
                        <div
                            v-for="i in 3"
                            :key="i"
                            class="h-16 bg-slate-800/50 rounded-xl animate-pulse"
                        ></div>
                    </div>

                    <div v-else class="divide-y divide-slate-800">
                        <div
                            v-for="c in recentContacts"
                            :key="c.id"
                            @click="router.push('/admin/contacts')"
                            class="p-4 flex items-center gap-4 hover:bg-slate-800/50 transition-colors group cursor-pointer"
                        >
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center text-slate-300 font-bold border border-slate-700"
                            >
                                {{ c.name.charAt(0).toUpperCase() }}
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between mb-1">
                                    <h4
                                        class="text-sm font-semibold text-white truncate"
                                    >
                                        {{ c.name }}
                                    </h4>
                                    <span class="text-xs text-slate-500">{{
                                        new Date(
                                            c.created_at
                                        ).toLocaleDateString()
                                    }}</span>
                                </div>
                                <p class="text-sm text-slate-400 truncate">
                                    {{ c.subject }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                <span
                                    v-if="!c.is_seen"
                                    class="px-2 py-1 bg-blue-500/10 text-blue-400 text-[10px] font-bold uppercase rounded border border-blue-500/20"
                                    >New</span
                                >

                                <div
                                    class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity translate-x-4 group-hover:translate-x-0 duration-300"
                                >
                                    <button
                                        @click.stop="markSeen(c)"
                                        v-if="!c.is_seen"
                                        class="p-2 bg-slate-800 hover:bg-emerald-500/20 text-slate-400 hover:text-emerald-400 rounded-lg transition-colors"
                                    >
                                        <CheckCircle class="w-4 h-4" />
                                    </button>
                                    <button
                                        @click.stop="deleteContact(c.id)"
                                        class="p-2 bg-slate-800 hover:bg-rose-500/20 text-slate-400 hover:text-rose-400 rounded-lg transition-colors"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            v-if="recentContacts.length === 0"
                            class="p-8 text-center text-slate-500"
                        >
                            No recent messages found.
                        </div>
                    </div>
                    <div
                        class="p-4 border-t border-slate-800 bg-slate-900/50 text-center"
                    >
                        <router-link
                            to="/admin/contacts"
                            class="text-xs font-medium text-slate-400 hover:text-white hover:underline"
                            >View All Messages</router-link
                        >
                    </div>
                </div>
            </div>

            <div
                class="bg-slate-900 border border-slate-800 rounded-2xl flex flex-col shadow-lg h-fit"
            >
                <div
                    class="p-6 border-b border-slate-800 flex justify-between items-center"
                >
                    <h3
                        class="text-lg font-bold text-white flex items-center gap-2"
                    >
                        <Layers class="w-5 h-5 text-purple-500" /> Latest
                        Projects
                    </h3>
                    <button
                        @click="loadLatestProjects"
                        class="text-slate-400 hover:text-white transition-colors"
                    >
                        <RefreshCw
                            class="w-4 h-4"
                            :class="{ 'animate-spin': projectsLoading }"
                        />
                    </button>
                </div>

                <div v-if="projectsLoading" class="p-6 grid gap-4">
                    <div
                        v-for="i in 3"
                        :key="i"
                        class="h-24 bg-slate-800/50 rounded-xl animate-pulse"
                    ></div>
                </div>

                <div v-else class="p-4 space-y-4">
                    <div
                        v-for="p in latestProjects"
                        :key="p.id"
                        @click="router.push('/admin/projects')"
                        class="group bg-slate-800/30 hover:bg-slate-800 border border-slate-700/50 hover:border-purple-500/30 rounded-xl p-3 transition-all cursor-pointer"
                    >
                        <div class="flex gap-4">
                            <div
                                class="w-16 h-16 rounded-lg bg-slate-700 overflow-hidden shrink-0 border border-slate-600 relative"
                            >
                                <img
                                    v-if="p.thumbnail"
                                    :src="p.thumbnail"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center text-slate-500"
                                >
                                    <Image class="w-6 h-6" />
                                </div>
                            </div>

                            <div class="flex-1 min-w-0 py-1">
                                <h4
                                    class="text-sm font-bold text-white truncate group-hover:text-purple-400 transition-colors"
                                >
                                    {{ p.title }}
                                </h4>
                                <p class="text-xs text-slate-500 truncate mt-1">
                                    {{ p.tech_stack }}
                                </p>

                                <div
                                    class="w-full h-1 bg-slate-700 rounded-full mt-3 overflow-hidden"
                                >
                                    <div
                                        class="h-full bg-purple-500 w-3/4 rounded-full opacity-50 group-hover:opacity-100 transition-opacity"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="latestProjects.length === 0"
                        class="p-8 text-center text-slate-500"
                    >
                        No projects added yet.
                    </div>
                </div>

                <div class="mt-auto p-4 border-t border-slate-800">
                    <router-link
                        to="/admin/projects"
                        class="block w-full py-3 text-center text-sm font-bold text-white bg-slate-800 hover:bg-slate-700 rounded-xl transition-colors"
                    >
                        Manage Projects
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router"; // Router import করুন
import { useToast } from "vue-toastification";
import Swal from "sweetalert2";
import api from "../services/api";

import {
    Briefcase,
    Award,
    Mail,
    FileText,
    RefreshCw,
    MessageSquare,
    Layers,
    CheckCircle,
    Trash2,
    Image,
    ChevronRight,
    TrendingUp,
    Calendar,
    Plus,
    PenTool,
    User,
} from "lucide-vue-next";

const router = useRouter(); // Router init
const toast = useToast();

const stats = ref({
    projects: 0,
    skills: 0,
    experiences: 0,
    unreadContacts: 0,
    publishedBlogs: 0,
});

const recentContacts = ref([]);
const latestProjects = ref([]);
const contactsLoading = ref(false);
const projectsLoading = ref(false);

function normalizeUrl(url) {
    if (typeof url !== "string") return url;
    try {
        if (url.startsWith("http")) {
            const u = new URL(url);
            return u.pathname + u.search;
        }
    } catch (e) {}
    return url;
}

const loadStats = async () => {
    try {
        const [pr, sk, ex, co, bl] = await Promise.all([
            api.get(normalizeUrl("/api/admin/projects")),
            api.get(normalizeUrl("/api/admin/skills")),
            api.get(normalizeUrl("/api/admin/experiences")),
            api.get(normalizeUrl("/api/admin/contacts")),
            api.get(normalizeUrl("/api/admin/blogs")),
        ]);

        stats.value.projects = Array.isArray(pr.data)
            ? pr.data.length
            : pr.data?.data?.length ?? 0;
        stats.value.skills = Array.isArray(sk.data)
            ? sk.data.length
            : sk.data?.data?.length ?? 0;
        stats.value.experiences = Array.isArray(ex.data)
            ? ex.data.length
            : ex.data?.data?.length ?? 0;

        const allContacts = Array.isArray(co.data)
            ? co.data
            : co.data?.data ?? [];
        stats.value.unreadContacts = allContacts.filter(
            (c) => !c.is_seen
        ).length;

        const allBlogs = Array.isArray(bl.data) ? bl.data : bl.data?.data ?? [];
        stats.value.publishedBlogs = allBlogs.filter(
            (b) => b.is_published || b.published === true
        ).length;
    } catch (err) {
        console.error("loadStats error", err);
    }
};

const loadRecentContacts = async () => {
    contactsLoading.value = true;
    try {
        const res = await api.get(normalizeUrl("/api/admin/contacts"), {
            params: { per_page: 5 },
        });
        const data = Array.isArray(res.data) ? res.data : res.data?.data ?? [];
        recentContacts.value = data.slice(0, 5);
    } catch (err) {
        toast.error("Failed to load messages");
    } finally {
        contactsLoading.value = false;
    }
};

const loadLatestProjects = async () => {
    projectsLoading.value = true;
    try {
        const res = await api.get(normalizeUrl("/api/admin/projects"), {
            params: { per_page: 5 },
        });
        const data = Array.isArray(res.data) ? res.data : res.data?.data ?? [];
        latestProjects.value = data.slice(0, 5);
    } catch (err) {
        toast.error("Failed to load projects");
    } finally {
        projectsLoading.value = false;
    }
};

const markSeen = async (contact) => {
    const originalState = contact.is_seen;
    contact.is_seen = true;
    stats.value.unreadContacts = Math.max(0, stats.value.unreadContacts - 1);

    try {
        await api.put(normalizeUrl(`/api/admin/contacts/${contact.id}`), {
            ...contact,
            is_seen: true,
        });
        toast.success("Marked as seen");
    } catch (err) {
        contact.is_seen = originalState;
        stats.value.unreadContacts++;
        toast.error("Could not update status");
    }
};

const deleteContact = async (id) => {
    const confirm = await Swal.fire({
        title: "Delete message?",
        text: "This action cannot be undone.",
        icon: "warning",
        background: "#1e293b",
        color: "#fff",
        showCancelButton: true,
        confirmButtonColor: "#ef4444",
        cancelButtonColor: "#64748b",
        confirmButtonText: "Yes, delete it!",
    });

    if (!confirm.isConfirmed) return;

    try {
        await api.delete(normalizeUrl(`/api/admin/contacts/${id}`));
        toast.success("Message deleted");
        recentContacts.value = recentContacts.value.filter((c) => c.id !== id);
    } catch (err) {
        toast.error("Could not delete message");
    }
};

onMounted(() => {
    loadStats();
    loadRecentContacts();
    loadLatestProjects();
});
</script>
