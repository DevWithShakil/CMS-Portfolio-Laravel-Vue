<template>
    <div class="min-h-screen space-y-6">
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-4"
        >
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">
                    Blog
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400"
                        >Management</span
                    >
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Create, edit, and publish your articles.
                </p>
            </div>

            <button
                @click="openCreateModal"
                class="flex items-center gap-2 bg-purple-600 hover:bg-purple-500 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-purple-500/20 transition-all hover:-translate-y-0.5"
            >
                <Plus class="w-5 h-5" />
                <span>New Article</span>
            </button>
        </div>

        <div
            class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row gap-4 justify-between items-center shadow-sm"
        >
            <div class="relative w-full md:w-80 group">
                <Search
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 group-focus-within:text-purple-400 transition-colors"
                />
                <input
                    v-model="search"
                    @input="loadBlogs('/api/admin/blogs')"
                    type="text"
                    placeholder="Search articles..."
                    class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:border-purple-500/50 focus:ring-1 focus:ring-purple-500/50 transition-all placeholder:text-slate-600"
                />
            </div>
            <div class="text-xs text-slate-500 font-medium">
                Total Articles:
                <span class="text-purple-400">{{
                    pagination.total || blogs.length
                }}</span>
            </div>
        </div>

        <div
            v-if="loading"
            class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6"
        >
            <div
                v-for="n in 6"
                :key="n"
                class="bg-slate-900 border border-slate-800 rounded-2xl p-4 animate-pulse flex flex-col gap-4 h-80"
            >
                <div class="w-full h-40 bg-slate-800 rounded-xl"></div>
                <div class="space-y-2 flex-1">
                    <div class="h-4 bg-slate-800 rounded w-3/4"></div>
                    <div class="h-3 bg-slate-800 rounded w-1/2"></div>
                </div>
                <div class="h-8 bg-slate-800 rounded w-full"></div>
            </div>
        </div>

        <div
            v-else
            class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6"
        >
            <div
                v-for="blog in blogs"
                :key="blog.id"
                class="group bg-slate-900 border border-slate-800 hover:border-purple-500/30 rounded-2xl overflow-hidden shadow-lg transition-all hover:-translate-y-1 flex flex-col"
            >
                <div class="relative h-48 overflow-hidden bg-slate-800">
                    <img
                        v-if="blog.thumbnail"
                        :src="getThumbnailUrl(blog.thumbnail)"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        alt="thumbnail"
                    />
                    <div
                        v-else
                        class="w-full h-full flex items-center justify-center text-slate-600"
                    >
                        <Image class="w-8 h-8" />
                    </div>

                    <div class="absolute top-3 right-3">
                        <span
                            class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wide backdrop-blur-md shadow-sm border"
                            :class="
                                blog.is_published
                                    ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30'
                                    : 'bg-slate-800/80 text-slate-400 border-slate-600/30'
                            "
                        >
                            {{ blog.is_published ? "Published" : "Draft" }}
                        </span>
                    </div>
                </div>

                <div class="p-5 flex-1 flex flex-col">
                    <h3
                        class="text-lg font-bold text-white line-clamp-2 leading-snug mb-2 group-hover:text-purple-400 transition-colors"
                    >
                        {{ blog.title }}
                    </h3>

                    <div
                        class="text-xs text-slate-500 mb-4 flex items-center gap-2"
                    >
                        <Folder class="w-3 h-3" />
                        <span>{{ getCategoryName(blog.category_id) }}</span>
                    </div>

                    <div
                        class="mt-auto pt-4 border-t border-slate-800 flex justify-between items-center"
                    >
                        <button
                            @click="togglePublish(blog)"
                            class="text-xs font-medium flex items-center gap-1.5 transition-colors"
                            :class="
                                blog.is_published
                                    ? 'text-amber-400 hover:text-amber-300'
                                    : 'text-emerald-400 hover:text-emerald-300'
                            "
                        >
                            <component
                                :is="blog.is_published ? EyeOff : Eye"
                                class="w-3.5 h-3.5"
                            />
                            {{ blog.is_published ? "Unpublish" : "Publish" }}
                        </button>

                        <div class="flex gap-2">
                            <button
                                @click="editBlog(blog)"
                                class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-colors"
                            >
                                <Edit3 class="w-4 h-4" />
                            </button>
                            <button
                                @click="confirmDelete(blog.id)"
                                class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-colors"
                            >
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div
                v-if="!loading && blogs.length === 0"
                class="col-span-full py-16 text-center border-2 border-dashed border-slate-800 rounded-2xl"
            >
                <div
                    class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4"
                >
                    <FileText class="w-8 h-8 text-slate-600" />
                </div>
                <h3 class="text-slate-300 font-medium">No articles found</h3>
                <p class="text-slate-500 text-sm mt-1">
                    Start writing your first blog post.
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
                @click="loadBlogs(pagination.prev_page_url)"
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
                @click="loadBlogs(pagination.next_page_url)"
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
                            {{ editMode ? "Edit Article" : "New Article" }}
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
                                    >Title</label
                                >
                                <input
                                    v-model="form.title"
                                    type="text"
                                    placeholder="Article Title"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-purple-500/50 focus:ring-1 focus:ring-purple-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-xs font-semibold text-slate-400 uppercase"
                                    >Slug</label
                                >
                                <input
                                    v-model="form.slug"
                                    type="text"
                                    placeholder="article-slug"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-purple-500/50 focus:ring-1 focus:ring-purple-500/50 transition-all placeholder:text-slate-600"
                                />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Category</label
                            >
                            <select
                                v-model="form.category_id"
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-purple-500/50 focus:ring-1 focus:ring-purple-500/50 transition-all"
                            >
                                <option value="" disabled>
                                    Select Category
                                </option>
                                <option
                                    v-for="cat in categories"
                                    :key="cat.id"
                                    :value="cat.id"
                                >
                                    {{ cat.name }}
                                </option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Thumbnail</label
                            >

                            <div
                                class="relative group w-full h-32 bg-slate-950 border border-dashed border-slate-700 rounded-xl hover:border-purple-500/50 hover:bg-slate-900 transition-all flex flex-col items-center justify-center cursor-pointer overflow-hidden"
                            >
                                <input
                                    type="file"
                                    @change="handleFileChange"
                                    accept="image/*"
                                    class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                />

                                <img
                                    v-if="previewImage"
                                    :src="previewImage"
                                    class="absolute inset-0 w-full h-full object-cover z-0"
                                />

                                <div
                                    v-else
                                    class="flex flex-col items-center justify-center text-slate-500 pointer-events-none group-hover:text-purple-400 transition-colors"
                                >
                                    <UploadCloud class="w-8 h-8 mb-2" />
                                    <span class="text-xs"
                                        >Click or drag to upload image</span
                                    >
                                </div>

                                <button
                                    v-if="previewImage"
                                    @click.prevent="removeImage"
                                    class="absolute top-2 right-2 p-1 bg-red-500/80 text-white rounded-full hover:bg-red-600 z-20 transition shadow-sm"
                                >
                                    <X class="w-4 h-4" />
                                </button>
                            </div>
                        </div>

                        <div class="space-y-1.5 flex-1">
                            <label
                                class="text-xs font-semibold text-slate-400 uppercase"
                                >Content (Markdown / HTML)</label
                            >
                            <textarea
                                v-model="form.content"
                                rows="8"
                                placeholder="Write your story..."
                                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-slate-200 focus:outline-none focus:border-purple-500/50 focus:ring-1 focus:ring-purple-500/50 transition-all placeholder:text-slate-600 font-mono text-sm custom-scrollbar leading-relaxed"
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
                            @click="editMode ? updateBlog() : createBlog()"
                            class="px-5 py-2.5 rounded-xl font-medium bg-purple-600 hover:bg-purple-500 text-white shadow-lg shadow-purple-600/20 transition-all flex items-center gap-2"
                            :disabled="isSubmitting"
                        >
                            <span v-if="isSubmitting" class="animate-spin"
                                >⌛</span
                            >
                            {{
                                editMode ? "Update Article" : "Publish Article"
                            }}
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
    FileText,
    Image,
    Folder,
    Eye,
    EyeOff,
    UploadCloud,
} from "lucide-vue-next";

