<template>
    <header
        class="sticky top-0 z-40 w-full bg-white/80 backdrop-blur-md border-b border-slate-200 shadow-sm transition-all duration-300"
    >
        <div class="flex items-center justify-between h-16 px-6">
            <div class="flex items-center gap-4">
                <button
                    class="lg:hidden p-2 text-slate-500 hover:text-slate-700"
                >
                    <Menu class="w-6 h-6" />
                </button>

                <div>
                    <h1
                        class="text-xl font-bold text-slate-800 capitalize tracking-tight"
                    >
                        {{ currentRouteName }}
                    </h1>
                    <p class="text-xs text-slate-500 hidden sm:block">
                        Welcome back, Admin
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div
                    class="hidden md:flex items-center bg-slate-100 rounded-full px-4 py-2 border border-slate-200 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all"
                >
                    <Search class="w-4 h-4 text-slate-400" />
                    <input
                        type="text"
                        placeholder="Search..."
                        class="bg-transparent border-none text-sm ml-2 w-48 focus:outline-none text-slate-600 placeholder:text-slate-400"
                    />
                </div>

                <button
                    class="relative p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors"
                >
                    <Bell class="w-5 h-5" />
                    <span
                        class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"
                    ></span>
                </button>

                <div class="h-8 w-px bg-slate-200 mx-1"></div>

                <div class="relative" ref="dropdownRef">
                    <button
                        @click="toggleDropdown"
                        class="flex items-center gap-3 p-1 rounded-full hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-200"
                    >
                        <img
                            src="https://ui-avatars.com/api/?name=Admin+User&background=0D8ABC&color=fff"
                            alt="Avatar"
                            class="w-9 h-9 rounded-full object-cover shadow-sm"
                        />

                        <div class="hidden md:flex flex-col items-start pr-2">
                            <span
                                class="text-sm font-semibold text-slate-700 leading-none"
                                >Admin</span
                            >
                            <span class="text-[10px] text-slate-500 font-medium"
                                >Super Admin</span
                            >
                        </div>

                        <ChevronDown
                            class="w-4 h-4 text-slate-400 hidden md:block"
                        />
                    </button>

                    <transition
                        enter-active-class="transition ease-out duration-200"
                        enter-from-class="transform opacity-0 scale-95"
                        enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95"
                    >
                        <div
                            v-if="isDropdownOpen"
                            class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl border border-slate-100 py-2 origin-top-right ring-1 ring-black ring-opacity-5 focus:outline-none"
                        >
                            <div
                                class="px-4 py-3 border-b border-slate-100 mb-2"
                            >
                                <p class="text-sm font-medium text-slate-900">
                                    Signed in as
                                </p>
                                <p class="text-xs text-slate-500 truncate">
                                    admin@example.com
                                </p>
                            </div>

                            <a
                                href="/admin/settings"
                                class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors"
                            >
                                <User class="w-4 h-4 mr-3" /> Profile
                            </a>
                            <a
                                href="/admin/settings"
                                class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors"
                            >
                                <Settings class="w-4 h-4 mr-3" /> Settings
                            </a>

                            <div class="border-t border-slate-100 my-2"></div>

                            <button
                                @click="logout"
                                class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                            >
                                <LogOut class="w-4 h-4 mr-3" /> Sign out
                            </button>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
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
} from "lucide-vue-next";

const toast = useToast();
const router = useRouter();
const route = useRoute();

const isDropdownOpen = ref(false);
const dropdownRef = ref(null);

// Get current route name for the header title
const currentRouteName = computed(() => {
    return route.name ? route.name.toString().replace("-", " ") : "Dashboard";
});

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

// Close dropdown if clicked outside
const closeDropdown = (e) => {
    if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
        isDropdownOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener("click", closeDropdown);
});

onUnmounted(() => {
    document.removeEventListener("click", closeDropdown);
});

const logout = async () => {
    try {
        // Optional: Call backend logout API
        // await api.post("/api/admin/logout");

        localStorage.removeItem("token");
        toast.success("See you again soon!", {
            timeout: 2000,
        });

        // Push to login
        router.push("/");
    } catch (error) {
        // Force logout even if API fails (good UX)
        localStorage.removeItem("token");
        router.push("/");
        toast.error("Logout failed, but you were signed out locally.");
    }
};
</script>
