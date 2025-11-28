<template>
    <div class="min-h-screen space-y-6">
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-4"
        >
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">
                    Inbox &
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400"
                        >Inquiries</span
                    >
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Manage messages from your portfolio visitors.
                </p>
            </div>
        </div>

        <div
            class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row gap-4 justify-between items-center shadow-sm"
        >
            <div class="relative w-full md:w-80 group">
                <Search
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 group-focus-within:text-cyan-400 transition-colors"
                />
                <input
                    v-model="search"
                    @input="loadContacts('/api/admin/contacts')"
                    type="text"
                    placeholder="Search by name or email..."
                    class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 transition-all placeholder:text-slate-600"
                />
            </div>
            <div class="text-xs text-slate-500 font-medium">
                Total Messages:
                <span class="text-cyan-400">{{
                    pagination.total || contacts.length
                }}</span>
            </div>
        </div>

        <div v-if="loading" class="space-y-4">
            <div
                v-for="n in 5"
                :key="n"
                class="bg-slate-900 border border-slate-800 rounded-2xl p-5 animate-pulse flex items-center gap-4"
            >
                <div class="w-10 h-10 bg-slate-800 rounded-full shrink-0"></div>
                <div class="flex-1 space-y-2">
                    <div class="h-4 bg-slate-800 rounded w-1/4"></div>
                    <div class="h-3 bg-slate-800 rounded w-1/2"></div>
                </div>
                <div class="h-8 w-20 bg-slate-800 rounded"></div>
            </div>
        </div>

        <div
            v-else
            class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-lg"
        >
            <div class="divide-y divide-slate-800">
                <div
                    v-for="c in contacts"
                    :key="c.id"
                    class="group flex flex-col md:flex-row md:items-center gap-4 p-5 hover:bg-slate-800/40 transition-colors cursor-pointer relative"
                    :class="!c.is_seen ? 'bg-slate-800/20' : ''"
                >
                    <div
                        v-if="!c.is_seen"
                        class="absolute left-0 top-0 bottom-0 w-1 bg-cyan-500"
                    ></div>

                    <div class="flex items-center gap-4 min-w-[200px]">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center text-slate-300 font-bold border border-slate-700 shrink-0"
                        >
                            {{ c.name.charAt(0).toUpperCase() }}
                        </div>
                        <div>
                            <h3
                                class="text-sm font-bold text-white truncate"
                                :class="
                                    !c.is_seen
                                        ? 'text-cyan-100'
                                        : 'text-slate-300'
                                "
                            >
                                {{ c.name }}
                            </h3>
                            <p class="text-xs text-slate-500 truncate">
                                {{ c.email }}
                            </p>
                        </div>
                    </div>

                    <div class="flex-1 min-w-0 md:px-4">
                        <div class="flex items-center gap-2 mb-1">
                            <span
                                class="text-sm font-medium text-slate-200 truncate"
                                >{{ c.subject }}</span
                            >
                            <span
                                v-if="!c.is_seen"
                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-cyan-500/20 text-cyan-400 border border-cyan-500/30"
                                >NEW</span
                            >
                        </div>
                        <p
                            class="text-sm text-slate-500 truncate group-hover:text-slate-400 transition-colors"
                        >
                            {{ c.message }}
                        </p>
                    </div>

                    <div
                        class="flex items-center justify-between md:justify-end gap-4 min-w-[140px]"
                    >
                        <span
                            class="text-xs text-slate-600 whitespace-nowrap"
                            >{{
                                new Date(c.created_at).toLocaleDateString()
                            }}</span
                        >

                        <div
                            class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity"
                        >
                            <button
                                v-if="!c.is_seen"
                                @click.stop="markSeen(c.id)"
                                class="p-2 text-cyan-400 bg-slate-800 hover:bg-cyan-500/20 rounded-lg transition-colors"
                                title="Mark Read"
                            >
                                <CheckCircle class="w-4 h-4" />
                            </button>

                            <button
                                @click.stop="openMessageModal(c)"
                                class="p-2 text-slate-400 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors"
                                title="View"
                            >
                                <Eye class="w-4 h-4" />
                            </button>

                            <button
                                @click.stop="confirmDelete(c.id)"
                                class="p-2 text-rose-400 bg-slate-800 hover:bg-rose-500/20 rounded-lg transition-colors"
                                title="Delete"
                            >
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    v-if="!loading && contacts.length === 0"
                    class="p-16 text-center"
                >
                    <div
                        class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4"
                    >
                        <Mail class="w-8 h-8 text-slate-600" />
                    </div>
                    <h3 class="text-slate-300 font-medium">
                        No messages found
                    </h3>
                    <p class="text-slate-500 text-sm mt-1">
                        Your inbox is empty.
                    </p>
                </div>
            </div>

            <div
                v-if="
                    !loading &&
                    (pagination.prev_page_url || pagination.next_page_url)
                "
                class="p-4 border-t border-slate-800 bg-slate-900/50 flex justify-between items-center"
            >
                <button
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                    :class="
                        !pagination.prev_page_url
                            ? 'text-slate-600 cursor-not-allowed'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    "
                    :disabled="!pagination.prev_page_url"
                    @click="loadContacts(pagination.prev_page_url)"
                >
                    <ChevronLeft class="w-4 h-4" /> Previous
                </button>
                <button
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                    :class="
                        !pagination.next_page_url
                            ? 'text-slate-600 cursor-not-allowed'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    "
                    :disabled="!pagination.next_page_url"
                    @click="loadContacts(pagination.next_page_url)"
                >
                    Next <ChevronRight class="w-4 h-4" />
                </button>
            </div>
        </div>

        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="selectedMessage"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-sm"
            >
                <div
                    class="bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]"
                    @click.stop
                >
                    <div
                        class="p-6 border-b border-slate-800 flex justify-between items-center bg-slate-900"
                    >
                        <h2 class="text-xl font-bold text-white">
                            Message Details
                        </h2>
                        <button
                            @click="closeModal"
                            class="text-slate-400 hover:text-white transition-colors"
                        >
                            <X class="w-6 h-6" />
                        </button>
                    </div>

                    <div class="p-8 overflow-y-auto custom-scrollbar space-y-6">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center text-lg font-bold text-slate-300 border border-slate-700"
                            >
                                {{
                                    selectedMessage.name.charAt(0).toUpperCase()
                                }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white">
                                    {{ selectedMessage.name }}
                                </h3>
                                <a
                                    :href="`mailto:${selectedMessage.email}`"
                                    class="text-sm text-cyan-400 hover:underline"
                                    >{{ selectedMessage.email }}</a
                                >
                            </div>
                            <div class="ml-auto text-xs text-slate-500">
                                {{
                                    new Date(
                                        selectedMessage.created_at
                                    ).toLocaleString()
                                }}
                            </div>
                        </div>

                        <div
                            class="bg-slate-950 border border-slate-800 rounded-xl p-6"
                        >
                            <h4
                                class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2"
                            >
                                Subject
                            </h4>
                            <p class="text-slate-200 font-medium mb-6">
                                {{ selectedMessage.subject }}
                            </p>

                            <h4
                                class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2"
                            >
                                Message
                            </h4>
                            <p
                                class="text-slate-300 leading-relaxed whitespace-pre-wrap"
                            >
                                {{ selectedMessage.message }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="p-6 border-t border-slate-800 bg-slate-900 flex justify-end gap-3"
                    >
                        <button
                            @click="closeModal"
                            class="px-5 py-2.5 rounded-xl font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-colors"
                        >
                            Close
                        </button>
                        <a
                            :href="`mailto:${selectedMessage.email}`"
                            class="px-5 py-2.5 rounded-xl font-medium bg-cyan-600 hover:bg-cyan-500 text-white shadow-lg shadow-cyan-600/20 transition-all flex items-center gap-2"
                        >
                            <Reply class="w-4 h-4" /> Reply
                        </a>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import Swal from "sweetalert2";
import api from "../services/api";
import {
    Search,
    Trash2,
    CheckCircle,
    ChevronLeft,
    ChevronRight,
    Mail,
    X,
    Eye,
    Reply,
} from "lucide-vue-next";

const toast = useToast();
const contacts = ref([]);
const pagination = ref({});
const search = ref("");
const loading = ref(false);
const selectedMessage = ref(null);

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

const loadContacts = async (url = "/api/admin/contacts") => {
    loading.value = true;
    try {
        const res = await api.get(normalizeUrl(url), {
            params: { search: search.value },
        });
        contacts.value = res.data.data ?? res.data;
        pagination.value = res.data.meta || res.data;
    } catch (err) {
        toast.error("Failed to load messages");
    } finally {
        loading.value = false;
    }
};

onMounted(loadContacts);

const markSeen = async (id) => {
    try {
        await api.put(`/api/admin/contacts/${id}`, { is_seen: true });
        toast.success("Marked as seen!");

        // Update local state without reload
        const msg = contacts.value.find((c) => c.id === id);
        if (msg) msg.is_seen = true;
    } catch (e) {
        toast.error("Failed to update status");
    }
};

const confirmDelete = (id) => {
    Swal.fire({
        title: "Delete Message?",
        text: "This cannot be undone.",
        icon: "warning",
        background: "#1e293b",
        color: "#fff",
        showCancelButton: true,
        confirmButtonColor: "#ef4444",
        cancelButtonColor: "#64748b",
        confirmButtonText: "Yes, delete",
    }).then(async (result) => {
        if (result.isConfirmed) {
            await api.delete(`/api/admin/contacts/${id}`);
            loadContacts();
            toast.success("Message deleted!");
        }
    });
};

const openMessageModal = (msg) => {
    selectedMessage.value = msg;
    if (!msg.is_seen) markSeen(msg.id); // Auto mark read on open
};

const closeModal = () => {
    selectedMessage.value = null;
};
</script>
