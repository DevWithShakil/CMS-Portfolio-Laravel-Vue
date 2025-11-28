<template>
    <div class="min-h-screen space-y-6">
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-4"
        >
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">
                    Professional
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-orange-400"
                        >Experience</span
                    >
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Track your career journey and achievements.
                </p>
            </div>

            <button
                @click="openCreateModal"
                class="flex items-center gap-2 bg-amber-600 hover:bg-amber-500 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-amber-500/20 transition-all hover:-translate-y-0.5"
            >
                <Plus class="w-5 h-5" />
                <span>Add Experience</span>
            </button>
        </div>

        <div
            class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row gap-4 justify-between items-center shadow-sm"
        >
            <div class="relative w-full md:w-80 group">
                <Search
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 group-focus-within:text-amber-400 transition-colors"
                />
                <input
                    v-model="search"
                    @input="loadExperiences('/api/admin/experiences')"
                    type="text"
                    placeholder="Search by role or company..."
                    class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/50 transition-all placeholder:text-slate-600"
                />
            </div>
            <div class="text-xs text-slate-500 font-medium">
                Career Milestones:
                <span class="text-amber-400">{{
                    pagination.total || experiences.length
                }}</span>
            </div>
        </div>

        <div v-if="loading" class="space-y-6">
            <div
                v-for="n in 3"
                :key="n"
                class="bg-slate-900 border border-slate-800 rounded-2xl p-6 animate-pulse flex gap-6"
            >
                <div class="w-16 h-16 bg-slate-800 rounded-xl shrink-0"></div>
                <div class="flex-1 space-y-3">
                    <div class="h-5 bg-slate-800 rounded w-1/3"></div>
                    <div class="h-4 bg-slate-800 rounded w-1/4"></div>
                    <div class="h-16 bg-slate-800 rounded w-full"></div>
                </div>
            </div>
        </div>

        <div v-else class="relative pl-4 md:pl-8 space-y-8">
            <div
                class="absolute left-4 md:left-8 top-0 bottom-0 w-0.5 bg-gradient-to-b from-amber-500/50 via-slate-800 to-transparent"
            ></div>

            <div
                v-for="(exp, index) in experiences"
                :key="exp.id"
                class="relative pl-8 md:pl-12 group"
            >
                <div
                    class="absolute left-0 md:left-4 top-6 -translate-x-1/2 w-4 h-4 rounded-full border-2 border-amber-500 bg-slate-950 group-hover:bg-amber-500 transition-colors shadow-[0_0_10px_rgba(245,158,11,0.4)]"
                ></div>

                <div
                    class="bg-slate-900 border border-slate-800 hover:border-amber-500/30 rounded-2xl p-6 shadow-lg transition-all hover:-translate-y-1 relative overflow-hidden group-hover:shadow-[0_4px_20px_-12px_rgba(245,158,11,0.2)]"
                >
                    <div
                        class="flex flex-col md:flex-row justify-between items-start gap-4"
                    >
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-xl font-bold text-white">
                                    {{ exp.position }}
                                </h3>
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-500/10 text-amber-400 border border-amber-500/20"
                                >
                                    {{ exp.company }}
                                </span>
                            </div>

                            <div
                                class="flex items-center gap-2 text-sm text-slate-400 mb-4"
                            >
                                <Calendar class="w-4 h-4" />
                                <span>{{ exp.duration }}</span>
                            </div>

                            <p
                                class="text-slate-400 text-sm leading-relaxed border-l-2 border-slate-800 pl-4"
                            >
                                {{ exp.description }}
                            </p>
                        </div>

                        <div
                            class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity self-start md:self-center"
                        >
                            <button
                                @click="editExperience(exp)"
                                class="p-2.5 text-amber-400 bg-slate-800 hover:bg-amber-500/20 rounded-xl transition-colors border border-transparent hover:border-amber-500/30"
                            >
                                <Edit3 class="w-4 h-4" />
                            </button>
                            <button
                                @click="confirmDelete(exp.id)"
                                class="p-2.5 text-rose-400 bg-slate-800 hover:bg-rose-500/20 rounded-xl transition-colors border border-transparent hover:border-rose-500/30"
                            >
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="experiences.length === 0" class="text-center py-12 pl-0">
                <div
                    class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4"
                >
                    <Briefcase class="w-8 h-8 text-slate-600" />
                </div>
                <h3 class="text-slate-300 font-medium">
                    No experience added yet
                </h3>
                <p class="text-slate-500 text-sm mt-1">
                    Start building your timeline.
                </p>
            </div>
        </div>

        <div
            v-if="
                !loading &&
                (pagination.prev_page_url || pagination.next_page_url)
            "
            class="flex justify-between items-center bg-slate-900 p-4 rounded-xl border border-slate-800"
        >
            <button
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                :class="
                    !pagination.prev_page_url
                        ? 'text-slate-600 cursor-not-allowed'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                "
                :disabled="!pagination.prev_page_url"
                @click="loadExperiences(pagination.prev_page_url)"
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
                @click="loadExperiences(pagination.next_page_url)"
            >
                Next <ChevronRight class="w-4 h-4" />
            </button>
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
                v-if="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
            >
                <div
                    class="bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col max-h-[90vh]"
                    @click.stop
                >
                    <div
                        class="p-6 border-b border-slate-800 flex justify-between items-center bg-slate-900"
                    >
                        <h2 class="text-xl font-bold text-white">
                            {{
                                editMode ? "Edit Experience" : "Add Experience"
                            }}
                        </h2>
                        <button
                            @click="closeModal"
                            class="text-slate-400 hover:text-white transition-colors"
                        >
                            <X class="w-6 h-6" />
                        </button>
                    </div>

                    <div class="p-6 overflow-y-auto custom-scrollbar space-y-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label
                                    class="text-xs font-semibold text-slate-400 uppercase"
                                    >Job Title</label
                                >
                                <input
                                    v-model="form.position"
                                    type="text"
                                    placeholder="e.g. Senior Developer"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-xs font-semibold text-slate-400 uppercase"
                                    >Company</label
                                >
                                <input
                                    v-model="form.company"
                                    type="text"
                                    placeholder="e.g. Google"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Duration</label
                            >
                            <div class="relative">
                                <Calendar
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                                />
                                <input
                                    v-model="form.duration"
                                    type="text"
                                    placeholder="e.g. Jan 2020 - Present"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2.5 text-slate-200 focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Description</label
                            >
                            <textarea
                                v-model="form.description"
                                rows="4"
                                placeholder="Describe your responsibilities and achievements..."
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/50 transition-all placeholder:text-slate-600 custom-scrollbar"
                            ></textarea>
                        </div>
                    </div>

                    <div
                        class="p-6 border-t border-slate-800 bg-slate-900 flex justify-end gap-3"
                    >
                        <button
                            @click="closeModal"
                            class="px-5 py-2.5 rounded-xl font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-colors"
                        >
                            Cancel
                        </button>
                        <button
                            @click="
                                editMode
                                    ? updateExperience()
                                    : createExperience()
                            "
                            class="px-5 py-2.5 rounded-xl font-medium bg-amber-600 hover:bg-amber-500 text-white shadow-lg shadow-amber-600/20 transition-all"
                        >
                            {{ editMode ? "Update" : "Add" }}
                        </button>
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
    Plus,
    Search,
    Edit3,
    Trash2,
    X,
    ChevronLeft,
    ChevronRight,
    Calendar,
    Briefcase,
} from "lucide-vue-next";

