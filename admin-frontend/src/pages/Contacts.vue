<template>
    <div class="flex">
        <Sidebar />

        <div class="flex-1 ml-64">
            <Topbar />

            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Contacts</h1>
                </div>

                <!-- Search -->
                <input
                    v-model="search"
                    @input="loadContacts"
                    type="text"
                    placeholder="Search by name, email, or subject..."
                    class="border p-2 rounded w-64 mb-3"
                />

                <!-- Table -->
                <table class="w-full border shadow-md">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Name</th>
                            <th class="p-2 border">Email</th>
                            <th class="p-2 border">Subject</th>
                            <th class="p-2 border">Message</th>
                            <th class="p-2 border">Seen</th>
                            <th class="p-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="c in contacts"
                            :key="c.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="p-2 border">{{ c.id }}</td>
                            <td class="p-2 border">{{ c.name }}</td>
                            <td class="p-2 border">{{ c.email }}</td>
                            <td class="p-2 border">{{ c.subject }}</td>
                            <td class="p-2 border">{{ c.message }}</td>

                            <td class="p-2 border">
                                <span
                                    class="px-2 py-1 rounded text-white"
                                    :class="
                                        c.is_seen
                                            ? 'bg-green-600'
                                            : 'bg-red-600'
                                    "
                                >
                                    {{ c.is_seen ? "Seen" : "New" }}
                                </span>
                            </td>

                            <td class="p-2 border">
                                <button
                                    v-if="!c.is_seen"
                                    @click="markSeen(c.id)"
                                    class="bg-blue-600 text-white px-3 py-1 rounded mr-2"
                                >
                                    Mark Seen
                                </button>

                                <button
                                    @click="confirmDelete(c.id)"
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
                        @click="loadContacts(pagination.prev_page_url)"
                    >
                        Prev
                    </button>

                    <button
                        class="px-4 py-1 bg-gray-200 rounded"
                        :disabled="!pagination.next_page_url"
                        @click="loadContacts(pagination.next_page_url)"
                    >
                        Next
                    </button>
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

const contacts = ref([]);
const pagination = ref({});
const search = ref("");

/* Load Contacts (Search + Pagination) */
const loadContacts = async (url = "/api/admin/contacts") => {
    let finalUrl = url;

    if (typeof url !== "string") {
        finalUrl = "/api/admin/contacts";
    } else if (url.startsWith("http")) {
        const u = new URL(url);
        finalUrl = u.pathname + u.search;
    }

    const res = await api.get(finalUrl, {
        params: { search: search.value },
    });

    contacts.value = res.data.data ?? res.data;
    pagination.value = res.data;
};

onMounted(loadContacts);

/* Mark Contact as Seen */
const markSeen = async (id) => {
    await api.put(`/api/admin/contacts/${id}`, {
        is_seen: true,
    });

    toast.success("Marked as seen!");
    loadContacts();
};

/* Delete Contact */
const confirmDelete = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "This message will be deleted permanently!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e3342f",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
    }).then(async (result) => {
        if (result.isConfirmed) {
            await api.delete(`/api/admin/contacts/${id}`);
            loadContacts();
            toast.error("Message deleted!");
        }
    });
};
</script>