const toast = useToast();
const blogs = ref([]);
const categories = ref([]);
const pagination = ref({});
const showModal = ref(false);
const editMode = ref(false);
const search = ref("");
const loading = ref(false);
const isSubmitting = ref(false);

// New Image State
const previewImage = ref(null);
const selectedFile = ref(null);

const form = ref({
    id: null,
    category_id: "",
    title: "",
    slug: "",
    content: "",
    thumbnail: "", // This will hold the URL string from DB
    is_published: false,
});

// ✅ Helper to fix URL path (Backend /storage/.. to Full URL)
const getThumbnailUrl = (path) => {
    if (!path) return null;
    // যদি Full URL হয় তাহলে সেটাই রিটার্ন করো, নাহলে Backend URL বসাও
    return path.startsWith("http") ? path : `http://127.0.0.1:8000${path}`;
};

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

const getCategoryName = (id) => {
    const cat = categories.value.find((c) => c.id === id);
    return cat ? cat.name : "Uncategorized";
};

const loadBlogs = async (url = "/api/admin/blogs") => {
    loading.value = true;
    try {
        const res = await api.get(normalizeUrl(url), {
            params: { search: search.value },
        });
        blogs.value = res.data.data ?? res.data;
        pagination.value = res.data.meta || res.data;
    } catch (err) {
        toast.error("Failed to load blogs");
    } finally {
        loading.value = false;
    }
};

