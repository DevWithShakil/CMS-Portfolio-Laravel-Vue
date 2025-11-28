<template>
    <header
        class="sticky top-0 z-40 w-full bg-slate-900/80 backdrop-blur-md border-b border-slate-800/60 shadow-sm transition-all duration-300"
    >
        <div
            class="relative flex items-center justify-between h-20 px-4 md:px-6"
        >
            <div
                v-if="isSearchOpen"
                class="absolute inset-0 z-50 flex items-center px-4 bg-slate-900 w-full h-full animate-fade-in"
            >
                <Search class="w-5 h-5 text-blue-500 mr-3 shrink-0" />
                <input
                    ref="mobileSearchInput"
                    type="text"
                    placeholder="Type to search..."
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
                <div
                    class="hidden md:flex items-center bg-slate-800/50 rounded-xl px-4 py-2.5 border border-slate-700/50 focus-within:ring-2 focus-within:ring-blue-500/50 transition-all"
                >
                    <Search class="w-4 h-4 text-slate-400" />
                    <input
                        type="text"
                        placeholder="Search..."
                        class="bg-transparent border-none text-sm ml-3 w-48 focus:outline-none text-slate-200 placeholder:text-slate-500"
                    />
                </div>

                <button
                    @click="openSearch"
                    class="md:hidden p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-colors"
                >
                    <Search class="w-5 h-5" />
                </button>

                <button
                    class="relative p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-all group"
                >
                    <Bell class="w-5 h-5 group-hover:animate-swing" />
                    <span
                        class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full animate-pulse"
                    ></span>
                </button>

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
                                alt="Avatar"
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

                    <transition
                        enter-active-class="transition ease-out duration-200"
                        enter-from-class="transform opacity-0 scale-95 translate-y-2"
                        enter-to-class="transform opacity-100 scale-100 translate-y-0"
                        leave-active-class="transition ease-in duration-150"
                        leave-from-class="transform opacity-100 scale-100 translate-y-0"
                        leave-to-class="transform opacity-0 scale-95 translate-y-2"
                    >
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
} from "lucide-vue-next";

const emit = defineEmits(["toggleSidebar"]);
const emitToggle = () => emit("toggleSidebar");

const toast = useToast();
const router = useRouter();
const route = useRoute();

const isDropdownOpen = ref(false);
const isSearchOpen = ref(false);
const mobileSearchInput = ref(null);
const dropdownRef = ref(null);

const userAvatar = ref(null);
const userName = ref("Admin");
const userEmail = ref("admin@example.com");

const currentRouteName = computed(() =>
    route.name ? route.name.toString().replace("-", " ") : "Dashboard"
);

const toggleDropdown = () => (isDropdownOpen.value = !isDropdownOpen.value);
const closeDropdown = (e) => {
    if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
        isDropdownOpen.value = false;
    }
};

const openSearch = async () => {
    isSearchOpen.value = true;
    await nextTick();
    mobileSearchInput.value?.focus();
};
const closeSearch = () => {
    isSearchOpen.value = false;
};

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
    document.addEventListener("click", closeDropdown);
    loadUserAvatar();
    updateUserInfo();
    window.addEventListener("profile-updated", () => {
        updateUserInfo();
        loadUserAvatar();
    });
});

onUnmounted(() => {
    document.removeEventListener("click", closeDropdown);
    window.removeEventListener("profile-updated", updateUserInfo);
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
</style>
