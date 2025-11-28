<template>
    <div class="min-h-screen space-y-6">
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-4"
        >
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">
                    Technical
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400"
                        >Expertise</span
                    >
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Manage your skills and proficiency levels.
                </p>
            </div>

            <button
                @click="openCreateModal"
                class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-emerald-500/20 transition-all hover:-translate-y-0.5"
            >
                <Plus class="w-5 h-5" />
                <span>Add Skill</span>
            </button>
        </div>

        <div
            class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row gap-4 justify-between items-center shadow-sm"
        >
            <div class="relative w-full md:w-80 group">
                <Search
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 group-focus-within:text-emerald-400 transition-colors"
                />
                <input
                    v-model="search"
                    @input="loadSkills('/api/admin/skills')"
                    type="text"
                    placeholder="Search skills (e.g. Python, Vue)..."
                    class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/50 transition-all placeholder:text-slate-600"
                />
            </div>
            <div class="text-xs text-slate-500 font-medium">
                Total Skills:
                <span class="text-emerald-400">{{
                    pagination.total || skills.length
                }}</span>
            </div>
        </div>

        <div
            v-if="loading"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
        >
            <div
                v-for="n in 6"
                :key="n"
                class="bg-slate-900 border border-slate-800 rounded-2xl p-6 animate-pulse space-y-4"
            >
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-800 rounded-xl"></div>
                    <div class="flex-1 space-y-2">
                        <div class="h-4 bg-slate-800 rounded w-1/2"></div>
                        <div class="h-3 bg-slate-800 rounded w-1/3"></div>
                    </div>
                </div>
                <div class="h-2 bg-slate-800 rounded-full w-full"></div>
            </div>
        </div>

        <div
            v-else
            class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6"
        >
            <div
                v-for="skill in skills"
                :key="skill.id"
                class="group bg-slate-900 border border-slate-800 hover:border-emerald-500/30 rounded-2xl p-5 shadow-lg transition-all hover:-translate-y-1 relative overflow-hidden"
            >
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-all"
                ></div>

                <div class="flex justify-between items-start relative z-10">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-slate-800/50 flex items-center justify-center border border-slate-700 p-2.5 transition-transform group-hover:scale-110"
                        >
                            <img
                                :src="getSkillIcon(skill.name)"
                                @error="handleIconError"
                                alt="icon"
                                class="w-full h-full object-contain filter drop-shadow-lg"
                            />
                        </div>

                        <div>
                            <h3 class="font-bold text-white text-lg">
                                {{ skill.name }}
                            </h3>
                            <span
                                class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-800 text-slate-400 border border-slate-700"
                            >
                                {{ skill.category }}
                            </span>
                        </div>
                    </div>

                    <div
                        class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity"
                    >
                        <button
                            @click="editSkill(skill)"
                            class="p-2 text-amber-400 hover:bg-amber-500/10 rounded-lg transition-colors"
                        >
                            <Edit3 class="w-4 h-4" />
                        </button>
                        <button
                            @click="confirmDelete(skill.id)"
                            class="p-2 text-rose-400 hover:bg-rose-500/10 rounded-lg transition-colors"
                        >
                            <Trash2 class="w-4 h-4" />
                        </button>
                    </div>
                </div>

                <div class="mt-6 relative z-10">
                    <div
                        class="flex justify-between text-xs mb-1.5 font-medium"
                    >
                        <span class="text-slate-400">Proficiency</span>
                        <span class="text-white">{{ skill.percentage }}%</span>
                    </div>
                    <div
                        class="w-full bg-slate-950 rounded-full h-2.5 overflow-hidden border border-slate-800"
                    >
                        <div
                            class="bg-gradient-to-r from-emerald-500 to-cyan-500 h-full rounded-full transition-all duration-1000 ease-out relative"
                            :style="{ width: skill.percentage + '%' }"
                        >
                            <div
                                class="absolute inset-0 bg-white/20 w-full h-full animate-shimmer"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>

            <button
                @click="openCreateModal"
                class="border-2 border-dashed border-slate-800 rounded-2xl p-6 flex flex-col items-center justify-center gap-3 text-slate-500 hover:text-emerald-400 hover:border-emerald-500/30 hover:bg-emerald-500/5 transition-all group min-h-[160px]"
            >
                <div
                    class="w-12 h-12 rounded-full bg-slate-900 flex items-center justify-center group-hover:scale-110 transition-transform"
                >
                    <Plus class="w-6 h-6" />
                </div>
                <span class="font-medium text-sm">Add New Skill</span>
            </button>
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
                @click="loadSkills(pagination.prev_page_url)"
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
                @click="loadSkills(pagination.next_page_url)"
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
                    class="bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
                    @click.stop
                >
                    <div
                        class="p-6 border-b border-slate-800 flex justify-between items-center bg-slate-900"
                    >
                        <h2 class="text-xl font-bold text-white">
                            {{ editMode ? "Edit Skill" : "Add New Skill" }}
                        </h2>
                        <button
                            @click="closeModal"
                            class="text-slate-400 hover:text-white transition-colors"
                        >
                            <X class="w-6 h-6" />
                        </button>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Skill Name</label
                            >
                            <input
                                v-model="form.name"
                                type="text"
                                placeholder="e.g. Python"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/50 transition-all placeholder:text-slate-600"
                            />
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Category</label
                            >
                            <select
                                v-model="form.category"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/50 transition-all"
                            >
                                <option value="Frontend">Frontend</option>
                                <option value="Backend">Backend</option>
                                <option value="DevOps">DevOps</option>
                                <option value="Tools">Tools</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Proficiency</label
                            >
                            <input
                                v-model="form.percentage"
                                type="range"
                                min="1"
                                max="100"
                                class="w-full h-2 bg-slate-800 rounded-lg cursor-pointer accent-emerald-500"
                            />
                        </div>
                    </div>
                    <div
                        class="p-6 border-t border-slate-800 bg-slate-900 flex justify-end gap-3"
                    >
                        <button
                            @click="closeModal"
                            class="px-5 py-2.5 rounded-xl font-medium text-slate-300 hover:text-white hover:bg-slate-800"
                        >
                            Cancel
                        </button>
                        <button
                            @click="editMode ? updateSkill() : createSkill()"
                            class="px-5 py-2.5 rounded-xl font-medium bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg"
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
} from "lucide-vue-next";