const loadCategories = async () => {
    try {
        const res = await api.get("/api/admin/categories");
        categories.value = res.data.data ?? res.data;
    } catch (e) {}
};

onMounted(() => {
    loadBlogs();
    loadCategories();
});

/* -----------------------------
   📷 Image Upload Logic
----------------------------- */
const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        selectedFile.value = file;
        previewImage.value = URL.createObjectURL(file); // Show preview
    }
};

const removeImage = () => {
    selectedFile.value = null;
    previewImage.value = null;
};

/* -----------------------------
   📝 Create Blog (FormData)
----------------------------- */
const createBlog = async () => {
    isSubmitting.value = true;
    try {
        const formData = new FormData();
        formData.append("category_id", form.value.category_id);
        formData.append("title", form.value.title);
        formData.append("slug", form.value.slug);
        formData.append("content", form.value.content);
        // Boolean to 1/0 for Laravel
        formData.append("is_published", form.value.is_published ? "1" : "0");

        // Append File if exists
        if (selectedFile.value) {
            formData.append("thumbnail", selectedFile.value);
        }

        await api.post("/api/admin/blogs", formData);

        showModal.value = false;
        loadBlogs();
        toast.success("Blog created successfully!");
    } catch (err) {
        if (err.response && err.response.status === 422) {
            toast.error("Validation Error! Check fields.");
        } else {
            toast.error("Failed to create blog");
        }
    } finally {
        isSubmitting.value = false;
    }
};

/* -----------------------------
   🔄 Update Blog (FormData + _method: PUT)
----------------------------- */
const updateBlog = async () => {
    isSubmitting.value = true;
    try {
        const formData = new FormData();
        formData.append("category_id", form.value.category_id);
        formData.append("title", form.value.title);
        formData.append("slug", form.value.slug);
        formData.append("content", form.value.content);
        formData.append("is_published", form.value.is_published ? "1" : "0");

        if (selectedFile.value) {
            formData.append("thumbnail", selectedFile.value);
        }

        // ⚠️ TRICK: Laravel PUT file upload fix
        formData.append("_method", "PUT");

        await api.post(`/api/admin/blogs/${form.value.id}`, formData);

        showModal.value = false;
        loadBlogs();
        toast.success("Blog updated successfully!");
    } catch (err) {
        toast.error("Failed to update blog");
    } finally {
        isSubmitting.value = false;
    }
};

const togglePublish = async (blog) => {
    try {
        await api.put(`/api/admin/blogs/${blog.id}`, {
            is_published: !blog.is_published,
        });
        loadBlogs();
        toast.success(blog.is_published ? "Unpublished!" : "Published!");
    } catch (e) {
        toast.error("Update failed");
    }
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
            await api.delete(`/api/admin/blogs/${id}`);
            loadBlogs();
            toast.success("Deleted!");
        }
    });
};

const openCreateModal = () => {
    editMode.value = false;
    showModal.value = true;
    selectedFile.value = null; // Reset File
    previewImage.value = null; // Reset Preview
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

const editBlog = (blog) => {
    editMode.value = true;
    showModal.value = true;
    selectedFile.value = null; // Reset File

    // Set existing image as preview
    previewImage.value = getThumbnailUrl(blog.thumbnail);

    form.value = { ...blog };
};

const closeModal = () => (showModal.value = false);
</script>
