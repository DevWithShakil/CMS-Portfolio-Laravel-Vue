<template>
    <div class="flex">
        <Sidebar />

        <div class="flex-1 ml-64">
            <Topbar />

            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Experience</h1>

                    <button
                        class="bg-blue-600 text-white px-4 py-2 rounded"
                        @click="openCreateModal"
                    >
                        + Add Experience
                    </button>
                </div>

                <!-- Search -->
                <input
                    v-model="search"
                    @input="loadExperiences"
                    type="text"
                    placeholder="Search experiences..."
                    class="border p-2 rounded w-64 mb-3"
                />

                <!-- Table -->
                <table class="w-full border shadow-md">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Position</th>
                            <th class="p-2 border">Company</th>
                            <th class="p-2 border">Duration</th>
                            <th class="p-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="exp in experiences"
                            :key="exp.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="p-2 border">{{ exp.id }}</td>
                            <td class="p-2 border">{{ exp.position }}</td>
                            <td class="p-2 border">{{ exp.company }}</td>
                            <td class="p-2 border">{{ exp.duration }}</td>

                            <td class="p-2 border">
                                <button
                                    @click="editExperience(exp)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded mr-2"
                                >
                                    Edit
                                </button>

                                <button
                                    @click="confirmDelete(exp.id)"
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
                        @click="loadExperiences(pagination.prev_page_url)"
                    >
                        Prev
                    </button>

                    <button
                        class="px-4 py-1 bg-gray-200 rounded"
                        :disabled="!pagination.next_page_url"
                        @click="loadExperiences(pagination.next_page_url)"
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
                            {{
                                editMode ? "Edit Experience" : "Add Experience"
                            }}
                        </h2>

                        <input
                            v-model="form.position"
                            type="text"
                            placeholder="Job Title"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <input
                            v-model="form.company"
                            type="text"
                            placeholder="Company"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <input
                            v-model="form.duration"
                            type="text"
                            placeholder="Duration (e.g. 2020-2023)"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <textarea
                            v-model="form.description"
                            placeholder="Description"
                            class="w-full mb-3 p-2 border rounded"
                        ></textarea>

                        <div class="flex justify-end">
                            <button
                                @click="closeModal"
                                class="mr-2 px-4 py-2 bg-gray-400 text-white rounded"
                            >
                                Cancel
                            </button>

                            <button
                                @click="
                                    editMode
                                        ? updateExperience()
                                        : createExperience()
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

const experiences = ref([]);
const pagination = ref({});
const showModal = ref(false);
const editMode = ref(false);
const search = ref("");

const form = ref({
    id: null,
    position: "",
    company: "",
    duration: "",
    description: "",
});

/* Load Experiences (Search + Pagination) */
const loadExperiences = async (url = "/api/admin/experiences") => {
    let finalUrl = url;

    if (typeof url !== "string") {
        finalUrl = "/api/admin/experiences";
    } else if (url.startsWith("http")) {
        const u = new URL(url);
        finalUrl = u.pathname + u.search;
    }

    const res = await api.get(finalUrl, {
        params: { search: search.value },
    });

    experiences.value = res.data.data ?? res.data;
    pagination.value = res.data;
};

onMounted(loadExperiences);

/* Create */
const createExperience = async () => {
    await api.post("/api/admin/experiences", form.value);
    showModal.value = false;
    loadExperiences();
    toast.success("Experience created!");
};

/* Edit */
const editExperience = (exp) => {
    editMode.value = true;
    showModal.value = true;
    form.value = { ...exp };
};

/* Update */
const updateExperience = async () => {
    await api.put(`/api/admin/experiences/${form.value.id}`, form.value);
    showModal.value = false;
    loadExperiences();
    toast.success("Experience updated!");
};

/* Delete */
const confirmDelete = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You cannot undo this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e3342f",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete!",
    }).then(async (result) => {
        if (result.isConfirmed) {
            await api.delete(`/api/admin/experiences/${id}`);
            loadExperiences();
            toast.error("Experience deleted!");
        }
    });
};

const openCreateModal = () => {
    editMode.value = false;
    showModal.value = true;

    form.value = {
        id: null,
        Position: "",
        company: "",
        duration: "",
        description: "",
    };
};

const closeModal = () => (showModal.value = false);
</script>
