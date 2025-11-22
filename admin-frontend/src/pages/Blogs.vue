<template>
    <div class="flex">
        <Sidebar />

        <div class="flex-1 ml-64">
            <Topbar />

            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Blogs</h1>

                    <button
                        class="bg-blue-600 text-white px-4 py-2 rounded"
                        @click="openCreateModal"
                    >
                        + Add Blog
                    </button>
                </div>

                <!-- Search -->
                <input
                    v-model="search"
                    @input="loadBlogs"
                    type="text"
                    placeholder="Search blogs..."
                    class="border p-2 rounded w-64 mb-3"
                />

                <!-- Blog Table -->
                <table class="w-full border shadow-md">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Title</th>
                            <th class="p-2 border">Thumbnail</th>
                            <th class="p-2 border">Published</th>
                            <th class="p-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="blog in blogs"
                            :key="blog.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="p-2 border">{{ blog.id }}</td>
                            <td class="p-2 border">{{ blog.title }}</td>

                            <td class="p-2 border">
                                <img
                                    v-if="blog.thumbnail"
                                    :src="blog.thumbnail"
                                    class="h-12 rounded"
                                />
                            </td>

                            <td class="p-2 border">
                                <span
                                    class="px-2 py-1 rounded text-white"
                                    :class="
                                        blog.is_published
                                            ? 'bg-green-500'
                                            : 'bg-gray-500'
                                    "
                                >
                                    {{ blog.is_published ? "Yes" : "No" }}
                                </span>
                            </td>

                            <td class="p-2 border">
                                <button
                                    @click="editBlog(blog)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded mr-2"
                                >
                                    Edit
                                </button>

                                <button
                                    @click="togglePublish(blog)"
                                    class="bg-indigo-600 text-white px-3 py-1 rounded mr-2"
                                >
                                    {{
                                        blog.is_published
                                            ? "Unpublish"
                                            : "Publish"
                                    }}
                                </button>

                                <button
                                    @click="confirmDelete(blog.id)"
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
                        @click="loadBlogs(pagination.prev_page_url)"
                    >
                        Prev
                    </button>

                    <button
                        class="px-4 py-1 bg-gray-200 rounded"
                        :disabled="!pagination.next_page_url"
                        @click="loadBlogs(pagination.next_page_url)"
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
                            {{ editMode ? "Edit Blog" : "Add Blog" }}
                        </h2>

                        <!-- Category -->
                        <select
                            v-model="form.category_id"
                            class="w-full mb-3 p-2 border rounded"
                        >
                            <option disabled value="">Select Category</option>
                            <option
                                v-for="cat in categories"
                                :key="cat.id"
                                :value="cat.id"
                            >
                                {{ cat.name }}
                            </option>
                        </select>

                        <!-- Title -->
                        <input
                            v-model="form.title"
                            type="text"
                            placeholder="Title"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <!-- Slug -->
                        <input
                            v-model="form.slug"
                            type="text"
                            placeholder="Slug"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <!-- Thumbnail -->
                        <input
                            v-model="form.thumbnail"
                            type="text"
                            placeholder="Thumbnail URL"
                            class="w-full mb-3 p-2 border rounded"
                        />

                        <!-- Content -->
                        <textarea
                            v-model="form.content"
                            placeholder="Content"
                            class="w-full mb-3 p-2 border rounded h-28"
                        ></textarea>

                        <div class="flex justify-end">
                            <button
                                @click="closeModal"
                                class="mr-2 px-4 py-2 bg-gray-400 text-white rounded"
                            >
                                Cancel
                            </button>

                            <button
                                @click="editMode ? updateBlog() : createBlog()"
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

const blogs = ref([]);
const categories = ref([]);
const pagination = ref({});
const showModal = ref(false);
const editMode = ref(false);
const search = ref("");

const form = ref({
    id: null,
    category_id: "",
    title: "",
    slug: "",
    content: "",
    thumbnail: "",
    is_published: false,
});

/* Load All Blogs */
const loadBlogs = async (url = "/api/admin/blogs") => {
    let finalUrl = url;

    if (typeof url !== "string") {
        finalUrl = "/api/admin/blogs";
    } else if (url.startsWith("http")) {
        const u = new URL(url);
        finalUrl = u.pathname + u.search;
    }

    const res = await api.get(finalUrl, {
        params: { search: search.value },
    });

    blogs.value = res.data.data ?? res.data;
    pagination.value = res.data;
};

/* Load Categories for Select Dropdown */
const loadCategories = async () => {
    const res = await api.get("/api/admin/categories");
    categories.value = res.data.data ?? res.data;
};

onMounted(() => {
    loadBlogs();
    loadCategories();
});

/* Create Blog */
const createBlog = async () => {
    await api.post("/api/admin/blogs", form.value);
    showModal.value = false;
    loadBlogs();
    toast.success("Blog created!");
};

/* Edit Blog */
const editBlog = (blog) => {
    editMode.value = true;
    showModal.value = true;
    form.value = { ...blog };
};

/* Update Blog */
const updateBlog = async () => {
    await api.put(`/api/admin/blogs/${form.value.id}`, form.value);
    showModal.value = false;
    loadBlogs();
    toast.success("Blog updated!");
};

/* Publish / Unpublish */
const togglePublish = async (blog) => {
    try {
        await api.put(`/api/admin/blogs/${blog.id}`, {
            is_published: blog.is_published ? 0 : 1,
        });

        loadBlogs();

        toast.success(
            blog.is_published ? "Blog Unpublished!" : "Blog Published!"
        );
    } catch (e) {
        console.error(e);
        toast.error("Failed to update publish status");
    }
};

/* Delete Blog */
const confirmDelete = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "This cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e3342f",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Delete",
    }).then(async (result) => {
        if (result.isConfirmed) {
            await api.delete(`/api/admin/blogs/${id}`);
            loadBlogs();
            toast.error("Blog deleted!");
        }
    });
};

const openCreateModal = () => {
    editMode.value = false;
    showModal.value = true;
    form.value = {
        id: null,
        category_id: "",
        title: "",
        slug: "",
        content: "",
        thumbnail: "",
        is_published: false,
    };
};

const closeModal = () => (showModal.value = false);
</script>

<style>
.input {
    @apply w-full p-2 border rounded;
}
</style>
