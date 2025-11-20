<template>
    <div class="flex">
        <Sidebar />

        <div class="flex-1 ml-64">
            <Topbar />

            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Projects</h1>
                    <button
                        class="bg-blue-600 text-white px-4 py-2 rounded"
                        @click="openCreateModal"
                    >
                        + Add Project
                    </button>
                </div>

                <!-- Projects Table -->
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-200">
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
                            class="hover:bg-gray-100"
                        >
                            <td class="p-2 border">{{ project.id }}</td>
                            <td class="p-2 border">{{ project.title }}</td>
                            <td class="p-2 border">{{ project.tech_stack }}</td>
                            <td class="p-2 border">
                                <button
                                    @click="editProject(project)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded mr-2"
                                >
                                    Edit
                                </button>

                                <button
                                    @click="deleteProject(project.id)"
                                    class="bg-red-600 text-white px-3 py-1 rounded"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Create / Edit Modal -->
                <div
                    v-if="showModal"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
                >
                    <div class="bg-white p-6 rounded w-96">
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
                            placeholder="Thumbnail"
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
import api from "../services/api";
import Sidebar from "../components/Sidebar.vue";
import Topbar from "../components/Topbar.vue";

const projects = ref([]);
const showModal = ref(false);
const editMode = ref(false);

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

const loadProjects = async () => {
    const res = await api.get("/projects");
    projects.value = res.data;
};

onMounted(() => loadProjects());

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

const createProject = async () => {
    await api.post("/projects", form.value);
    showModal.value = false;
    loadProjects();
};

const editProject = (project) => {
    editMode.value = true;
    showModal.value = true;
    form.value = { ...project };
};

const updateProject = async () => {
    await api.put(`/projects/${form.value.id}`, form.value);
    showModal.value = false;
    loadProjects();
};

const deleteProject = async (id) => {
    if (confirm("Are you sure?")) {
        await api.delete(`/projects/${id}`);
        loadProjects();
    }
};

const closeModal = () => {
    showModal.value = false;
};
</script>
