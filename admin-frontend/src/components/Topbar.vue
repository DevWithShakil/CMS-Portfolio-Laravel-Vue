<template>
    <header
        class="sticky top-0 z-40 w-full bg-slate-900/80 backdrop-blur-md border-b border-slate-800/60 shadow-sm transition-all duration-300"
    >
        <div
            class="relative flex items-center justify-between h-20 px-4 md:px-6"
        >
            <div
                v-if="isSearchOpen"
                class="absolute inset-0 z-50 flex flex-col bg-slate-900 w-full h-auto shadow-2xl animate-fade-in"
            >
                <div
                    class="flex items-center px-4 h-20 border-b border-slate-800"
                >
                    <Search class="w-5 h-5 text-blue-500 mr-3 shrink-0" />
                    <input
                        ref="mobileSearchInput"
                        v-model="searchQuery"
                        @input="handleSearch"
                        type="text"
                        placeholder="Type to search projects, skills, blogs..."
                        class="flex-1 bg-transparent border-none text-sm focus:outline-none text-white placeholder:text-slate-500 h-full"
                        @keydown.esc="closeSearch"
                    />
                    <button
                        @click="closeSearch"
                        class="p-2 ml-2 text-slate-400 hover:text-rose-500 transition-colors"
                    >
                        <X class="w-6 h-6" />
                    </button>
                </div>

                <div
                    v-if="searchResults.length > 0"
                    class="max-h-64 overflow-y-auto custom-scrollbar bg-slate-900 border-b border-slate-800"
                >
                    <div
                        v-for="(item, index) in searchResults"
                        :key="index"
                        @click="navigateTo(item.url)"
                        class="px-4 py-3 border-b border-slate-800/50 hover:bg-slate-800 cursor-pointer flex items-center gap-3"
                    >
                        <div
                            class="p-2 rounded-lg bg-slate-800 shrink-0"
                            :class="getTypeColor(item.type)"
                        >
                            <Layers
                                v-if="item.type === 'Project'"
                                class="w-4 h-4"
                            />
                            <Award
                                v-else-if="item.type === 'Skill'"
                                class="w-4 h-4"
                            />
                            <FileText v-else class="w-4 h-4" />
                        </div>

                        <div class="min-w-0">
                            <p class="text-sm font-bold text-white truncate">
                                {{ item.data.title || item.data.name }}
                            </p>
                            <p
                                class="text-[10px] text-slate-500 uppercase tracking-wider"
                            >
                                {{ item.type }}
                            </p>
                        </div>
                    </div>
                </div>
                <div
                    v-else-if="searchQuery.length > 2 && !isLoading"
                    class="p-4 text-center text-slate-500 text-xs"
                >
                    No results found.
                </div>
            </div>

            <div
                class="flex items-center gap-3 md:gap-4"
                :class="{ invisible: isSearchOpen }"
            >
                <button
                    @click="emitToggle"
                    class="lg:hidden p-2 text-slate-400 hover:text-white transition-colors"
                >
                    <Menu class="w-6 h-6" />
                </button>

                <div>
                    <h1
                        class="text-lg md:text-xl font-bold text-white capitalize tracking-wide flex items-center gap-2"
                    >
                        {{ currentRouteName }}
                    </h1>
                    <p
                        class="text-xs text-slate-500 hidden md:block font-medium"
                    >
                        Welcome back,
                        <span class="text-slate-300 font-bold">{{
                            userName
                        }}</span>
                    </p>
                </div>
            </div>

            <div
                class="flex items-center gap-2 md:gap-4"
                :class="{ invisible: isSearchOpen }"
            >
                <div class="relative hidden md:block">
                    <div
                        class="flex items-center bg-slate-800/50 rounded-xl px-4 py-2.5 border border-slate-700/50 focus-within:ring-2 focus-within:ring-blue-500/50 transition-all w-64"
                    >
                        <Search class="w-4 h-4 text-slate-400" />
                        <input
                            v-model="searchQuery"
                            @input="handleSearch"
                            type="text"
                            placeholder="Search..."
                            class="bg-transparent border-none text-sm ml-3 w-full focus:outline-none text-slate-200 placeholder:text-slate-500"
                        />
                        <button
                            v-if="searchQuery"
                            @click="clearSearch"
                            class="text-slate-500 hover:text-white"
                        >
                            <X class="w-3 h-3" />
                        </button>
                    </div>

                    <div
                        v-if="searchResults.length > 0"
                        class="absolute top-full left-0 w-full mt-2 bg-slate-900 border border-slate-800 rounded-xl shadow-2xl overflow-hidden z-50"
                    >
                        <div
                            v-for="(item, index) in searchResults"
                            :key="index"
                            @click="navigateTo(item.url)"
                            class="px-4 py-3 hover:bg-slate-800 cursor-pointer flex items-center gap-3 border-b border-slate-800/50 last:border-0"
                        >
                            <div
                                class="p-2 rounded-lg bg-slate-800 shrink-0"
                                :class="getTypeColor(item.type)"
                            >
                                <Layers
                                    v-if="item.type === 'Project'"
                                    class="w-4 h-4"
                                />
                                <Award
                                    v-else-if="item.type === 'Skill'"
                                    class="w-4 h-4"
                                />
                                <FileText v-else class="w-4 h-4" />
                            </div>
                            <div class="min-w-0">
                                <p
                                    class="text-sm font-bold text-white truncate"
                                >
                                    {{ item.data.title || item.data.name }}
                                </p>
                                <p
                                    class="text-[10px] text-slate-500 uppercase tracking-wider"
                                >
                                    {{ item.type }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <button
                    @click="openSearch"
                    class="md:hidden p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-colors"
                >
                    <Search class="w-5 h-5" />
                </button>

                <div class="relative" ref="notificationRef">
                    <button
                        @click="toggleNotification"
                        class="relative p-2.5 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-all group"
                    >
                        <Bell class="w-5 h-5 group-hover:animate-swing" />
                        <span
                            v-if="unreadCount > 0"
                            class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-slate-900 animate-pulse"
                        ></span>
                    </button>

                    <transition name="fade">
                        <div
                            v-if="isNotificationOpen"
                            class="absolute right-0 mt-3 w-80 bg-slate-900 rounded-xl shadow-2xl border border-slate-800 py-2 origin-top-right z-50"
                        >
                            <div
                                class="px-4 py-2 border-b border-slate-800 flex justify-between items-center"
                            >
                                <h3 class="text-sm font-bold text-white">
                                    Notifications
                                </h3>
                                <span
                                    v-if="unreadCount > 0"
                                    class="text-xs bg-blue-600 text-white px-1.5 py-0.5 rounded"
                                    >{{ unreadCount }} New</span
                                >
                            </div>
                            <div
                                class="max-h-64 overflow-y-auto custom-scrollbar"
                            >
                                <div
                                    v-if="notifications.length === 0"
                                    class="p-4 text-center text-slate-500 text-xs"
                                >
                                    No new notifications
                                </div>
                                <div
                                    v-for="notif in notifications"
                                    :key="notif.id"
                                    @click="router.push('/admin/contacts')"
                                    class="px-4 py-3 hover:bg-slate-800 cursor-pointer border-b border-slate-800/50 flex gap-3"
                                >
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 shrink-0"
                                    >
                                        <Mail class="w-4 h-4" />
                                    </div>
                                    <div class="min-w-0">
                                        <p
                                            class="text-sm font-bold text-slate-200 truncate"
                                        >
                                            {{ notif.name }}
                                        </p>
                                        <p
                                            class="text-xs text-slate-400 truncate"
                                        >
                                            {{ notif.subject }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="p-2 border-t border-slate-800 text-center"
                            >
                                <router-link
                                    to="/admin/contacts"
                                    class="text-xs text-blue-400 hover:underline"
                                    >View All Messages</router-link
                                >
                            </div>
                        </div>
                    </transition>
                </div>

                <div class="h-8 w-px bg-slate-800 mx-1 hidden sm:block"></div>

                <div class="relative" ref="dropdownRef">
                    <button
                        @click="toggleDropdown"
                        class="flex items-center gap-2 md:gap-3 p-1 rounded-full hover:bg-slate-800/50 transition-all border border-transparent hover:border-slate-700/50 group"
                    >
                        <div class="relative">
                            <img
                                :src="
                                    userAvatar ||
                                    'https://ui-avatars.com/api/?name=Admin&background=0f172a&color=cbd5e1'
                                "
                                class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover border-2 border-slate-700 group-hover:border-blue-500 transition-colors"
                            />
                            <div
                                class="absolute bottom-0 right-0 w-2.5 h-2.5 md:w-3 md:h-3 bg-emerald-500 border-2 border-slate-900 rounded-full"
                            ></div>
                        </div>
                        <div class="hidden md:flex flex-col items-start pr-2">
                            <span
                                class="text-sm font-bold text-slate-200 leading-none group-hover:text-white"
                                >{{ userName }}</span
                            >
                            <span
                                class="text-[10px] text-slate-500 font-medium mt-1"
                                >Super Admin</span
                            >
                        </div>
                        <ChevronDown
                            class="w-4 h-4 text-slate-500 group-hover:text-white transition-colors hidden md:block"
                        />
                    </button>

                    <transition name="fade">
                        <div
                            v-if="isDropdownOpen"
                            class="absolute right-0 mt-3 w-72 bg-slate-900 rounded-xl shadow-2xl border border-slate-800 py-2 origin-top-right z-50"
                        >
                            <div
                                class="px-5 py-3 border-b border-slate-800 mb-2"
                            >
                                <p
                                    class="text-xs font-medium text-slate-400 uppercase tracking-wider"
                                >
                                    Signed in as
                                </p>
                                <p
                                    class="text-sm font-bold text-white mt-1 cursor-help truncate hover:whitespace-normal break-all"
                                    :title="userEmail"
                                >
                                    {{ userEmail }}
                                </p>
                            </div>
                            <div class="px-2 space-y-1">
                                <router-link
                                    to="/admin/profile"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-slate-300 rounded-lg hover:bg-slate-800 hover:text-white transition-colors group"
                                    @click="isDropdownOpen = false"
                                >
                                    <User
                                        class="w-4 h-4 mr-3 text-slate-500 group-hover:text-blue-400"
                                    />
                                    Profile
                                </router-link>
                                <router-link
                                    to="/admin/settings"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-slate-300 rounded-lg hover:bg-slate-800 hover:text-white transition-colors group"
                                    @click="isDropdownOpen = false"
                                >
                                    <Settings
                                        class="w-4 h-4 mr-3 text-slate-500 group-hover:text-blue-400"
                                    />
                                    Settings
                                </router-link>
                            </div>
                            <div
                                class="border-t border-slate-800 my-2 mx-2"
                            ></div>
                            <div class="px-2">
                                <button
                                    @click="logout"
                                    class="w-full flex items-center px-3 py-2 text-sm font-bold text-rose-400 rounded-lg hover:bg-rose-500/10 hover:text-rose-300 transition-colors group"
                                >
                                    <LogOut
                                        class="w-4 h-4 mr-3 group-hover:animate-pulse"
                                    />
                                    Sign out
                                </button>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import {
    ref,
    computed,
    onMounted,
    onUnmounted,
    defineEmits,
    nextTick,
} from "vue";
import { useRouter, useRoute } from "vue-router";
import api from "../services/api";
import { useToast } from "vue-toastification";
import {
    Bell,
    Search,
    Menu,
    ChevronDown,
    LogOut,
    User,
    Settings,
    X,
    Layers,
    Award,
    FileText,
    Mail,
} from "lucide-vue-next";

const emit = defineEmits(["toggleSidebar"]);
const emitToggle = () => emit("toggleSidebar");

const toast = useToast();
const router = useRouter();
const route = useRoute();

// States
const isDropdownOpen = ref(false);
const isNotificationOpen = ref(false);
const isSearchOpen = ref(false);
const isLoading = ref(false);

const dropdownRef = ref(null);
const notificationRef = ref(null);
const mobileSearchInput = ref(null);

const userAvatar = ref(null);
const userName = ref("Admin");
const userEmail = ref("admin@example.com");

// Search State
const searchQuery = ref("");
const searchResults = ref([]);
let searchTimeout = null;

// Notification State
const unreadCount = ref(0);
const notifications = ref([]);
let notificationInterval = null;

const currentRouteName = computed(() =>
    route.name ? route.name.toString().replace("-", " ") : "Dashboard"
);

// Helper: Search Result Colors
const getTypeColor = (type) => {
    if (type === "Project") return "text-blue-400";
    if (type === "Skill") return "text-emerald-400";
    if (type === "Blog") return "text-purple-400";
    return "text-slate-400";
};

// Toggles
const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
    isNotificationOpen.value = false;
};
const toggleNotification = () => {
    isNotificationOpen.value = !isNotificationOpen.value;
    isDropdownOpen.value = false;
};

const closeDropdowns = (e) => {
    if (dropdownRef.value && !dropdownRef.value.contains(e.target))
        isDropdownOpen.value = false;
    if (notificationRef.value && !notificationRef.value.contains(e.target))
        isNotificationOpen.value = false;
};

/* -----------------------------
   🔎 Search Logic
----------------------------- */
const handleSearch = () => {
    clearTimeout(searchTimeout);

    if (!searchQuery.value || searchQuery.value.length < 2) {
        searchResults.value = [];
        return;
    }

    isLoading.value = true;
    searchTimeout = setTimeout(async () => {
        try {
            const res = await api.get("/api/admin/global-search", {
                params: { q: searchQuery.value },
            });
            searchResults.value = res.data || [];
        } catch (e) {
            console.error("Search failed", e);
            searchResults.value = [];
        } finally {
            isLoading.value = false;
        }
    }, 300);
};

const clearSearch = () => {
    searchQuery.value = "";
    searchResults.value = [];
};

const navigateTo = (url) => {
    router.push(url);
    clearSearch();
    isSearchOpen.value = false;
};

const openSearch = async () => {
    isSearchOpen.value = true;
    await nextTick();
    if (mobileSearchInput.value) mobileSearchInput.value.focus();
};

const closeSearch = () => {
    isSearchOpen.value = false;
    clearSearch();
};

/* -----------------------------
   🔔 Notifications
----------------------------- */
const fetchNotifications = async () => {
    try {
        const res = await api.get("/api/admin/notifications");
        if (res.data) {
            unreadCount.value = res.data.count || 0;
            notifications.value = res.data.messages || [];
        }
    } catch (e) {}
};

/* -----------------------------
   👤 User & Avatar Logic
----------------------------- */
const loadUserAvatar = async () => {
    try {
        const res = await api.get("/api/admin/settings");
        const data = Array.isArray(res.data)
            ? res.data[0]
            : res.data.data || res.data;
        if (data && data.profile_image) {
            const path = data.profile_image;
            userAvatar.value = path.startsWith("http")
                ? path
                : `http://127.0.0.1:8000${path}`;
        }
    } catch (e) {}
};

const updateUserInfo = () => {
    userName.value = localStorage.getItem("admin_name") || "Admin";
    userEmail.value =
        localStorage.getItem("admin_email") || "admin@example.com";
};

onMounted(() => {
    document.addEventListener("click", closeDropdowns);
    loadUserAvatar();
    updateUserInfo();
    fetchNotifications();

    // Poll notifications every 15s
    notificationInterval = setInterval(fetchNotifications, 15000);

    window.addEventListener("profile-updated", () => {
        updateUserInfo();
        loadUserAvatar();
    });
});

onUnmounted(() => {
    document.removeEventListener("click", closeDropdowns);
    window.removeEventListener("profile-updated", updateUserInfo);
    if (notificationInterval) clearInterval(notificationInterval);
});

const logout = async () => {
    localStorage.removeItem("token");
    localStorage.removeItem("admin_name");
    localStorage.removeItem("admin_email");
    router.push("/");
    toast.success("See you again soon!", { timeout: 2000 });
};
</script>

<style scoped>
@keyframes swing {
    0%,
    100% {
        transform: rotate(0deg);
    }
    20% {
        transform: rotate(15deg);
    }
    40% {
        transform: rotate(-10deg);
    }
    60% {
        transform: rotate(5deg);
    }
    80% {
        transform: rotate(-5deg);
    }
}
.animate-swing {
    animation: swing 0.5s ease-in-out;
}
.animate-fade-in {
    animation: fadeIn 0.2s ease-out;
}
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.98);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease, transform 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(5px) scale(0.95);
}
</style>
