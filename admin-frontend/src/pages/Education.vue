<template>
    <div class="min-h-screen space-y-6">
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-4"
        >
            <div>
                <h1
                    class="text-2xl md:text-3xl font-bold text-white tracking-tight"
                >
                    Academic
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-violet-400"
                        >Background</span
                    >
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Showcase your degrees and certifications.
                </p>
            </div>

            <button
                @click="openCreateModal"
                class="w-full md:w-auto flex justify-center items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-indigo-500/20 transition-all active:scale-95"
            >
                <Plus class="w-5 h-5" />
                <span>Add Education</span>
            </button>
        </div>

        <div
            class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row gap-4 justify-between items-center shadow-sm"
        >
            <div class="relative w-full md:w-80 group">
                <Search
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 group-focus-within:text-indigo-400 transition-colors"
                />
                <input
                    v-model="search"
                    @input="loadEducation('/api/admin/education')"
                    type="text"
                    placeholder="Search degree or institution..."
                    class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-sm rounded-xl pl-10 pr-4 py-3 md:py-2.5 focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/50 transition-all placeholder:text-slate-600"
                />
            </div>
            <div class="hidden md:block text-xs text-slate-500 font-medium">
                Qualifications:
                <span class="text-indigo-400">{{
                    pagination.total || education.length
                }}</span>
            </div>
        </div>

        <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
                v-for="n in 4"
                :key="n"
                class="bg-slate-900 border border-slate-800 rounded-2xl p-6 animate-pulse flex flex-col md:flex-row gap-4"
            >
                <div class="w-14 h-14 bg-slate-800 rounded-xl shrink-0"></div>
                <div class="flex-1 space-y-3 w-full">
                    <div class="h-5 bg-slate-800 rounded w-3/4"></div>
                    <div class="h-4 bg-slate-800 rounded w-1/2"></div>
                    <div class="h-10 bg-slate-800 rounded w-full"></div>
                </div>
            </div>
        </div>

        <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
            <div
                v-for="edu in education"
                :key="edu.id"
                class="group bg-slate-900 border border-slate-800 hover:border-indigo-500/30 rounded-2xl p-5 md:p-6 shadow-lg transition-all hover:-translate-y-1 relative overflow-hidden"
            >
                <GraduationCap
                    class="hidden md:block absolute -bottom-4 -right-4 w-32 h-32 text-slate-800/50 transform rotate-12 group-hover:text-indigo-900/20 transition-colors pointer-events-none"
                />

                <div
                    class="relative z-10 flex flex-col sm:flex-row items-start gap-4 sm:gap-5"
                >
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/20 shrink-0 group-hover:scale-110 transition-transform"
                    >
                        <School class="w-6 h-6 sm:w-7 sm:h-7" />
                    </div>

                    <div class="flex-1 min-w-0 w-full">
                        <div
                            class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 sm:gap-0"
                        >
                            <div>
                                <h3
                                    class="text-lg font-bold text-white leading-tight group-hover:text-indigo-300 transition-colors"
                                >
                                    {{ edu.degree }}
                                </h3>
                                <p
                                    class="text-sm text-slate-400 mt-1 font-medium"
                                >
                                    {{ edu.institution }}
                                </p>
                            </div>

                            <span
                                class="self-start sm:self-auto inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-800 text-xs font-semibold text-indigo-300 border border-slate-700 whitespace-nowrap"
                            >
                                <Calendar class="w-3 h-3" /> {{ edu.duration }}
                            </span>
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-800/50">
                            <p class="text-sm text-slate-500 line-clamp-2">
                                {{ edu.description }}
                            </p>
                        </div>

                        <div
                            class="mt-4 flex gap-3 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity md:translate-y-2 md:group-hover:translate-y-0"
                        >
                            <button
                                @click="editEducation(edu)"
                                class="flex items-center gap-1.5 px-3 py-1.5 md:px-0 md:py-0 rounded-lg bg-slate-800 md:bg-transparent text-xs font-medium text-amber-400 hover:text-amber-300 transition-colors"
                            >
                                <Edit3 class="w-3.5 h-3.5" /> Edit
                            </button>
                            <div
                                class="hidden md:block w-px h-4 bg-slate-700"
                            ></div>
                            <button
                                @click="confirmDelete(edu.id)"
                                class="flex items-center gap-1.5 px-3 py-1.5 md:px-0 md:py-0 rounded-lg bg-slate-800 md:bg-transparent text-xs font-medium text-rose-400 hover:text-rose-300 transition-colors"
                            >
                                <Trash2 class="w-3.5 h-3.5" /> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div
                v-if="!loading && education.length === 0"
                class="col-span-full py-12 text-center border-2 border-dashed border-slate-800 rounded-2xl"
            >
                <div
                    class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4"
                >
                    <GraduationCap class="w-8 h-8 text-slate-600" />
                </div>
                <h3 class="text-slate-300 font-medium">
                    No education history found
                </h3>
                <p class="text-slate-500 text-sm mt-1">
                    Add your degrees to showcase your background.
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
                @click="loadEducation(pagination.prev_page_url)"
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
                @click="loadEducation(pagination.next_page_url)"
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
                        class="p-5 md:p-6 border-b border-slate-800 flex justify-between items-center bg-slate-900 shrink-0"
                    >
                        <h2 class="text-lg md:text-xl font-bold text-white">
                            {{ editMode ? "Edit Education" : "Add Education" }}
                        </h2>
                        <button
                            @click="closeModal"
                            class="text-slate-400 hover:text-white transition-colors"
                        >
                            <X class="w-6 h-6" />
                        </button>
                    </div>

                    <div
                        class="p-5 md:p-6 overflow-y-auto custom-scrollbar space-y-5"
                    >
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Degree / Certificate</label
                            >
                            <input
                                v-model="form.degree"
                                type="text"
                                placeholder="e.g. BSc in Computer Science"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 md:py-2.5 text-slate-200 text-sm focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/50 transition-all placeholder:text-slate-600"
                            />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label
                                    class="text-xs font-semibold text-slate-400 uppercase"
                                    >Institution</label
                                >
                                <div class="relative">
                                    <School
                                        class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                                    />
                                    <input
                                        v-model="form.institution"
                                        type="text"
                                        placeholder="e.g. Harvard"
                                        class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 md:py-2.5 text-slate-200 text-sm focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/50 transition-all placeholder:text-slate-600"
                                    />
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-xs font-semibold text-slate-400 uppercase"
                                    >Passing Year</label
                                >
                                <div class="relative">
                                    <Calendar
                                        class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                                    />
                                    <input
                                        v-model="form.duration"
                                        type="text"
                                        placeholder="e.g. 2019 - 2023"
                                        class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 md:py-2.5 text-slate-200 text-sm focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/50 transition-all placeholder:text-slate-600"
                                    />
                                </div>
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
                                placeholder="Brief details about major, achievements..."
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 md:py-2.5 text-slate-200 text-sm focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/50 transition-all placeholder:text-slate-600 custom-scrollbar"
                            ></textarea>
                        </div>
                    </div>

                    <div
                        class="p-5 md:p-6 border-t border-slate-800 bg-slate-900 flex justify-end gap-3 shrink-0"
                    >
                        <button
                            @click="closeModal"
                            class="px-5 py-2.5 rounded-xl font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-colors text-sm"
                        >
                            Cancel
                        </button>
                        <button
                            @click="
                                editMode ? updateEducation() : createEducation()
                            "
                            class="w-full md:w-auto px-5 py-2.5 rounded-xl font-medium bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-600/20 transition-all text-sm flex justify-center"
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
    School,
    GraduationCap,
} from "lucide-vue-next";

