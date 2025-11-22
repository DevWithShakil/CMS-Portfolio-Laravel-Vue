<template>
    <div class="flex">
        <Sidebar />

        <div class="flex-1 ml-64">
            <Topbar />

            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Education</h1>

                    <button
                        class="bg-blue-600 text-white px-4 py-2 rounded"
                        @click="openCreateModal"
                    >
                        + Add Education
                    </button>
                </div>

                <!-- Search -->
                <input
                    v-model="search"
                    @input="loadEducation"
                    type="text"
                    placeholder="Search education..."
                    class="border p-2 rounded w-64 mb-3"
                />

                <!-- Table -->
                <table class="w-full border shadow-md">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Degree</th>
                            <th class="p-2 border">Institution</th>
                            <th class="p-2 border">Year</th>
                            <th class="p-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="edu in education"
                            :key="edu.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="p-2 border">{{ edu.id }}</td>
                            <td class="p-2 border">{{ edu.degree }}</td>
                            <td class="p-2 border">{{ edu.institution }}</td>
                            <td class="p-2 border">{{ edu.year }}</td>

                            <td class="p-2 border">
                                <button
                                    @click="editEducation(edu)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded mr-2"
                                >
                                    Edit
                                </button>

                                <button
                                    @click="confirmDelete(edu.id)"
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
                        @click="loadEducation(pagination.prev_page_url)"
                    >
                        Prev
                    </button>

                    <button
                        class="px-4 py-1 bg-gray-200 rounded"
                        :disabled="!pagination.next_page_url"
                        @click="loadEducation(pagination.next_page_url)"
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
                            {{ editMode ? "Edit Education" : "Add Education" }}
                        </h2>

                        <input
                            v-model="form.degree"
                            type="text"
                            placeholder="Degree (e.g. BSc in CSE)"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <input
                            v-model="form.institution"
                            type="text"
                            placeholder="Institution"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <input
                            v-model="form.year"
                            type="text"
                            placeholder="Passing Year"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <textarea
                            v-model="form.description"
                            placeholder="Short Description"
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
                                        ? updateEducation()
                                        : createEducation()
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

const education = ref([]);
const pagination = ref({});
const showModal = ref(false);
const editMode = ref(false);
const search = ref("");

const form = ref({
    id: null,
    degree: "",
    institution: "",
    year: "",
    description: "",
});

/* Load Education (Search + Pagination) */
const loadEducation = async (url = "/api/admin/education") => {
    let finalUrl = url;

    if (typeof url !== "string") {
        finalUrl = "/api/admin/education";
    } else if (url.startsWith("http")) {
        const u = new URL(url);
        finalUrl = u.pathname + u.search;
    }

    const res = await api.get(finalUrl, {
        params: { search: search.value },
    });

    education.value = res.data.data ?? res.data;
    pagination.value = res.data;
};

onMounted(loadEducation);

/* Create Education */
const createEducation = async () => {
    await api.post("/api/admin/education", form.value);
    showModal.value = false;
    loadEducation();
    toast.success("Education created!");
};

/* Edit */
const editEducation = (edu) => {
    editMode.value = true;
    showModal.value = true;

    form.value = {
        id: edu.id,
        degree: edu.degree,
        institution: edu.institution,
        year: edu.year,
        description: edu.description,
    };
};

/* Update */
const updateEducation = async () => {
    await api.put(`/api/admin/education/${form.value.id}`, form.value);
    showModal.value = false;
    loadEducation();
    toast.success("Education updated!");
};

/* Delete */
const confirmDelete = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e3342f",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
    }).then(async (result) => {
        if (result.isConfirmed) {
            await api.delete(`/api/admin/education/${id}`);
            loadEducation();
            toast.error("Education deleted!");
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
        year: "",
        description: "",
    };
};

const closeModal = () => (showModal.value = false);
</script>
