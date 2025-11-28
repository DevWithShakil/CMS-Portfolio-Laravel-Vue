<template>
    <div class="space-y-6">
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-4"
        >
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">
                    Dashboard Overview
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Welcome back! Here's what's happening with your portfolio
                    today.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span
                    class="text-xs font-medium text-slate-500 bg-white px-3 py-1.5 rounded-full border border-slate-200 shadow-sm"
                >
                    {{
                        new Date().toLocaleDateString("en-US", {
                            weekday: "long",
                            year: "numeric",
                            month: "long",
                            day: "numeric",
                        })
                    }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div
                class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 flex items-center justify-between transition-transform hover:-translate-y-1"
            >
                <div>
                    <p
                        class="text-xs font-semibold text-slate-400 uppercase tracking-wider"
                    >
                        Total Projects
                    </p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">
                        {{ stats.projects }}
                    </h3>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600"
                >
                    <Briefcase class="w-6 h-6" />
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 flex items-center justify-between transition-transform hover:-translate-y-1"
            >
                <div>
                    <p
                        class="text-xs font-semibold text-slate-400 uppercase tracking-wider"
                    >
                        Total Skills
                    </p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">
                        {{ stats.skills }}
                    </h3>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600"
                >
                    <Award class="w-6 h-6" />
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 flex items-center justify-between transition-transform hover:-translate-y-1 relative overflow-hidden"
            >
                <div>
                    <p
                        class="text-xs font-semibold text-slate-400 uppercase tracking-wider"
                    >
                        Unread Messages
                    </p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">
                        {{ stats.unreadContacts }}
                    </h3>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600"
                >
                    <Mail class="w-6 h-6" />
                </div>
                <span
                    v-if="stats.unreadContacts > 0"
                    class="absolute top-4 right-4 w-2 h-2 rounded-full bg-rose-500 animate-pulse"
                ></span>
            </div>

            <div
                class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 flex items-center justify-between transition-transform hover:-translate-y-1"
            >
                <div>
                    <p
                        class="text-xs font-semibold text-slate-400 uppercase tracking-wider"
                    >
                        Published Blogs
                    </p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">
                        {{ stats.publishedBlogs }}
                    </h3>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600"
                >
                    <FileText class="w-6 h-6" />
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div
                class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col"
            >
                <div
                    class="p-5 border-b border-slate-100 flex items-center justify-between"
                >
                    <h2
                        class="font-bold text-slate-800 flex items-center gap-2"
                    >
                        <MessageSquare class="w-4 h-4 text-blue-500" /> Recent
                        Messages
                    </h2>
                    <button
                        @click="loadRecentContacts"
                        class="p-2 hover:bg-slate-50 rounded-lg text-slate-400 hover:text-blue-600 transition-colors"
                    >
                        <RefreshCw
                            class="w-4 h-4"
                            :class="{ 'animate-spin': contactsLoading }"
                        />
                    </button>
                </div>

                <div v-if="contactsLoading" class="p-5 space-y-4">
                    <div
                        v-for="i in 3"
                        :key="i"
                        class="h-16 bg-slate-50 rounded-lg animate-pulse w-full"
                    ></div>
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="text-xs font-semibold text-slate-400 uppercase bg-slate-50/50 border-b border-slate-100"
                            >
                                <th class="px-5 py-3">User</th>
                                <th class="px-5 py-3">Subject</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr
                                v-for="c in recentContacts"
                                :key="c.id"
                                class="hover:bg-slate-50/80 transition-colors group"
                            >
                                <td class="px-5 py-3">
                                    <div
                                        class="font-medium text-slate-800 text-sm"
                                    >
                                        {{ c.name }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{
                                            new Date(
                                                c.created_at
                                            ).toLocaleDateString()
                                        }}
                                    </div>
                                </td>
                                <td
                                    class="px-5 py-3 text-sm text-slate-600 truncate max-w-[150px]"
                                >
                                    {{ c.subject }}
                                </td>
                                <td class="px-5 py-3">
                                    <span
                                        v-if="c.is_seen"
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600"
                                    >
                                        Seen
                                    </span>
                                    <span
                                        v-else
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100"
                                    >
                                        New
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                    >
                                        <button
                                            v-if="!c.is_seen"
                                            @click="markSeen(c)"
                                            title="Mark as Read"
                                            class="p-1.5 text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100"
                                        >
                                            <CheckCircle class="w-4 h-4" />
                                        </button>
                                        <button
                                            @click="deleteContact(c.id)"
                                            title="Delete"
                                            class="p-1.5 text-red-600 bg-red-50 rounded-md hover:bg-red-100"
                                        >
                                            <Trash2 class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="recentContacts.length === 0">
                                <td
                                    colspan="4"
                                    class="px-5 py-8 text-center text-slate-400 text-sm"
                                >
                                    No new messages found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col h-full"
            >
                <div
                    class="p-5 border-b border-slate-100 flex items-center justify-between"
                >
                    <h2
                        class="font-bold text-slate-800 flex items-center gap-2"
                    >
                        <Layers class="w-4 h-4 text-purple-500" /> Latest
                        Projects
                    </h2>
                    <button
                        @click="loadLatestProjects"
                        class="p-2 hover:bg-slate-50 rounded-lg text-slate-400 hover:text-blue-600 transition-colors"
                    >
                        <RefreshCw
                            class="w-4 h-4"
                            :class="{ 'animate-spin': projectsLoading }"
                        />
                    </button>
                </div>

                <div v-if="projectsLoading" class="p-5 space-y-4">
                    <div v-for="i in 4" :key="i" class="flex gap-3">
                        <div
                            class="w-12 h-12 bg-slate-100 rounded-lg animate-pulse"
                        ></div>
                        <div class="flex-1 space-y-2">
                            <div
                                class="h-4 bg-slate-100 rounded w-3/4 animate-pulse"
                            ></div>
                            <div
                                class="h-3 bg-slate-100 rounded w-1/2 animate-pulse"
                            ></div>
                        </div>
                    </div>
                </div>

                <div v-else class="p-5 space-y-4">
                    <div
                        v-for="p in latestProjects"
                        :key="p.id"
                        class="flex items-start gap-4 p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-all cursor-pointer"
                    >
                        <div
                            class="w-12 h-12 shrink-0 rounded-lg bg-slate-100 overflow-hidden border border-slate-200"
                        >
                            <img
                                v-if="p.thumbnail"
                                :src="p.thumbnail"
                                class="w-full h-full object-cover"
                                alt="Project"
                            />
                            <div
                                v-else
                                class="w-full h-full flex items-center justify-center text-slate-300"
                            >
                                <Image class="w-5 h-5" />
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <h4
                                class="text-sm font-semibold text-slate-800 truncate"
                            >
                                {{ p.title }}
                            </h4>
                            <p class="text-xs text-slate-500 truncate mt-0.5">
                                {{ p.tech_stack }}
                            </p>
                        </div>

                        <ChevronRight class="w-4 h-4 text-slate-300 mt-2" />
                    </div>

                    <div
                        v-if="latestProjects.length === 0"
                        class="text-center py-6 text-slate-400 text-sm"
                    >
                        No projects added yet.
                    </div>
                </div>

                <div class="mt-auto p-4 border-t border-slate-100">
                    <router-link
                        to="/admin/projects"
                        class="block w-full py-2 text-center text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors"
                    >
                        View All Projects
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import Swal from "sweetalert2";
import api from "../services/api";

// Import Icons (Ensure you installed lucide-vue-next)
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
} from "lucide-vue-next";

