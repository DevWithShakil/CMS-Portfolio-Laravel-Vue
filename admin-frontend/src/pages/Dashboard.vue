<template>
    <div class="flex">
        <Sidebar />

        <div class="flex-1 ml-64">
            <Topbar />

            <div class="p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold">Dashboard</h1>
                        <p class="text-gray-600 mt-1">
                            Welcome back — here’s a quick overview.
                        </p>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6"
                >
                    <div
                        class="bg-white p-4 rounded shadow-sm flex items-center"
                    >
                        <div class="flex-1">
                            <div class="text-sm text-gray-500">Projects</div>
                            <div class="text-2xl font-semibold">
                                {{ stats.projects }}
                            </div>
                        </div>
                        <div class="text-blue-600 text-3xl">📁</div>
                    </div>

                    <div
                        class="bg-white p-4 rounded shadow-sm flex items-center"
                    >
                        <div class="flex-1">
                            <div class="text-sm text-gray-500">Skills</div>
                            <div class="text-2xl font-semibold">
                                {{ stats.skills }}
                            </div>
                        </div>
                        <div class="text-yellow-500 text-3xl">🧰</div>
                    </div>

                    <div
                        class="bg-white p-4 rounded shadow-sm flex items-center"
                    >
                        <div class="flex-1">
                            <div class="text-sm text-gray-500">Experiences</div>
                            <div class="text-2xl font-semibold">
                                {{ stats.experiences }}
                            </div>
                        </div>
                        <div class="text-green-500 text-3xl">💼</div>
                    </div>

                    <div
                        class="bg-white p-4 rounded shadow-sm flex items-center"
                    >
                        <div class="flex-1">
                            <div class="text-sm text-gray-500">
                                Unread Messages
                            </div>
                            <div class="text-2xl font-semibold">
                                {{ stats.unreadContacts }}
                            </div>
                        </div>
                        <div class="text-red-500 text-3xl">✉️</div>
                    </div>

                    <div
                        class="bg-white p-4 rounded shadow-sm flex items-center"
                    >
                        <div class="flex-1">
                            <div class="text-sm text-gray-500">
                                Published Blogs
                            </div>
                            <div class="text-2xl font-semibold">
                                {{ stats.publishedBlogs }}
                            </div>
                        </div>
                        <div class="text-purple-500 text-3xl">📰</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Recent messages -->
                    <div class="lg:col-span-2 bg-white rounded shadow-sm p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-xl font-semibold">
                                Recent Messages
                            </h2>
                            <button
                                @click="loadRecentContacts"
                                class="text-sm text-blue-600 hover:underline"
                            >
                                Refresh
                            </button>
                        </div>

                        <div
                            v-if="contactsLoading"
                            class="py-8 text-center text-gray-500"
                        >
                            Loading...
                        </div>

                        <div v-else>
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-sm text-gray-600">
                                        <th class="p-2">Name</th>
                                        <th class="p-2">Subject</th>
                                        <th class="p-2">Message</th>
                                        <th class="p-2">Seen</th>
                                        <th class="p-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="c in recentContacts"
                                        :key="c.id"
                                        class="border-t"
                                    >
                                        <td class="p-2">{{ c.name }}</td>
                                        <td class="p-2">{{ c.subject }}</td>
                                        <td class="p-2 max-w-xs truncate">
                                            {{ c.message }}
                                        </td>
                                        <td class="p-2">
                                            <span
                                                v-if="c.is_seen"
                                                class="px-2 py-1 rounded bg-gray-100 text-sm text-gray-700"
                                            >
                                                Seen
                                            </span>
                                            <span
                                                v-else
                                                class="px-2 py-1 rounded bg-red-100 text-sm text-red-700"
                                            >
                                                New
                                            </span>
                                        </td>
                                        <td class="p-2">
                                            <button
                                                v-if="!c.is_seen"
                                                @click="markSeen(c)"
                                                class="bg-blue-600 text-white px-3 py-1 rounded mr-2 text-sm"
                                            >
                                                Mark Seen
                                            </button>
                                            <button
                                                @click="deleteContact(c.id)"
                                                class="bg-red-500 text-white px-3 py-1 rounded text-sm"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div
                                v-if="recentContacts.length === 0"
                                class="py-6 text-center text-gray-500"
                            >
                                No recent messages.
                            </div>
                        </div>
                    </div>

                    <!-- Latest projects -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-xl font-semibold">
                                Latest Projects
                            </h2>
                            <button
                                @click="loadLatestProjects"
                                class="text-sm text-blue-600 hover:underline"
                            >
                                Refresh
                            </button>
                        </div>

                        <div
                            v-if="projectsLoading"
                            class="py-8 text-center text-gray-500"
                        >
                            Loading...
                        </div>

                        <ul v-else class="space-y-3">
                            <li
                                v-for="p in latestProjects"
                                :key="p.id"
                                class="flex items-start gap-3 border rounded p-3"
                            >
                                <div
                                    class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center text-gray-400"
                                >
                                    <!-- thumbnail placeholder -->
                                    <img
                                        v-if="p.thumbnail"
                                        :src="p.thumbnail"
                                        alt=""
                                        class="w-full h-full object-cover rounded"
                                    />
                                    <span v-else>📷</span>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold">
                                        {{ p.title }}
                                    </div>
                                    <div class="text-sm text-gray-500 truncate">
                                        {{ p.tech_stack }}
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <div
                            v-if="latestProjects.length === 0"
                            class="py-6 text-center text-gray-500"
                        >
                            No projects yet.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import Swal from "sweetalert2";

