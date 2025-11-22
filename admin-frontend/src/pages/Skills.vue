<template>
    <div class="flex">
        <Sidebar />

        <div class="flex-1 ml-64">
            <Topbar />

            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Skills</h1>

                    <button
                        class="bg-blue-600 text-white px-4 py-2 rounded"
                        @click="openCreateModal"
                    >
                        + Add Skill
                    </button>
                </div>

                <!-- Search -->
                <input
                    v-model="search"
                    @input="loadSkills"
                    type="text"
                    placeholder="Search skills..."
                    class="border p-2 rounded w-64 mb-3"
                />

                <!-- Skills Table -->
                <table class="w-full border shadow-md">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Name</th>
                            <th class="p-2 border">Category</th>
                            <th class="p-2 border">Percentage</th>
                            <th class="p-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="skill in skills"
                            :key="skill.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="p-2 border">{{ skill.id }}</td>
                            <td class="p-2 border">{{ skill.name }}</td>
                            <td class="p-2 border">{{ skill.category }}</td>
                            <td class="p-2 border">{{ skill.percentage }}%</td>

                            <td class="p-2 border">
                                <button
                                    @click="editSkill(skill)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded mr-2"
                                >
                                    Edit
                                </button>

                                <button
                                    @click="confirmDelete(skill.id)"
                                    class="bg-red-600 text-white px-3 py-1 rounded"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="flex gap-3 mt-4">
                    <button
                        class="px-4 py-1 bg-gray-200 rounded"
                        :disabled="!pagination.prev_page_url"
                        @click="loadSkills(pagination.prev_page_url)"
                    >
                        Prev
                    </button>

                    <button
                        class="px-4 py-1 bg-gray-200 rounded"
                        :disabled="!pagination.next_page_url"
                        @click="loadSkills(pagination.next_page_url)"
                    >
                        Next
                    </button>
                </div>

                <!-- Modal -->
                <div
                    v-if="showModal"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
                >
                    <div class="bg-white p-6 rounded shadow w-96">
                        <h2 class="text-xl font-bold mb-4">
                            {{ editMode ? "Edit Skill" : "Add Skill" }}
                        </h2>

                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Skill Name"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <input
                            v-model="form.category"
                            type="text"
                            placeholder="Category (Frontend / Backend)"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <input
                            v-model="form.percentage"
                            type="number"
                            placeholder="Percentage (1–100)"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <input
                            v-model="form.icon"
                            type="text"
                            placeholder="Icon (optional)"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <div class="flex justify-end">
                            <button
                                @click="closeModal"
                                class="mr-2 px-4 py-2 bg-gray-400 text-white rounded"
                            >
                                Cancel
                            </button>

                            <button
                                @click="
                                    editMode ? updateSkill() : createSkill()
                                "
                                class="px-4 py-2 bg-blue-600 text-white rounded"
                            >
                                {{ editMode ? "Update" : "Create" }}
                            </button>
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
import api from "../services/api";

import Sidebar from "../components/Sidebar.vue";
import Topbar from "../components/Topbar.vue";

const toast = useToast();

const skills = ref([]);
const pagination = ref({});
const showModal = ref(false);
const editMode = ref(false);
const search = ref("");

const form = ref({
    id: null,
    name: "",
    category: "",
    percentage: "",
    icon: "",
});

/* Load Skills with Search + Pagination */
const loadSkills = async (url = "/api/admin/skills") => {
    let finalUrl = url;

    // FIX 1: If url is NOT a string → convert to empty string
    if (typeof url !== "string") {
        finalUrl = "/api/admin/skills";
    }

    // FIX 2: If absolute URL → convert to relative
    else if (url.startsWith("http")) {
        const u = new URL(url);
        finalUrl = u.pathname + u.search;
    }

    const res = await api.get(finalUrl, {
        params: { search: search.value },
    });

    skills.value = res.data.data ?? res.data;
    pagination.value = res.data;
};

onMounted(loadSkills);

/* Create Skill */
const createSkill = async () => {
    await api.post("/api/admin/skills", form.value);
    showModal.value = false;
    loadSkills();
    toast.success("Skill created!");
};

/* Edit Skill */
const editSkill = (skill) => {
    editMode.value = true;
    showModal.value = true;
    form.value = { ...skill };
};

/* Update Skill */
const updateSkill = async () => {
    await api.put(`/api/admin/skills/${form.value.id}`, form.value);
    showModal.value = false;
    loadSkills();
    toast.success("Skill updated successfully!");
};

/* Delete Skill */
const confirmDelete = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You cannot undo this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e3342f",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
    }).then(async (result) => {
        if (result.isConfirmed) {
            await api.delete(`/api/admin/skills/${id}`);
            loadSkills();
            toast.error("Skill deleted!");
        }
    });
};

/* Open Modal */
const openCreateModal = () => {
    editMode.value = false;
    showModal.value = true;

    form.value = {
        id: null,
        name: "",
        category: "",
        percentage: "",
        icon: "",
    };
};

const closeModal = () => (showModal.value = false);
</script>