const toast = useToast();
const education = ref([]);
const pagination = ref({});
const showModal = ref(false);
const editMode = ref(false);
const search = ref("");
const loading = ref(false);

const form = ref({
    id: null,
    degree: "",
    institution: "",
    duration: "",
    description: "",
});

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

const loadEducation = async (url = "/api/admin/education") => {
    loading.value = true;
    try {
        const res = await api.get(normalizeUrl(url), {
            params: { search: search.value },
        });
        education.value = res.data.data ?? res.data;
        pagination.value = res.data.meta || res.data;
    } catch (err) {
        toast.error("Failed to load education");
    } finally {
        loading.value = false;
    }
};

onMounted(loadEducation);

const createEducation = async () => {
    try {
        await api.post("/api/admin/education", form.value);
        showModal.value = false;
        loadEducation();
        toast.success("Education created!");
    } catch (err) {
        if (err.response && err.response.status === 422) {
            toast.error(Object.values(err.response.data.errors)[0][0]);
        } else {
            toast.error("Failed to create!");
        }
    }
};

const updateEducation = async () => {
    try {
        await api.put(`/api/admin/education/${form.value.id}`, form.value);
        showModal.value = false;
        loadEducation();
        toast.success("Education updated!");
    } catch (err) {
        toast.error("Failed to update!");
    }
};

const confirmDelete = (id) => {
    Swal.fire({
        title: "Delete?",
        icon: "warning",
        background: "#1e293b",
        color: "#fff",
        showCancelButton: true,
        confirmButtonColor: "#ef4444",
        cancelButtonColor: "#64748b",
        confirmButtonText: "Yes",
    }).then(async (result) => {
        if (result.isConfirmed) {
            await api.delete(`/api/admin/education/${id}`);
            loadEducation();
            toast.success("Deleted!");
        }
    });
};

const openCreateModal = () => {
    editMode.value = false;
    showModal.value = true;
    form.value = {
        id: null,
        degree: "",
        institution: "",
        duration: "",
        description: "",
    };
};

const editEducation = (edu) => {
    editMode.value = true;
    showModal.value = true;
    form.value = { ...edu };
};

const closeModal = () => (showModal.value = false);
</script>