const toast = useToast();

// State
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

// Helper for URLs
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

// 1. Load Stats
const loadStats = async () => {
    try {
        const [pr, sk, ex, co, bl] = await Promise.all([
            api.get(normalizeUrl("/api/admin/projects")),
            api.get(normalizeUrl("/api/admin/skills")),
            api.get(normalizeUrl("/api/admin/experiences")),
            api.get(normalizeUrl("/api/admin/contacts")),
            api.get(normalizeUrl("/api/admin/blogs")),
        ]);

        // Projects
        stats.value.projects = Array.isArray(pr.data)
            ? pr.data.length
            : pr.data?.data?.length ?? 0;
        // Skills
        stats.value.skills = Array.isArray(sk.data)
            ? sk.data.length
            : sk.data?.data?.length ?? 0;
        // Experiences
        stats.value.experiences = Array.isArray(ex.data)
            ? ex.data.length
            : ex.data?.data?.length ?? 0;

        // Unread Contacts
        const allContacts = Array.isArray(co.data)
            ? co.data
            : co.data?.data ?? [];
        stats.value.unreadContacts = allContacts.filter(
            (c) => !c.is_seen
        ).length;

        // Published Blogs
        const allBlogs = Array.isArray(bl.data) ? bl.data : bl.data?.data ?? [];
        stats.value.publishedBlogs = allBlogs.filter(
            (b) => b.is_published || b.published === true
        ).length;
    } catch (err) {
        console.error("loadStats error", err);
        // Silent fail or minimal toast to not annoy user
    }
};

// 2. Load Recent Contacts
const loadRecentContacts = async () => {
    contactsLoading.value = true;
    try {
        const res = await api.get(normalizeUrl("/api/admin/contacts"), {
            params: { per_page: 5 },
        });
        const data = Array.isArray(res.data) ? res.data : res.data?.data ?? [];

        recentContacts.value = data
            .slice()
            .sort((a, b) => {
                if (a.created_at && b.created_at)
                    return new Date(b.created_at) - new Date(a.created_at);
                return b.id - a.id;
            })
            .slice(0, 5);
    } catch (err) {
        toast.error("Failed to load messages");
    } finally {
        contactsLoading.value = false;
    }
};

// 3. Load Latest Projects
const loadLatestProjects = async () => {
    projectsLoading.value = true;
    try {
        const res = await api.get(normalizeUrl("/api/admin/projects"), {
            params: { per_page: 5 },
        });
        const data = Array.isArray(res.data) ? res.data : res.data?.data ?? [];

        latestProjects.value = data
            .slice()
            .sort((a, b) => {
                if (a.created_at && b.created_at)
                    return new Date(b.created_at) - new Date(a.created_at);
                return b.id - a.id;
            })
            .slice(0, 5);
    } catch (err) {
        toast.error("Failed to load projects");
    } finally {
        projectsLoading.value = false;
    }
};

// Actions
const markSeen = async (contact) => {
    // Optimistic UI update (Instant feedback)
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
        // Revert on failure
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
