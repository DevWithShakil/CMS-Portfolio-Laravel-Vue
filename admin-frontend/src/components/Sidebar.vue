<template>
    <aside
        class="fixed left-0 top-0 h-screen w-72 bg-slate-900 border-r border-slate-800/60 text-slate-300 flex flex-col shadow-2xl z-50 transition-all duration-300"
    >
        <div
            class="h-20 flex items-center px-8 border-b border-slate-800/60 relative overflow-hidden"
        >
            <div
                class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-blue-600/5 to-transparent pointer-events-none"
            ></div>

            <div class="flex items-center gap-3 relative z-10">
                <div
                    class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/20"
                >
                    <span class="text-lg">A</span>
                </div>
                <h2 class="text-xl font-bold text-white tracking-wide">
                    Admin<span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400"
                        >Panel</span
                    >
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
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-300 group font-medium text-sm relative overflow-hidden"
                active-class="!bg-blue-600 !text-white shadow-lg shadow-blue-600/20"
                :class="{
                    'text-slate-400 hover:bg-slate-800 hover:text-white':
                        !$route.path.includes(item.path),
                }"
            >
                <div
                    v-if="!$route.path.includes(item.path)"
                    class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                ></div>

                <component
                    :is="item.icon"
                    class="w-5 h-5 transition-transform duration-300 group-hover:scale-110"
                    :class="
                        $route.path.includes(item.path)
                            ? 'text-white'
                            : 'text-slate-500 group-hover:text-blue-400'
                    "
                />

                <span class="relative z-10">{{ item.name }}</span>

                <ChevronRight
                    v-if="$route.path.includes(item.path)"
                    class="w-4 h-4 ml-auto opacity-100 transition-all"
                />
            </router-link>
        </nav>

        <div class="p-4 border-t border-slate-800/60 bg-slate-900/50">
            <div
                class="flex items-center gap-3 px-3 py-3 rounded-xl bg-slate-800/40 border border-slate-700/30 mb-3"
            >
                <div
                    class="w-9 h-9 rounded-full bg-gradient-to-tr from-slate-700 to-slate-600 flex items-center justify-center text-xs text-white font-bold ring-2 ring-slate-800"
                >
                    AD
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white truncate">
                        Admin User
                    </p>
                    <p class="text-[10px] text-slate-400 truncate">
                        admin@example.com
                    </p>
                </div>
            </div>

            <button
                @click="handleLogout"
                class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-xs font-bold text-red-400 uppercase tracking-wider rounded-lg hover:bg-red-500/10 hover:text-red-300 transition-all duration-200 border border-transparent hover:border-red-500/20"
            >
                <LogOut class="w-4 h-4" />
                <span>Sign Out</span>
            </button>
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
const route = useRoute();

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

const handleLogout = () => {
    localStorage.removeItem("token");
    router.push("/");
};
</script>

<style scoped>
/* Dark Scrollbar Styling */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #1e293b; /* slate-800 */
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #334155; /* slate-700 */
}
</style>