// State & Logic
const toast = useToast();
const skills = ref([]);
const pagination = ref({});
const showModal = ref(false);
const editMode = ref(false);
const search = ref("");
const loading = ref(false);

const form = ref({
    id: null,
    name: "",
    category: "Frontend",
    percentage: 50,
    icon: "",
});

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

// Fallback image if icon not found
const handleIconError = (e) => {
    // Fallback to a generic code icon
    e.target.src = "https://cdn.simpleicons.org/codesandbox/gray";
};

// Helper Functions
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

const loadSkills = async (url = "/api/admin/skills") => {
    loading.value = true;
    try {
        const res = await api.get(normalizeUrl(url), {
            params: { search: search.value },
        });
        skills.value = res.data.data ?? res.data;
        pagination.value = res.data.meta || res.data;
    } catch (err) {
        toast.error("Failed to load skills");
    } finally {
        loading.value = false;
    }
};

const createSkill = async () => {
    await api.post("/api/admin/skills", form.value);
    showModal.value = false;
    loadSkills();
    toast.success("Skill created!");
};
const updateSkill = async () => {
    await api.put(`/api/admin/skills/${form.value.id}`, form.value);
    showModal.value = false;
    loadSkills();
    toast.success("Skill updated!");
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
            await api.delete(`/api/admin/skills/${id}`);
            loadSkills();
            toast.success("Deleted!");
        }
    });
};
const openCreateModal = () => {
    editMode.value = false;
    showModal.value = true;
    form.value = {
        id: null,
        name: "",
        category: "Frontend",
        percentage: 50,
        icon: "",
    };
};
const editSkill = (s) => {
    editMode.value = true;
    showModal.value = true;
    form.value = { ...s };
};
const closeModal = () => (showModal.value = false);

onMounted(loadSkills);
</script>

<style scoped>
@keyframes shimmer {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}
.animate-shimmer {
    animation: shimmer 2s infinite linear;
}
</style>
