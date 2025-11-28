<template>
    <aside
        class="fixed left-0 top-0 h-screen bg-slate-900 border-r border-slate-800/60 text-slate-300 flex flex-col shadow-2xl z-50 transition-all duration-300 ease-in-out"
        :class="isOpen ? 'w-72' : 'w-20'"
    >
        <div
            class="h-20 flex items-center justify-between px-0 border-b border-slate-800/60 relative overflow-hidden transition-all duration-300"
        >
            <div
                v-if="isOpen"
                class="flex items-center gap-3 px-6 transition-opacity duration-300"
            >
                <div
                    class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/20 shrink-0"
                >
                    A
                </div>
                <h2
                    class="text-xl font-bold text-white tracking-wide whitespace-nowrap"
                >
                    Admin<span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400"
                        >Panel</span
                    >
                </h2>
            </div>

            <div v-else class="w-full flex justify-center">
                <div
                    class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shrink-0"
                >
                    A
                </div>
            </div>

            <button
                @click="emitToggle"
                class="absolute right-3 p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors"
                :class="!isOpen ? 'hidden' : 'block'"
            >
                <AlignLeft class="w-6 h-6" />
            </button>
        </div>

        <div
            v-if="!isOpen"
            class="w-full flex justify-center py-4 border-b border-slate-800/60"
        >
            <button
                @click="emitToggle"
                class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors"
            >
                <AlignJustify class="w-6 h-6" />
            </button>
        </div>

        <nav
            class="flex-1 overflow-y-auto py-6 space-y-2 custom-scrollbar px-3"
        >
            <router-link
                v-for="item in menuItems"
                :key="item.name"
                :to="item.path"
                class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300 group font-medium text-sm relative overflow-hidden"
                :class="isOpen ? '' : 'justify-center'"
                active-class="!bg-blue-600 !text-white shadow-lg shadow-blue-600/20"
            >
                <component
                    :is="item.icon"
                    class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 shrink-0"
                    :class="
                        $route.path.includes(item.path)
                            ? 'text-white'
                            : 'text-slate-500 group-hover:text-blue-400'
                    "
                />

                <span
                    v-if="isOpen"
                    class="relative z-10 whitespace-nowrap transition-opacity duration-200"
                >
                    {{ item.name }}
                </span>

                <div
                    v-if="!isOpen"
                    class="absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap border border-slate-700 shadow-xl"
                >
                    {{ item.name }}
                </div>

                <ChevronRight
                    v-if="isOpen && $route.path.includes(item.path)"
                    class="w-4 h-4 ml-auto opacity-100 transition-all shrink-0"
                />
            </router-link>
        </nav>

        <div
            class="p-4 border-t border-slate-800/60 bg-slate-900/50 overflow-hidden"
        >
            <div
                class="flex items-center gap-3 px-2 py-2 rounded-xl bg-slate-800/40 border border-slate-700/30 mb-3"
                :class="
                    isOpen ? '' : 'justify-center border-0 bg-transparent p-0'
                "
            >
                <div
                    class="w-8 h-8 rounded-full bg-gradient-to-tr from-slate-700 to-slate-600 flex items-center justify-center text-xs text-white font-bold ring-2 ring-slate-800 shrink-0"
                >
                    AD
                </div>

                <div
                    v-if="isOpen"
                    class="flex-1 min-w-0 transition-opacity duration-300"
                >
                    <p class="text-sm font-bold text-white truncate">Admin</p>
                    <p class="text-[10px] text-slate-400 truncate">
                        admin@example.com
                    </p>
                </div>
            </div>

            <button
                @click="handleLogout"
                class="flex items-center justify-center gap-2 w-full px-4 py-2 text-xs font-bold text-red-400 uppercase tracking-wider rounded-lg hover:bg-red-500/10 hover:text-red-300 transition-all duration-200 border border-transparent hover:border-red-500/20"
            >
                <LogOut class="w-4 h-4 shrink-0" />
                <span v-if="isOpen" class="whitespace-nowrap">Sign Out</span>
            </button>
        </div>
    </aside>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";
import { useRouter } from "vue-router";
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
    AlignLeft,
    AlignJustify,
} from "lucide-vue-next";

// Props & Emits
const props = defineProps({
    isOpen: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(["toggleSidebar"]);

const emitToggle = () => {
    emit("toggleSidebar");
};

const router = useRouter();

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
.custom-scrollbar::-webkit-scrollbar {
    width: 0px; /* Hide scrollbar for cleaner look in sidebar */
}
</style>