import Sidebar from "../components/Sidebar.vue";
import Topbar from "../components/Topbar.vue";
import api from "../services/api";

const toast = useToast();

// state
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

// small helper to normalize absolute URL -> relative (we used similar earlier)
function normalizeUrl(url) {
    if (typeof url !== "string") return url;
    try {
        if (url.startsWith("http")) {
            const u = new URL(url);
            return u.pathname + u.search;
        }
    } catch (e) {
        // ignore
    }
    return url;
}

/* Load all counts & small lists */
const loadStats = async () => {
    try {
        // we fetch index for each resource and derive counts
        // If your API returns meta counts in a single endpoint, you can replace with that
        // Projects
        const pr = await api.get(normalizeUrl("/api/admin/projects"));
        stats.value.projects = Array.isArray(pr.data)
            ? pr.data.length
            : pr.data?.data?.length ?? 0;

        // Skills
        const sk = await api.get(normalizeUrl("/api/admin/skills"));
        stats.value.skills = Array.isArray(sk.data)
            ? sk.data.length
            : sk.data?.data?.length ?? 0;

        // Experiences
        const ex = await api.get(normalizeUrl("/api/admin/experiences"));
        stats.value.experiences = Array.isArray(ex.data)
            ? ex.data.length
            : ex.data?.data?.length ?? 0;

        // Contacts — unread
        const co = await api.get(normalizeUrl("/api/admin/contacts"));
        // compute unread
        const allContacts = Array.isArray(co.data)
            ? co.data
            : co.data?.data ?? [];
        stats.value.unreadContacts = allContacts.filter(
            (c) => !c.is_seen
        ).length;

        // Blogs — published count
        const bl = await api.get(normalizeUrl("/api/admin/blogs"));
        const allBlogs = Array.isArray(bl.data) ? bl.data : bl.data?.data ?? [];
        stats.value.publishedBlogs = allBlogs.filter(
            (b) => b.is_published || b.published === true
        ).length;
    } catch (err) {
        console.error("loadStats error", err);
        toast.error("Failed to load dashboard stats");
    }
};

/* Recent contacts (latest 5) */
const loadRecentContacts = async () => {
    contactsLoading.value = true;
    try {
        // If your API supports sorting or per_page, use query params: ?per_page=5&sort=-created_at
        const res = await api.get(normalizeUrl("/api/admin/contacts"), {
            params: { per_page: 5 },
        });
        const data = Array.isArray(res.data) ? res.data : res.data?.data ?? [];
        // sort by created_at desc if timestamp present
        recentContacts.value = data
            .slice()
            .sort((a, b) => {
                if (a.created_at && b.created_at)
                    return new Date(b.created_at) - new Date(a.created_at);
                return b.id - a.id;
            })
            .slice(0, 5);
    } catch (err) {
        console.error("loadRecentContacts", err);
        toast.error("Failed to load messages");
    } finally {
        contactsLoading.value = false;
    }
};

/* Latest projects */
const loadLatestProjects = async () => {
    projectsLoading.value = true;
    try {
        const res = await api.get(normalizeUrl("/api/admin/projects"), {
            params: { per_page: 6 },
        });
        const data = Array.isArray(res.data) ? res.data : res.data?.data ?? [];
        // newest first by created_at or id
        latestProjects.value = data
            .slice()
            .sort((a, b) => {
                if (a.created_at && b.created_at)
                    return new Date(b.created_at) - new Date(a.created_at);
                return b.id - a.id;
            })
            .slice(0, 6);
    } catch (err) {
        console.error("loadLatestProjects", err);
        toast.error("Failed to load projects");
    } finally {
        projectsLoading.value = false;
    }
};

/* Mark a contact as seen */
const markSeen = async (contact) => {
    try {
        const confirm = await Swal.fire({
            title: "Mark as seen?",
            text: `Mark message from "${contact.name}" as seen?`,
            icon: "question",
            showCancelButton: true,
        });

        if (!confirm.isConfirmed) return;

        // patch/put to update is_seen. Backend expects PUT /api/admin/contacts/{id}
        await api.put(normalizeUrl(`/api/admin/contacts/${contact.id}`), {
            ...contact,
            is_seen: true,
        });

        toast.success("Marked as seen");
        // update local list and stats
        contact.is_seen = true;
        stats.value.unreadContacts = Math.max(
            0,
            stats.value.unreadContacts - 1
        );
    } catch (err) {
        console.error("markSeen error", err);
        toast.error("Could not mark as seen");
    }
};

/* Delete contact */
const deleteContact = async (id) => {
    try {
        const confirm = await Swal.fire({
            title: "Delete message?",
            text: "This action cannot be undone",
            icon: "warning",
            showCancelButton: true,
        });

        if (!confirm.isConfirmed) return;

        await api.delete(normalizeUrl(`/api/admin/contacts/${id}`));
        toast.success("Message deleted");
        // remove locally
        recentContacts.value = recentContacts.value.filter((c) => c.id !== id);
        // reload stats to sync
        await loadStats();
    } catch (err) {
        console.error("deleteContact", err);
        toast.error("Could not delete message");
    }
};

onMounted(async () => {
    await Promise.all([
        loadStats(),
        loadRecentContacts(),
        loadLatestProjects(),
    ]);
});
</script>

<style scoped>
/* small tweaks */
.table-img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 4px;
}
</style>