const toast = useToast();
const experiences = ref([]);
const pagination = ref({});
const showModal = ref(false);
const editMode = ref(false);
const search = ref("");
const loading = ref(false);

const form = ref({
    id: null,
    position: "",
    company: "",
    duration: "",
    description: "",
});

// Normalize URL helper
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

const loadExperiences = async (url = "/api/admin/experiences") => {
    loading.value = true;
    try {
        const res = await api.get(normalizeUrl(url), {
            params: { search: search.value },
        });
        experiences.value = res.data.data ?? res.data;
        pagination.value = res.data.meta || res.data;
    } catch (err) {
        toast.error("Failed to load experiences");
    } finally {
        loading.value = false;
    }
};

onMounted(loadExperiences);

const createExperience = async () => {
    await api.post("/api/admin/experiences", form.value);
    showModal.value = false;
    loadExperiences();
    toast.success("Experience created!");
};
const updateExperience = async () => {
    await api.put(`/api/admin/experiences/${form.value.id}`, form.value);
    showModal.value = false;
    loadExperiences();
    toast.success("Experience updated!");
};
const confirmDelete = (id) => {
    Swal.fire({
        title: "Delete?",
        text: "This action cannot be undone.",
        icon: "warning",
        background: "#1e293b",
        color: "#fff",
        showCancelButton: true,
        confirmButtonColor: "#ef4444",
        cancelButtonColor: "#64748b",
        confirmButtonText: "Yes",
    }).then(async (result) => {
        if (result.isConfirmed) {
            await api.delete(`/api/admin/experiences/${id}`);
            loadExperiences();
            toast.success("Deleted!");
        }
    });
};

const openCreateModal = () => {
    editMode.value = false;
    showModal.value = true;
    form.value = {
        id: null,
        position: "",
        company: "",
        duration: "",
        description: "",
    };
};
const editExperience = (exp) => {
    editMode.value = true;
    showModal.value = true;
    form.value = { ...exp };
};
const closeModal = () => (showModal.value = false);
</script>
