<template>
    <aside
        class="fixed left-0 top-0 h-screen w-72 bg-slate-900 border-r border-slate-800 text-slate-300 flex flex-col shadow-2xl z-50 transition-all duration-300"
    >
        <div class="h-20 flex items-center px-8 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div
                    class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/30"
                >
                    A
                </div>
                <h2 class="text-xl font-bold text-white tracking-wide">
                    Admin<span class="text-blue-500">Panel</span>
                </h2>
            </div>
        </div>

        <nav
            class="flex-1 overflow-y-auto py-6 px-4 space-y-2 custom-scrollbar"
        >
            <router-link
                v-for="item in menuItems"
                :key="item.name"
                :to="item.path"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group font-medium text-sm"
                active-class="bg-blue-600 text-white shadow-lg shadow-blue-500/30 translate-x-1"
                :class="{
                    'hover:bg-slate-800 hover:text-white hover:translate-x-1':
                        !$route.path.includes(item.path),
                }"
            >
                <component
                    :is="item.icon"
                    class="w-5 h-5 transition-colors"
                    :class="
                        $route.path.includes(item.path)
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white'
                    "
                />

                <span>{{ item.name }}</span>

                <ChevronRight
                    v-if="$route.path.includes(item.path)"
                    class="w-4 h-4 ml-auto opacity-70"
                />
            </router-link>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <button
                @click="handleLogout"
                class="flex items-center gap-3 w-full px-4 py-3 text-sm font-medium text-red-400 rounded-xl hover:bg-red-500/10 hover:text-red-300 transition-all duration-200"
            >
                <LogOut class="w-5 h-5" />
                <span>Logout</span>
            </button>

            <div class="mt-4 flex items-center gap-3 px-2">
                <div
                    class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-xs text-white"
                >
                    AD
                </div>
                <div>
                    <p class="text-xs font-bold text-white">Admin User</p>
                    <p class="text-[10px] text-slate-500">admin@example.com</p>
                </div>
            </div>
        </div>
    </aside>
</template>

<script setup>
import {
    LayoutDashboard,
    Briefcase,
    Award,
    Clock,
    GraduationCap,
    Contact,
    Settings,
    FileText,
    LogOut,
    ChevronRight,
} from "lucide-vue-next";
import { useRouter, useRoute } from "vue-router";

const router = useRouter();
const route = useRoute(); // Used for active state logic if needed manually

// Menu Items Configuration
// Ensure paths match your nested router structure ('/admin/...')
const menuItems = [
    { name: "Dashboard", path: "/admin/dashboard", icon: LayoutDashboard },
    { name: "Projects", path: "/admin/projects", icon: Briefcase },
    { name: "Skills", path: "/admin/skills", icon: Award },
    { name: "Experience", path: "/admin/experience", icon: Clock },
    { name: "Education", path: "/admin/education", icon: GraduationCap },
    { name: "Blogs", path: "/admin/blogs", icon: FileText },
    { name: "Contacts", path: "/admin/contacts", icon: Contact },
    { name: "Settings", path: "/admin/settings", icon: Settings },
];

// Logout Handler
const handleLogout = () => {
    // 1. Remove token
    localStorage.removeItem("token");
    // 2. Redirect to login
    router.push("/");
};
</script>

<style scoped>
/* Custom Scrollbar for sleek look */
.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #334155;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #475569;
}
</style>
