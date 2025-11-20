<template>
    <div class="flex">
        <Sidebar />

        <div class="flex-1 ml-64">
            <Topbar />

            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Projects</h1>

                    <button
                        class="bg-blue-600 text-white px-4 py-2 rounded"
                        @click="openCreateModal"
                    >
                        + Add Project
                    </button>
                </div>

                <!-- Search -->
                <input
                    v-model="search"
                    @input="loadProjects('/api/admin/projects')"
                    type="text"
                    placeholder="Search projects..."
                    class="border p-2 rounded w-64 mb-3"
                />

                <!-- Projects Table -->
                <table class="w-full border shadow-md">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Title</th>
                            <th class="p-2 border">Tech Stack</th>
                            <th class="p-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="project in projects"
                            :key="project.id"
                            class="hover:bg-gray-50 transition"
                        >
                            <td class="p-2 border">{{ project.id }}</td>
                            <td class="p-2 border">{{ project.title }}</td>
                            <td class="p-2 border">{{ project.tech_stack }}</td>

                            <td class="p-2 border flex">
                                <button
                                    @click="editProject(project)"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded mr-2"
                                >
                                    Edit
                                </button>

                                <button
                                    @click="confirmDelete(project.id)"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
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
                        @click="loadProjects(pagination.prev_page_url)"
                    >
                        Prev
                    </button>
                    <button
                        class="px-4 py-1 bg-gray-200 rounded"
                        :disabled="!pagination.next_page_url"
                        @click="loadProjects(pagination.next_page_url)"
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
                            {{ editMode ? "Edit Project" : "Add Project" }}
                        </h2>

                        <input
                            v-model="form.title"
                            type="text"
                            placeholder="Title"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <input
                            v-model="form.slug"
                            type="text"
                            placeholder="Slug"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <input
                            v-model="form.tech_stack"
                            type="text"
                            placeholder="Tech Stack"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <input
                            v-model="form.thumbnail"
                            type="text"
                            placeholder="Thumbnail URL"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <input
                            v-model="form.github_link"
                            type="text"
                            placeholder="GitHub Link"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <input
                            v-model="form.live_link"
                            type="text"
                            placeholder="Live Link"
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
                                    editMode ? updateProject() : createProject()
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

const projects = ref([]);
const pagination = ref({});
const showModal = ref(false);
const editMode = ref(false);
const search = ref("");

const form = ref({
    id: null,
    title: "",
    slug: "",
    description: "",
    tech_stack: "",
    thumbnail: "",
    github_link: "",
    live_link: "",
});

/* Load Projects with Search & Pagination */
const loadProjects = async (url = "/api/admin/projects") => {
    let finalUrl = url;

    // Convert absolute URLs to relative URLs
    if (url.startsWith("http")) {
        const u = new URL(url);
        finalUrl = u.pathname + u.search;
    }

    const res = await api.get(finalUrl, {
        params: { search: search.value },
    });

    projects.value = res.data.data;
    pagination.value = res.data;
};

onMounted(() => loadProjects());

/* Open Create Modal */
const openCreateModal = () => {
    editMode.value = false;
    showModal.value = true;

    form.value = {
        id: null,
        title: "",
        slug: "",
        description: "",
        tech_stack: "",
        thumbnail: "",
        github_link: "",
        live_link: "",
    };
};

/* Create */
const createProject = async () => {
    await api.post("/api/admin/projects", form.value);
    showModal.value = false;
    loadProjects();

    toast.success("Project created successfully!");
};

/* Edit */
const editProject = (project) => {
    editMode.value = true;
    showModal.value = true;
    form.value = { ...project };
};

/* Update */
const updateProject = async () => {
    await api.put(`/api/admin/projects/${form.value.id}`, form.value);
    showModal.value = false;
    loadProjects();
    toast.success("Project updated successfully!");
};

/* Delete with SweetAlert Confirmation */
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
            await api.delete(`/api/admin/projects/${id}`);
            loadProjects();
            toast.error("Project deleted!");
        }
    });
};

const closeModal = () => {
    showModal.value = false;
};
</script>
